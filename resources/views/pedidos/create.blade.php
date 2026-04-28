@extends('layouts.app')
@section('title', 'Punto de Venta')
@section('header_title', 'Nuevo Pedido (POS)')

@section('content')
<div x-data="posSystem()" class="grid" style="grid-template-columns: 2fr 1fr; gap: 20px; align-items: flex-start;">
    
    <!-- Lado Izquierdo: Menú -->
    <x-card style="height: calc(100vh - 120px); overflow-y: auto;">
        <div style="display:flex; justify-content:space-between; margin-bottom:20px; position:sticky; top:0; background:var(--color-white); padding-bottom:10px; border-bottom:1px solid var(--color-border); z-index:10;">
            <h3 style="margin:0;">Catálogo de Productos</h3>
            <input type="text" x-model="search" placeholder="Buscar plato..." style="padding: 8px 12px; border: 1px solid var(--color-border); border-radius:2px;">
        </div>

        <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
            @foreach($productos as $prod)
            <div x-show="matchesSearch('{{ strtolower(addslashes($prod->nombre)) }}')" style="border:1px solid var(--color-border); padding:10px; border-radius:2px; display:flex; flex-direction:column; justify-content:space-between; background:var(--color-light-gray);">
                <div>
                    <h4 style="margin:0 0 5px 0; font-size:1rem;">{{ $prod->nombre }}</h4>
                    <span style="color:var(--color-gold); font-weight:bold;">${{ number_format($prod->precio_usd, 2) }}</span>
                </div>
                <button type="button" @click="addToCart({{ $prod->id }}, '{{ addslashes($prod->nombre) }}', {{ $prod->precio_usd }})" class="btn-standard" style="width:100%; margin-top:10px; padding:8px !important; font-size:0.8rem;">
                    Agregar
                </button>
            </div>
            @endforeach
        </div>
    </x-card>

    <!-- Lado Derecho: Ticket / Carrito -->
    <x-card style="background:var(--color-surface); color:var(--color-white); height: calc(100vh - 120px); display:flex; flex-direction:column;">
        <h3 style="margin-top:0; border-bottom:1px solid var(--color-border-dark); padding-bottom:10px; color:var(--color-white);">Ticket Actual</h3>
        
        <div style="flex-grow:1; overflow-y:auto; margin: 10px 0;">
            <template x-if="cart.length === 0">
                <p style="text-align:center; color:var(--color-muted); margin-top:30px;">Sin productos seleccionados</p>
            </template>
            
            <template x-for="item in cart" :key="item.id">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border-dark); padding:10px 0;">
                    <div style="flex:1;">
                        <div x-text="item.name" style="font-size:0.9rem; font-weight:bold;"></div>
                        <div style="font-size:0.8rem; color:var(--color-gold);" x-text="'$'+(item.price * item.qty).toFixed(2)"></div>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <button type="button" @click="updateQty(item.id, -1)" style="padding:2px 8px; background:var(--color-black); color:white; border:none; cursor:pointer;">-</button>
                        <span x-text="item.qty" style="width:20px; text-align:center;"></span>
                        <button type="button" @click="updateQty(item.id, 1)" style="padding:2px 8px; background:var(--color-black); color:white; border:none; cursor:pointer;">+</button>
                    </div>
                </div>
            </template>
        </div>

        <div style="border-top:1px solid var(--color-border-dark); padding-top:15px; margin-bottom:15px;">
            <div style="display:flex; justify-content:space-between; font-size:1.2rem; font-weight:bold; margin-bottom:5px;">
                <span>Total:</span>
                <span x-text="'$' + cartTotal.toFixed(2)"></span>
            </div>
            <div style="display:flex; justify-content:space-between; color:var(--color-muted); font-size:0.9rem;">
                <span>Ref. Bs:</span>
                <span x-text="(cartTotal * {{ $tasaBcv }}).toFixed(2)"></span>
            </div>
        </div>

        <form action="{{ route('pedidos.store') }}" method="POST" id="posForm">
            @csrf
            <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
            <input type="hidden" name="tasa_bcv" value="{{ $tasaBcv }}">
            
            <div style="margin-bottom:10px;">
                <label style="color:var(--color-muted); font-size:0.8rem;">Mesa (Opcional - Local)</label>
                <select name="mesa_id" style="background:var(--color-black); color:white; border:1px solid var(--color-border-dark);">
                    <option value="">-- Para Llevar / Retiro --</option>
                    @foreach($mesas as $mesa)
                        <option value="{{ $mesa->id }}">Mesa {{ $mesa->numero }} (Cap: {{ $mesa->capacidad }})</option>
                    @endforeach
                </select>
            </div>
            
            <div style="margin-bottom:10px;">
                <label style="color:var(--color-muted); font-size:0.8rem;">Nombre del Cliente</label>
                <input type="text" name="cliente_nombre" placeholder="Ej: Juan Pérez" style="background:var(--color-black); color:white; border:1px solid var(--color-border-dark);">
            </div>

            <div style="margin-bottom:15px;">
                <label style="color:var(--color-muted); font-size:0.8rem;">Método de Pago Efectuado</label>
                <select name="metodo_pago" required style="background:var(--color-black); color:white; border:1px solid var(--color-border-dark);">
                    <option value="efectivo_usd">Efectivo (Divisas)</option>
                    <option value="efectivo_bs">Efectivo (Bs)</option>
                    <option value="punto_venta">Punto de Venta</option>
                    <option value="pago_movil">Pago Móvil</option>
                </select>
            </div>

            <button type="submit" class="btn-critical" style="width:100%;" :disabled="cart.length === 0">
                Confirmar y Enviar a Cocina
            </button>
        </form>
    </x-card>
</div>
@endsection

@section('scripts')
<script>
function posSystem() {
    return {
        search: '',
        cart: [],
        
        matchesSearch(name) {
            if(this.search === '') return true;
            return name.includes(this.search.toLowerCase());
        },

        addToCart(id, name, price) {
            const existing = this.cart.find(item => item.id === id);
            if (existing) {
                existing.qty++;
            } else {
                this.cart.push({ id, name, price, qty: 1 });
            }
        },

        updateQty(id, change) {
            const item = this.cart.find(i => i.id === id);
            if(item) {
                item.qty += change;
                if(item.qty <= 0) {
                    this.cart = this.cart.filter(i => i.id !== id);
                }
            }
        },

        get cartTotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        }
    }
}
</script>
@endsection
