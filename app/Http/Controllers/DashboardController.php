<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Mesa;
use App\Models\Configuracion;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();
        $tasaBcv = Configuracion::where('clave', 'tasa_bcv')->value('valor') ?? 0;
        
        $datos = [
            'tasaBcv' => $tasaBcv,
            'pedidosHoy' => Pedido::whereDate('created_at', today())->count(),
            'pedidosCompletados' => Pedido::whereDate('created_at', today())->where('estado', 'entregado')->count(),
            'ventasHoyUSD' => Pedido::whereDate('created_at', today())->whereIn('estado', ['pagado', 'entregado'])->sum('total_usd'),
            'productosActivos' => Producto::where('disponible', true)->count(),
            'mesasActivas' => Mesa::where('activa', true)->count()
        ];
        
        // Datos para el gráfico (últimos 7 días)
        $ventasUltimos7Dias = Pedido::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->whereIn('estado', ['pagado', 'entregado'])
            ->selectRaw('DATE(created_at) as fecha, SUM(total_usd) as total')
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();

        $labelsChart = [];
        $dataChart = [];
        $diasES = ['Mon' => 'Lun', 'Tue' => 'Mar', 'Wed' => 'Mié', 'Thu' => 'Jue', 'Fri' => 'Vie', 'Sat' => 'Sáb', 'Sun' => 'Dom'];

        for ($i = 6; $i >= 0; $i--) {
            $dateObj = now()->subDays($i);
            $date = $dateObj->format('Y-m-d');
            $labelsChart[] = $diasES[$dateObj->format('D')];
            
            $venta = $ventasUltimos7Dias->firstWhere('fecha', $date);
            $dataChart[] = $venta ? (float)$venta->total : 0;
        }

        $datos['labelsChart'] = json_encode($labelsChart);
        $datos['dataChart'] = json_encode($dataChart);
        
        return view('dashboard', $datos);
    }
}
