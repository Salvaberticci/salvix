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
        // Simple form to manually create a POS order from admin side
        return "Vista de crear pedido manual desde admin";
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
