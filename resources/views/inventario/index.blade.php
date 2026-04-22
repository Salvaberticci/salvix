@extends('layouts.app')
@section('title', 'Inventario')
@section('header_title', 'Control de Inventario')

@section('content')
<div class="grid" style="grid-template-columns: 2fr 1fr; gap: 20px;">
    <!-- Lista de Ingredientes y Stock -->
    <x-card>
        <x-slot name="header">
            <h3 style="margin:0; font-size: 1.2rem;">Existencias Actuales</h3>
        </x-slot>
        
        <div style="overflow-x:auto;" x-data="{ adjustModalOpen: false, selectedId: null, selectedName: '' }">
            <table role="grid" style="width:100%; font-size:0.9rem;">
                <thead>
                    <tr>
                        <th>Ingrediente</th>
                        <th>Stock Actual</th>
                        <th>Mínimo</th>
                        <th>Costo Est.</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ingredientes as $ing)
                    <tr>
                        <td><strong>{{ $ing->nombre }}</strong> ({{ $ing->unidad }})</td>
                        <td>
                            @if($ing->stock_actual <= $ing->stock_minimo)
                                <span style="color:var(--color-warning); font-weight:bold;">{{ $ing->stock_actual }}</span>
                            @else
                                <span style="color:var(--color-success); font-weight:bold;">{{ $ing->stock_actual }}</span>
                            @endif
                        </td>
                        <td>{{ $ing->stock_minimo }}</td>
                        <td>${{ number_format($ing->costo_usd, 2) }}</td>
                        <td>
                            <button class="btn-standard" style="padding:2px 8px; font-size:0.8rem;" @click="adjustModalOpen = true; selectedId = {{ $ing->id }}; selectedName = '{{ $ing->nombre }}'">Ajustar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal de Ajuste -->
            <dialog x-bind:open="adjustModalOpen">
                <article>
                    <header>
                        <a href="#close" aria-label="Close" class="close" @click.prevent="adjustModalOpen = false"></a>
                        Ajustar Stock: <strong x-text="selectedName"></strong>
                    </header>
                    <form :action="'{{ url('/inventario') }}/' + selectedId" method="POST">
                        @csrf @method('PUT')
                        <div class="grid">
                            <div>
                                <label>Tipo de Ajuste</label>
                                <select name="tipo" required>
                                    <option value="entrada">Entrada (+)</option>
                                    <option value="salida">Salida (-)</option>
                                    <option value="merma">Merma (-)</option>
                                </select>
                            </div>
                            <div>
                                <label>Cantidad</label>
                                <input type="number" step="0.01" name="cantidad" required min="0.01">
                            </div>
                        </div>
                        <div>
                            <label>Motivo (Ej: Compra, Dañado, etc.)</label>
                            <input type="text" name="motivo">
                        </div>
                        <footer style="margin-top:20px; text-align:right;">
                            <button type="button" class="btn-standard" @click="adjustModalOpen = false">Cancelar</button>
                            <button type="submit" class="btn-critical">Registrar Ajuste</button>
                        </footer>
                    </form>
                </article>
            </dialog>

        </div>
    </x-card>

    <div style="display:flex; flex-direction:column; gap:20px;">
        <!-- Agregar Nuevo Ingrediente -->
        <x-card>
            <x-slot name="header">
                <h3 style="margin:0; font-size: 1.2rem;">Nuevo Ingrediente</h3>
            </x-slot>
            <form action="{{ route('inventario.store') }}" method="POST">
                @csrf
                <div style="margin-bottom:10px;">
                    <label style="font-size:0.9rem;">Nombre</label>
                    <input type="text" name="nombre" required>
                </div>
                <div class="grid" style="margin-bottom:10px;">
                    <div>
                        <label style="font-size:0.9rem;">Unidad</label>
                        <select name="unidad" required>
                            <option value="kg">Kilogramos</option>
                            <option value="lb">Libras</option>
                            <option value="litro">Litros</option>
                            <option value="ml">Mililitros</option>
                            <option value="unidad">Unidades</option>
                            <option value="docena">Docenas</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.9rem;">Costo USD</label>
                        <input type="number" step="0.01" name="costo_usd" value="0.00">
                    </div>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="font-size:0.9rem;">Stock Mínimo (Alerta)</label>
                    <input type="number" step="0.01" name="stock_minimo" value="0">
                </div>
                <button type="submit" class="btn-critical" style="width:100%;">Registrar Ingrediente</button>
            </form>
        </x-card>

        <!-- Últimos Movimientos -->
        <x-card>
            <x-slot name="header">
                <h3 style="margin:0; font-size: 1.2rem;">Últimos Movimientos</h3>
            </x-slot>
            <ul style="list-style:none; padding:0; margin:0; font-size:0.8rem;">
                @forelse($movimientos as $mov)
                <li style="border-bottom:1px solid var(--color-border); padding:8px 0; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <strong>{{ $mov->ingrediente->nombre ?? 'N/A' }}</strong><br>
                        <span style="color:var(--color-muted);">{{ $mov->created_at->diffForHumans() }}</span>
                    </div>
                    <div style="text-align:right;">
                        @if($mov->tipo == 'entrada')
                            <span style="color:var(--color-success); font-weight:bold;">+{{ $mov->cantidad }}</span>
                        @else
                            <span style="color:var(--color-warning); font-weight:bold;">-{{ $mov->cantidad }}</span>
                        @endif
                        <br>
                        <span style="color:var(--color-muted); font-size:0.7rem;">{{ ucfirst($mov->tipo) }}</span>
                    </div>
                </li>
                @empty
                <li style="color:var(--color-muted);">Sin movimientos recientes.</li>
                @endforelse
            </ul>
        </x-card>
    </div>
</div>
@endsection
