<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $ingredientes = \App\Models\Ingrediente::orderBy('nombre')->get();
        $movimientos = \App\Models\MovimientoInventario::with('ingrediente', 'user')
                            ->orderBy('created_at', 'desc')
                            ->take(50)->get();
                            
        return view('inventario.index', compact('ingredientes', 'movimientos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'unidad' => 'required|string',
            'stock_minimo' => 'numeric|min:0',
            'costo_usd' => 'numeric|min:0'
        ]);

        \App\Models\Ingrediente::create($data);
        return back()->with('success', 'Ingrediente agregado al inventario.');
    }
    
    public function update(Request $request, string $id)
    {
        // For processing a manual stock adjustment
        $request->validate([
            'tipo' => 'required|in:entrada,salida,merma',
            'cantidad' => 'required|numeric|min:0.01',
            'motivo' => 'nullable|string'
        ]);
        
        $ingrediente = \App\Models\Ingrediente::findOrFail($id);
        
        // Update stock
        if($request->tipo == 'entrada') {
            $ingrediente->stock_actual += $request->cantidad;
        } else {
            $ingrediente->stock_actual -= $request->cantidad;
        }
        $ingrediente->save();
        
        // Register movement
        \App\Models\MovimientoInventario::create([
            'ingrediente_id' => $ingrediente->id,
            'tipo' => $request->tipo,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'user_id' => auth()->id()
        ]);
        
        return back()->with('success', 'Ajuste de inventario registrado correctamente.');
    }
}
