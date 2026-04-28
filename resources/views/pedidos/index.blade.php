@extends('layouts.app')
@section('title', 'Pedidos')
@section('header_title', 'Tablero de Pedidos (Hoy)')

@section('content')
<div x-data="kanban()" class="kanban-board" style="display:flex; gap:20px; overflow-x:auto; padding-bottom:20px; align-items:flex-start; height:calc(100vh - 150px);">

    @foreach($estados as $key => $title)
    <!-- Column -->
    <div style="min-width: 300px; flex:1; background:#f4f6f8; padding:15px; border-radius:4px; height:auto; min-height:400px; border-top: 4px solid @if($key=='pendiente') var(--color-warning) @elseif($key=='cocina') var(--color-gold) @elseif($key=='listo') var(--color-info) @else var(--color-success) @endif; box-shadow: inset 0 0 10px rgba(0,0,0,0.02);">
        <h3 style="color:var(--color-black); font-size:1.1rem; margin-top:0; border-bottom:2px solid #e0e0e0; padding-bottom:10px; display:flex; justify-content:space-between; align-items:center;">
            {{ $title }}
            <span style="background:var(--color-black); color:white; padding:2px 10px; border-radius:12px; font-size:0.8rem; font-weight:bold;">
                {{ isset($pedidos[$key]) ? $pedidos[$key]->count() : 0 }}
            </span>
        </h3>
        
        <div style="display:flex; flex-direction:column; gap:10px; margin-top:15px;">
            @if(isset($pedidos[$key]))
                @foreach($pedidos[$key] as $pedido)
                <div class="card-editorial gsap-card" style="background:var(--color-white); padding:15px; border-left:4px solid var(--color-black);">
                    <div style="display:flex; justify-content:space-between;">
                        <strong>#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</strong>
                        <span class="label-editorial">{{ $pedido->created_at->format('h:i A') }}</span>
                    </div>
                    @if($pedido->mesa)
                        <div class="badge" style="background:#ddd; color:#333; margin-top:5px;">Mesa {{ $pedido->mesa->numero }}</div>
                    @endif
                    
                    <ul style="margin:10px 0 0 0; padding-left:15px; font-size:0.9rem;">
                        @foreach($pedido->detalle as $item)
                            <li style="margin-bottom: 5px;">
                                <strong>{{ $item->cantidad }}x</strong> {{ $item->producto->nombre ?? 'Producto Eliminado' }}
                            </li>
                        @endforeach
                    </ul>
                    
                    <hr style="margin: 10px 0; border:0; border-top:1px solid var(--color-border);"/>
                    
                    <!-- Action buttons per state -->
                    <div style="display:flex; justify-content:space-between; gap:5px;">
                        @if($key == 'pendiente')
                            <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" style="flex:1">
                                @csrf @method('PUT')
                                <input type="hidden" name="estado" value="cocina">
                                <button type="submit" class="btn-standard" style="width:100%; font-size:0.8rem; padding:5px;">A Cocina</button>
                            </form>
                        @elseif($key == 'cocina')
                            <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" style="flex:1">
                                @csrf @method('PUT')
                                <input type="hidden" name="estado" value="listo">
                                <button type="submit" class="btn-standard" style="width:100%; font-size:0.8rem; padding:5px; background:var(--color-black); color:white;">Listo</button>
                            </form>
                        @elseif($key == 'listo')
                            <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" style="flex:1">
                                @csrf @method('PUT')
                                <input type="hidden" name="estado" value="entregado">
                                <button type="submit" class="btn-standard" style="width:100%; font-size:0.8rem; padding:5px;">Entregar</button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div style="text-align:center; padding:30px 20px; color:#a0a0a0; font-size:0.9rem; border: 2px dashed #ddd; border-radius: 4px;">
                    Sin pedidos en esta fase
                </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    gsap.from(".gsap-card", {
        duration: 0.5,
        y: 20,
        opacity: 0,
        stagger: 0.05,
        ease: "power2.out"
    });
});

function kanban() {
    return {
        // Alpine Logic for kanban board if we want live reloading later
    }
}
</script>
@endsection
