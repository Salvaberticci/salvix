@extends('layouts.public')
@section('title', 'Menú')

@section('content')
<div x-data="cartSystem()" x-init="initCart()">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
        <h2 style="margin:0;">Filtros de Especialidades</h2>
        <!-- Cart Trigger -->
        <button class="btn-standard" @click="isCartOpen = true" style="position:relative; padding: 12px 24px; border-width: 2px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 8px;">
            <i class="ph ph-shopping-bag" style="font-size: 1.2rem;"></i> Mi Pedido
            <span x-show="totalItems > 0" x-text="totalItems" style="position:absolute; top:0; right:0; transform: translate(40%, -40%); background:var(--color-red); color:white; border-radius:50%; min-width:22px; height:22px; font-size:11px; display:flex; justify-content:center; align-items:center; font-weight:900; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2); line-height: 1;"></span>
        </button>
    </div>

    <!-- Categorías Tabs -->
    <nav style="margin-bottom: 40px; overflow-x:auto; white-space:nowrap; padding-bottom:10px;">
        <ul style="list-style:none; padding:0; margin:0; display:flex; gap:15px;">
            <li>
                <a href="#" @click.prevent="activeCategory = 'all'" :style="activeCategory === 'all' ? 'border-bottom: 2px solid var(--color-red); color:var(--color-black)' : 'color:var(--color-muted)'" style="text-decoration:none; text-transform:uppercase; font-size:0.8rem; font-weight:bold; padding-bottom:5px;">Todo el Menú</a>
            </li>
            @foreach($categorias as $categoria)
            <li>
                <a href="#" @click.prevent="activeCategory = {{ $categoria->id }}" :style="activeCategory === {{ $categoria->id }} ? 'border-bottom: 2px solid var(--color-red); color:var(--color-black)' : 'color:var(--color-muted)'" style="text-decoration:none; text-transform:uppercase; font-size:0.8rem; font-weight:bold; padding-bottom:5px;">{{ $categoria->nombre }}</a>
            </li>
            @endforeach
        </ul>
    </nav>

    <!-- Platos Grid -->
    <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
        @foreach($categorias as $categoria)
            @foreach($categoria->productos as $producto)
            <div class="gsap-item" x-show="activeCategory === 'all' || activeCategory === {{ $categoria->id }}" x-transition style="display:none;">
                <x-card>
                    @if($producto->imagen)
                    <div style="height: 200px; background-image: url('{{ asset('storage/' . $producto->imagen) }}'); background-size: cover; background-position: center; margin: -20px -20px 20px -20px;"></div>
                    @else
                    <div style="height: 200px; background: #e0e0e0; margin: -20px -20px 20px -20px; display:flex; justify-content:center; align-items:center;">
                        <i class="ph ph-image" style="font-size: 3rem; color: #aaa;"></i>
                    </div>
                    @endif
                    
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <h3 style="margin:0; font-size: 1.2rem;">{{ $producto->nombre }}</h3>
                        <span style="font-weight:bold; color:var(--color-gold);">${{ number_format($producto->precio_usd, 2) }}</span>
                    </div>
                    <p style="color:var(--color-muted); font-size:0.9rem; margin-top:10px;">{{ $producto->descripcion }}</p>
                    
                    <button class="btn-standard" style="width:100%; border-color:var(--color-border); margin-top:15px;" @click="addToCart({{ $producto->id }}, '{{ $producto->nombre }}', {{ $producto->precio_usd }})">
                        Agregar al pedido
                    </button>
                </x-card>
            </div>
            @endforeach
        @endforeach
    </div>

    <!-- Carrt Sidebar Modal -->
    <dialog x-bind:open="isCartOpen" style="margin:auto; padding:0; background:transparent; max-width:400px; width:90%; position:fixed; right:0; top:0; height:100%; z-index:9999;">
        <article style="margin:0; height:100%; display:flex; flex-direction:column; border-radius:0;">
            <header style="display:flex; justify-content:space-between; align-items:center;">
                <h4 style="margin:0;">Mi Pedido</h4>
                <a href="#close" aria-label="Close" class="close" @click.prevent="isCartOpen = false"></a>
            </header>
            
            <div style="flex-grow:1; overflow-y:auto; padding:15px;">
                <template x-if="cart.length === 0">
                    <p style="text-align:center; color:var(--color-muted); margin-top:50px;">El carrito está vacío.</p>
                </template>

                <template x-for="item in cart" :key="item.id">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding:10px 0;">
                        <div>
                            <h5 style="margin:0; font-size:0.9rem;" x-text="item.name"></h5>
                            <span style="font-size:0.8rem; color:var(--color-muted);" x-text="'$'+(item.price).toFixed(2)"></span>
                        </div>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <button @click="updateQty(item.id, -1)" style="padding:0; width:25px; height:25px; border-radius:50%; font-size:1rem; display:flex; justify-content:center; align-items:center; border:1px solid var(--color-border); background:white; color:black;">-</button>
                            <span x-text="item.qty"></span>
                            <button @click="updateQty(item.id, 1)" style="padding:0; width:25px; height:25px; border-radius:50%; font-size:1rem; display:flex; justify-content:center; align-items:center; border:1px solid var(--color-border); background:white; color:black;">+</button>
                        </div>
                    </div>
                </template>
            </div>

            <footer style="background:var(--color-surface); padding:20px;">
                <div style="display:flex; justify-content:space-between; color:white; margin-bottom:15px;">
                    <span style="font-weight:bold;">Total:</span>
                    <span style="font-weight:bold; font-size:1.2rem;" x-text="'$'+cartTotal.toFixed(2)"></span>
                </div>
                <button class="btn-critical" style="width:100%;" :disabled="cart.length === 0" @click="checkout()">
                    Procesar Pago
                </button>
            </footer>
        </article>
    </dialog>
