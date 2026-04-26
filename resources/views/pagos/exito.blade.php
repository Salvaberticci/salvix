@extends('layouts.public')
@section('title', 'Pedido Recibido')

@section('content')
<div style="max-width: 600px; margin: 0 auto; text-align:center; padding:60px 20px;">
    
    <div style="width:80px; height:80px; background:#03904A; border-radius:50%; display:flex; justify-content:center; align-items:center; margin: 0 auto 30px auto; box-shadow: 0 10px 20px rgba(3,144,74,0.2);">
        <i class="ph ph-check" style="font-size:3rem; color:white;"></i>
    </div>

    <h1 style="margin:0; font-family:var(--font-heading); font-size:2rem; letter-spacing:-1px;">¡Pedido Recibido!</h1>
    <p class="label-editorial" style="margin-top:10px; display:block;">Gracias por confiar en Salvix</p>

    <div style="margin-top:40px; padding:30px; border: 1px solid var(--color-border); border-radius: 2px; background: white; text-align:left; position:relative; overflow:hidden;">
        <div style="position:absolute; top:0; left:0; width:4px; height:100%; background:var(--color-red);"></div>
        
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px;">
            <div>
                <span class="label-editorial" style="font-size:0.7rem; color:var(--color-text-light);">Número de Orden</span>
                <h2 style="margin:0; font-family:var(--font-body); font-weight:700;">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</h2>
            </div>
            <div style="text-align:right;">
                <span class="badge badge-warning">En Verificación</span>
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <span class="label-editorial" style="font-size:0.7rem; color:var(--color-text-light);">Resumen del Pago</span>
            <div style="font-size:1.4rem; font-weight:700; color:var(--color-black);">
                ${{ number_format($pedido->total_usd, 2) }}
                <span style="font-size:0.9rem; color:var(--color-text-mid); font-weight:400; margin-left:10px;">/ Bs {{ number_format($pedido->total_bs, 2) }}</span>
            </div>
        </div>

        <p style="font-size:0.9rem; color:var(--color-text-mid); line-height:1.6; margin:0;">
            Nuestro equipo verificará su comprobante en breve. Una vez confirmado, su pedido pasará directamente a la cocina. Puede consultar el estado con su mesero usando el número de orden arriba indicado.
        </p>
    </div>

    <div style="margin-top:50px;">
        <a href="{{ route('catalogo.index') }}" class="btn-standard" style="padding: 15px 40px !important; text-decoration:none;">
            Volver al Menú
        </a>
    </div>

</div>
@endsection
