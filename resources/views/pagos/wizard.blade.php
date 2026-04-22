@extends('layouts.public')
@section('title', 'Finalizar Pago')

@section('content')
<div x-data="checkoutWizard()" x-init="init()" style="max-width: 600px; margin: 0 auto;">
    
    <div style="text-align:center; margin-bottom: 30px;">
        <h2 style="margin:0;">Finalizar Pedido</h2>
        <span class="label-editorial">Sigue los pasos para procesar tu pago</span>
    </div>

    <!-- Módulo Alpine si el carrito está vacío -->
    <div x-show="cart.length === 0" style="text-align:center; padding: 40px; background:var(--color-surface); color:white; display:none;">
        <i class="ph ph-shopping-cart" style="font-size:3rem; margin-bottom:10px;"></i>
        <h3>Tu carrito está vacío</h3>
        <a href="{{ route('catalogo.index') }}" class="btn-standard" style="color:white; border-color:white; text-decoration:none; padding:10px 20px;">Volver al Menú</a>
    </div>

    <form x-show="cart.length > 0" action="{{ route('pagos.procesar') }}" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm">
        @csrf
        <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
        <input type="hidden" name="tasa_bcv" value="{{ $tasaBcv }}">
        <input type="hidden" name="metodo" :value="selectedMethod">

        <!-- Paso 1: Resumen -->
        <x-card x-show="step === 1" class="gsap-step">
            <h3 style="margin-top:0; border-bottom:1px solid var(--color-border); padding-bottom:10px;">1. Resumen de tu pedido</h3>
            <ul style="list-style:none; padding:0; margin:15px 0;">
                <template x-for="item in cart">
                    <li style="display:flex; justify-content:space-between; margin-bottom:10px; font-size:0.9rem;">
                        <span x-text="item.qty + 'x ' + item.name"></span>
                        <span x-text="'$' + (item.price * item.qty).toFixed(2)"></span>
                    </li>
                </template>
            </ul>
            <hr style="margin:15px 0;">
            <div style="display:flex; justify-content:space-between; font-size:1.2rem;">
                <strong>Total a Pagar:</strong>
                <div style="text-align:right;">
                    <strong style="color:var(--color-gold);" x-text="'$ ' + totalUsd.toFixed(2)"></strong><br>
                    <span style="font-size:0.9rem; color:var(--color-muted);" x-text="'Bs ' + totalBs.toFixed(2)"></span>
                </div>
            </div>
            <button type="button" class="btn-critical" style="width:100%; margin-top:20px;" @click="step = 2">Continuar</button>
        </x-card>

        <!-- Paso 2: Datos de Entrega -->
        <x-card x-show="step === 2" class="gsap-step" style="display:none;">
            <h3 style="margin-top:0; border-bottom:1px solid var(--color-border); padding-bottom:10px;">2. Datos de Entrega</h3>
            
            <div style="margin-top:15px;">
                <label>Nombre Completo</label>
                <input type="text" name="cliente_nombre" required placeholder="Ej: Juan Pérez">
            </div>

            <div style="margin-top:15px;">
                <label>Teléfono de Contacto</label>
                <input type="text" name="cliente_telefono" required placeholder="Ej: 0412 1234567">
            </div>

            <div style="margin-top:15px;">
                <label>Tipo de Entrega</label>
                <select name="tipo_entrega" x-model="tipoEntrega">
                    <option value="delivery">A Domicilio (Delivery)</option>
                    <option value="retiro">Retiro en Tienda</option>
                </select>
            </div>

            <div style="margin-top:15px;" x-show="tipoEntrega === 'delivery'">
                <label>Dirección Detallada</label>
                <textarea name="direccion" placeholder="Calle, edificio, punto de referencia..."></textarea>
            </div>

            <div style="display:flex; justify-content:space-between; margin-top:20px;">
                <button type="button" class="btn-standard" @click="step = 1">Volver</button>
                <button type="button" class="btn-critical" @click="step = 3">Continuar al Pago</button>
            </div>
        </x-card>

        <!-- Paso 3: Seleccionar Método de Pago -->
        <x-card x-show="step === 3" class="gsap-step" style="display:none;">
            <h3 style="margin-top:0; border-bottom:1px solid var(--color-border); padding-bottom:10px;">3. Selecciona cómo vas a pagar</h3>
            
            <div style="display:flex; flex-direction:column; gap:10px; margin-top:15px;">
                @foreach($cuentas as $cuenta)
                <label style="border:1px solid var(--color-border); padding:15px; border-radius:2px; display:flex; align-items:flex-start; cursor:pointer;" :class="selectedAccount == {{ $cuenta->id }} ? 'chiaroscuro-dark' : ''">
                    <input type="radio" name="cuenta_bancaria_id" value="{{ $cuenta->id }}" @change="selectMethod('{{ $cuenta->tipo_operacion }}', {{ $cuenta->id }})" style="margin-right:15px; margin-top:5px;">
                    <div>
                        <strong style="font-size:1.1rem; display:block;">{{ $cuenta->alias }}</strong>
                        <span style="font-size:0.8rem;">{{ $cuenta->banco }}</span>
                        @if($cuenta->tipo_operacion == 'pago_movil' || $cuenta->tipo_operacion == 'transferencia')
                            <div style="font-size:0.8rem; margin-top:10px; background:rgba(128,128,128,0.1); padding:10px;">
                                @if($cuenta->telefono) Celular: {{ $cuenta->telefono }}<br> @endif
                                @if($cuenta->cedula) CI/RIF: {{ $cuenta->cedula }}<br> @endif
                                @if($cuenta->numero_cuenta) N° Cuenta: {{ $cuenta->numero_cuenta }}<br> @endif
                                <strong style="color:var(--color-gold); font-size:1.1rem; display:block; margin-top:5px;">Monto: <span x-text="'Bs ' + totalBs.toFixed(2)"></span></strong>
                            </div>
                        @else
                            <div style="font-size:0.8rem; margin-top:10px;">
                                <strong style="color:var(--color-gold); font-size:1.1rem;">Monto: <span x-text="'$ ' + totalUsd.toFixed(2)"></span></strong>
                            </div>
                        @endif
                    </div>
                </label>
                @endforeach
            </div>

            <div style="display:flex; justify-content:space-between; margin-top:20px;">
                <button type="button" class="btn-standard" @click="step = 2">Volver</button>
                <button type="button" class="btn-critical" @click="step = 4" x-bind:disabled="!selectedMethod">Finaizar y Reportar</button>
            </div>
        </x-card>

        <!-- Paso 4: Reporte de Pago -->
        <x-card x-show="step === 4" class="gsap-step" style="display:none;">
            <h3 style="margin-top:0; border-bottom:1px solid var(--color-border); padding-bottom:10px;">4. Confirma tu Pago</h3>
            
            <div x-show="selectedMethod == 'pago_movil' || selectedMethod == 'transferencia'">
                <div style="margin-top:15px;">
                    <label>N° de Referencia (Últimos 4 o 6 dígitos)</label>
                    <input type="text" name="referencia" id="ref_input" placeholder="Ej: 1234">
                </div>
                
                <div style="margin-top:15px;">
                    <label>Sube un Capture o Comprobante</label>
                    <input type="file" name="comprobante_imagen" accept="image/*" id="comp_img">
                </div>
            </div>

            <div x-show="selectedMethod == 'efectivo_usd' || selectedMethod == 'efectivo_bs'">
                <p style="color:var(--color-muted); text-align:center; padding:20px;">
                    Has seleccionado pago en efectivo. Por favor, entrega el monto exacto al repartidor o en caja.
                </p>
            </div>

            <div style="display:flex; justify-content:space-between; margin-top:20px;">
                <button type="button" class="btn-standard" @click="step = 3">Volver</button>
                <button type="submit" class="btn-critical" id="btn-submit">Enviar Pedido Ahora</button>
            </div>
        </x-card>
    </form>
