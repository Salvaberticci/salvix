<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function index()
    {
        // For Kanban board, group by estate
        $pedidos = Pedido::with('detalle.producto', 'mesa')
                        ->whereDate('created_at', today())
                        ->orderBy('created_at', 'asc')
                        ->get()
                        ->groupBy('estado');
        
                        
        $estados = [
            'pendiente' => 'Pendientes', 
            'cocina' => 'En Cocina', 
            'listo' => 'Listos', 
            'entregado' => 'Entregados'
        ];

        return view('pedidos.index', compact('pedidos', 'estados'));
    }

    public function create()
    {
        $productos = \App\Models\Producto::where('disponible', true)->get();
        $mesas = \App\Models\Mesa::where('activa', true)->get();
        $tasaBcv = \App\Models\Configuracion::where('clave', 'tasa_bcv')->value('valor') ?? 0;
        
        return view('pedidos.create', compact('productos', 'mesas', 'tasaBcv'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart_data' => 'required|json',
            'mesa_id' => 'nullable|exists:mesas,id',
            'cliente_nombre' => 'nullable|string',
            'metodo_pago' => 'required|string',
            'tasa_bcv' => 'required|numeric'
        ]);

        $cart = json_decode($request->cart_data, true);
        if(empty($cart)) return back()->with('error', 'El carrito está vacío.');

        $totalUsd = array_reduce($cart, fn($c, $i) => $c + ($i['price'] * $i['qty']), 0);
        $totalBs = $totalUsd * $request->tasa_bcv;

        // Si selecciona una mesa, el tipo de entrega es "local"
        $tipoEntrega = $request->mesa_id ? 'local' : 'retiro';

        // 1. Crear Pedido
        $pedido = Pedido::create([
            'estado' => 'cocina', // Los pedidos internos pasan directo a cocina
            'cliente_nombre' => $request->cliente_nombre ?? 'Cliente Local',
            'mesa_id' => $request->mesa_id,
            'tipo_entrega' => $tipoEntrega,
            'total_usd' => $totalUsd,
            'total_bs' => $totalBs,
            'tasa_bcv' => $request->tasa_bcv
        ]);

        // 2. Crear detalles
        foreach($cart as $item) {
            \App\Models\DetallePedido::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $item['id'],
                'cantidad' => $item['qty'],
                'precio_usd' => $item['price'],
                'subtotal_usd' => $item['price'] * $item['qty']
            ]);
        }

        // 3. Crear Pago confirmado automáticamente
        \App\Models\Pago::create([
            'pedido_id' => $pedido->id,
            'metodo' => $request->metodo_pago,
            'monto_usd' => $totalUsd,
            'monto_bs' => $totalBs,
            'tasa_bcv' => $request->tasa_bcv,
            'estado' => 'confirmado',
            'verificado_por' => auth()->id(),
            'verificado_at' => now()
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado y enviado a cocina.');
    }

    public function show($id)
    {
        $pedido = Pedido::with('detalle.producto')->findOrFail($id);
        return $pedido;
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        
        if($request->has('estado')) {
            $pedido->update(['estado' => $request->estado]);
        }
        
        // Return JSON if AJAX
        if($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Pedido actualizado correctamente');
    }
}
