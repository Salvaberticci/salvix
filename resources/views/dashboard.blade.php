@extends('layouts.app')
@section('title', 'Inicio')
@section('header_title', 'Dashboard')
@section('tasa_bcv', $tasaBcv)

@section('content')
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
    
    <x-card>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <span class="label-editorial">Ventas Hoy (USD)</span>
                <h2 style="margin:5px 0 0 0; font-size: 2rem;">${{ number_format($ventasHoyUSD, 2) }}</h2>
            </div>
            <i class="ph ph-currency-dollar" style="font-size: 2.5rem; color: var(--color-gold);"></i>
        </div>
    </x-card>

    <x-card>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <span class="label-editorial">Pedidos Hoy</span>
                <h2 style="margin:5px 0 0 0; font-size: 2rem;">{{ $pedidosHoy }}</h2>
            </div>
            <i class="ph ph-receipt" style="font-size: 2.5rem; color: var(--color-info);"></i>
        </div>
    </x-card>
    
    <x-card>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <span class="label-editorial">Menú Activo</span>
                <h2 style="margin:5px 0 0 0; font-size: 2rem;">{{ $productosActivos }} platos</h2>
            </div>
            <i class="ph ph-bowl-food" style="font-size: 2.5rem; color: var(--color-success);"></i>
        </div>
    </x-card>

</div>

<div class="grid" style="grid-template-columns: 2fr 1fr; gap: 20px;">
    <!-- Chart Section -->
    <x-card>
        <x-slot name="header">
            <h3 style="margin:0; font-size: 1.2rem;">Rendimiento Semanal</h3>
        </x-slot>
        <canvas id="ventasChart" style="width:100%; height:300px;"></canvas>
    </x-card>

    <!-- Acciones Rápidas -->
    <x-card>
        <x-slot name="header">
            <h3 style="margin:0; font-size: 1.2rem;">Acciones Rápidas</h3>
        </x-slot>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="{{ route('pedidos.create') }}" class="btn-critical" style="text-align:center; padding:10px; text-decoration:none; display:flex; justify-content:center; align-items:center; gap:10px;">
                <i class="ph ph-plus-circle"></i> Nuevo Pedido
            </a>
            <a href="{{ route('productos.create') }}" class="btn-standard" style="text-align:center; padding:10px; text-decoration:none; display:flex; justify-content:center; align-items:center; gap:10px;">
                <i class="ph ph-hamburger"></i> Agregar Producto
            </a>
            <a href="{{ route('catalogo.index') }}" target="_blank" class="btn-standard" style="text-align:center; padding:10px; text-decoration:none; display:flex; justify-content:center; align-items:center; gap:10px;">
                <i class="ph ph-arrow-square-out"></i> Ver Menú Público
            </a>
        </div>
    </x-card>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('ventasChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! $labelsChart !!},
            datasets: [{
                label: 'Ventas (USD)',
                data: {!! $dataChart !!},
                borderColor: '#E8A045',
                backgroundColor: 'rgba(232, 160, 69, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endsection