</div>
@endsection

@section('scripts')
<script>
function checkoutWizard() {
    return {
        cart: [],
        step: 1,
        selectedMethod: '',
        selectedAccount: null,
        tipoEntrega: 'delivery',
        tasaBcv: {{ $tasaBcv }},
        
        init() {
            const saved = localStorage.getItem('salvix_cart');
            if (saved) {
                this.cart = JSON.parse(saved);
            }
        },

        get totalUsd() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },

        get totalBs() {
            return this.totalUsd * this.tasaBcv;
        },

        selectMethod(method, id) {
            this.selectedMethod = method;
            this.selectedAccount = id;
        },
        
        submitForm(e) {
            if(this.selectedMethod === 'pago_movil' || this.selectedMethod === 'transferencia') {
                let ref = document.getElementById('ref_input').value;
                let file = document.getElementById('comp_img').value;
                if(!ref && !file) {
                    window.notify("Debe proveer una referencia O una captura de pantalla.", "error");
                    return false;
                }
            }
            
            document.getElementById('btn-submit').innerHTML = "Procesando...";
            document.getElementById('btn-submit').setAttribute('disabled', 'disabled');
            
            // Clean localstorage before submitting
            localStorage.removeItem('salvix_cart');
            e.target.submit();
        }
    }
}
</script>
@endsection
