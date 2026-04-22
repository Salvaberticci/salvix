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
        
        return view('dashboard', $datos);
    }
}
