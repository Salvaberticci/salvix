@extends('layouts.app')
@section('title', 'Verificar Pagos')
@section('header_title', 'Administración de Pagos')

@section('content')
<div x-data="pagoAdmin()">
    <x-card>
        <div style="overflow-x:auto;">
            <table role="grid" style="width:100%;">
                <thead>
                    <tr>
                        <th>N° Pedido</th>
                        <th>Fecha</th>
                        <th>Método</th>
                        <th>Referencia</th>
                        <th>Monto (Bs)</th>
                        <th>Monto (USD)</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                    <tr style="border-left: 3px solid {{ $pago->estado === 'pendiente' ? 'var(--color-warning)' : ($pago->estado === 'confirmado' ? 'var(--color-success)' : 'var(--color-red)') }}">
                        <td><strong>#{{ str_pad($pago->pedido_id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ $pago->created_at->format('d/m/Y h:i A') }}</td>
                        <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $pago->metodo) }}</td>
                        <td>{{ $pago->referencia ?: 'N/D' }}</td>
                        <td><strong>Bs {{ number_format($pago->monto_bs, 2) }}</strong><br><small style="color:var(--color-muted);">Tasa: {{ $pago->tasa_bcv }}</small></td>
                        <td>${{ number_format($pago->monto_usd, 2) }}</td>
                        <td>
                            @if($pago->estado == 'pendiente')
                                <span class="badge badge-warning">Pendiente</span>
                            @elseif($pago->estado == 'confirmado')
                                <span class="badge badge-success">Confirmado</span>
                            @else
                                <span class="badge badge-error" style="background:var(--color-red); color:white;">Rechazado</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn-standard" style="padding:2px 10px; font-size:0.8rem;" @click="openModal({{ $pago->id }})">Verificar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    <!-- Modal Verificacion -->
    <dialog x-bind:open="modalOpen">
        <article style="max-width:500px; width:100%;">
            <header>
                <a href="#close" aria-label="Close" class="close" @click.prevent="modalOpen = false"></a>
                Verificación de Pago
            </header>
            
            <div x-show="loading" style="text-align:center; padding:20px;">Cargando detalles...</div>
            
            <div x-show="!loading && currentPago">
                <template x-if="currentPago.comprobante_imagen">
                    <div style="text-align:center; margin-bottom:15px;">
                        <span style="display:block; font-size:0.8rem; margin-bottom:5px;">Capture Suministrado:</span>
                        <a :href="'{{ asset('storage') }}/' + currentPago.comprobante_imagen" target="_blank">
                            <img :src="'{{ asset('storage') }}/' + currentPago.comprobante_imagen" style="max-width:100%; max-height:300px; border:1px solid #ddd;">
                        </a>
                    </div>
                </template>
                <template x-if="!currentPago.comprobante_imagen">
                    <div style="text-align:center; padding:20px; background:#f5f5f5; margin-bottom:15px; color:#888;">
                        Sin imagen de comprobante adjunta.
                    </div>
                </template>

                <div style="font-size:0.9rem; margin-bottom:20px; background:var(--color-surface); padding:15px; border:1px solid var(--color-border); color:white;">
                    <div class="grid">
                        <div>
                            <strong style="color:var(--color-gold);">📦 Entrega:</strong><br>
                            <span x-text="currentPago.pedido?.cliente_nombre"></span><br>
                            <span x-text="currentPago.pedido?.cliente_telefono"></span><br>
                            <small x-text="currentPago.pedido?.tipo_entrega == 'delivery' ? 'Dirección: ' + currentPago.pedido?.direccion : 'Retiro en Tienda'"></small>
                        </div>
                        <div style="text-align:right;">
                            <strong style="color:var(--color-gold);">💰 Pago:</strong><br>
                            Bs <span x-text="currentPago.monto_bs"></span><br>
                            Ref: <span x-text="currentPago.referencia || 'N/A'"></span><br>
                            <small x-text="currentPago.cuenta_bancaria?.alias || 'Caja Efectivo'"></small>
                        </div>
                    </div>
                </div>

                <form :action="'{{ url('/pagos') }}/' + currentPago.id" method="POST">
                    @csrf @method('PUT')
                    
                    <div style="margin-bottom:15px;" x-show="currentPago.estado == 'pendiente'">
                        <label>Veredicto</label>
                        <select name="estado" required>
                            <option value="confirmado">Confirmar y Enviar a Cocina</option>
                            <option value="rechazado">Monto no concuerda / Rechazar</option>
                        </select>
                    </div>
                    
                    <div x-show="currentPago.estado != 'pendiente'" style="background:var(--color-surface); padding:10px; text-align:center; color:var(--color-black); font-weight:bold; margin-bottom:15px;">
                        Este pago ya fue procesado.
                    </div>

                    <footer style="display:flex; justify-content:space-between;">
                        <button type="button" class="btn-standard" @click="modalOpen = false">Cerrar</button>
                        <button type="submit" class="btn-critical" x-show="currentPago.estado == 'pendiente'">Procesar Confirmación</button>
                    </footer>
                </form>
            </div>
        </article>
    </dialog>
</div>
@endsection

@section('scripts')
<script>
function pagoAdmin() {
    return {
        modalOpen: false,
        loading: false,
        currentPago: null,

        openModal(id) {
            this.modalOpen = true;
            this.loading = true;
            
            fetch(`{{ url('/pagos') }}/${id}`)
                .then(r => r.json())
                .then(data => {
                    this.currentPago = data;
                    this.loading = false;
                });
        }
    }
}
</script>
@endsection