</div>
@endsection

@section('scripts')
<script>
// GSAP Animation implementation for staggered entrance
document.addEventListener("DOMContentLoaded", (event) => {
    // Show items gracefully
    document.querySelectorAll('.gsap-item').forEach(el => el.style.display = 'block');
    gsap.from(".gsap-item", {
        duration: 0.8,
        y: 40,
        opacity: 0,
        stagger: 0.1,
        ease: "power3.out"
    });
});

// Alpine JS Logic
function cartSystem() {
    return {
        activeCategory: 'all',
        isCartOpen: false,
        cart: [],
        
        initCart() {
            const saved = localStorage.getItem('salvix_cart');
            if (saved) {
                this.cart = JSON.parse(saved);
            }
        },

        saveCart() {
            localStorage.setItem('salvix_cart', JSON.stringify(this.cart));
        },

        addToCart(id, name, price) {
            const existing = this.cart.find(item => item.id === id);
            if (existing) {
                existing.qty++;
            } else {
                this.cart.push({ id, name, price, qty: 1 });
            }
            this.saveCart();
            window.notify("Producto agregado al carrito");
            
            // Pulse animation on the cart button
            gsap.fromTo('.ph-shopping-bag', {scale: 1.5}, {scale: 1, duration: 0.4});
        },

        updateQty(id, change) {
            const item = this.cart.find(i => i.id === id);
            if(item) {
                item.qty += change;
                if(item.qty <= 0) {
                    this.cart = this.cart.filter(i => i.id !== id);
                }
            }
            this.saveCart();
        },

        get totalItems() {
            return this.cart.reduce((sum, item) => sum + item.qty, 0);
        },

        get cartTotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },

        checkout() {
            // Redirigir al Wizard de Pagos
            window.notify("Redirigiendo a pagos...", "success");
            setTimeout(() => {
                window.location.href = "{{ route('pagos.wizard') }}";
            }, 1000);
        }
    }
}
</script>
@endsection
