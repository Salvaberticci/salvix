@extends('layouts.public')
@section('title', 'Pedido Recibido')

@section('content')
<div style="max-width: 600px; margin: 0 auto; text-align:center; padding:50px 20px;">
    
    <div style="width:80px; height:80px; background:var(--color-success); border-radius:50%; display:flex; justify-content:center; align-items:center; margin: 0 auto 20px auto;">
        <i class="ph ph-check" style="font-size:3rem; color:white;"></i>
    </div>

    <h2 style="margin:0;">¡Pedido Recibido Exitosamente!</h2>
    <p style="color:var(--color-muted); margin-top:10px;">
        Su orden fue procesada bajo el comprobante: <br>
        <strong style="font-size:1.5rem; color:var(--color-black);">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</strong>
    </p>

    <div style="background:var(--color-surface); padding:20px; border-radius:2px; margin-top:30px; text-align:left;">
        <h4 style="margin-top:0; border-bottom:1px solid var(--color-border); padding-bottom:10px;">Resumen:</h4>
        <ul style="list-style:none; padding:0; margin:10px 0;">
            <li><strong>Total de su orden:</strong> ${{ number_format($pedido->total_usd, 2) }} (Bs {{ number_format($pedido->total_bs, 2) }})</li>
            <li><strong>Estado de la orden:</strong> 
                <span style="color:var(--color-warning);">En verificación</span>
            </li>
        </ul>
        <p style="font-size:0.9rem; color:var(--color-muted); margin:0;">
            Nuestro equipo verificará su pago en breve. Puede acercarse a recoger su pedido o indicarle al mesero su número de orden.
        </p>
    </div>

    <a href="{{ route('catalogo.index') }}" class="btn-critical" style="margin-top:40px; display:inline-block; text-decoration:none;">Volver al Inicio</a>

</div>
@endsection
