<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->orderBy('categoria_id')->orderBy('orden')->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = \App\Models\Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_usd' => 'required|numeric|min:0',
            'disponible' => 'boolean',
            'orden' => 'integer',
            'imagen_file' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('imagen_file')) {
            $data['imagen'] = $request->file('imagen_file')->store('productos', 'public');
        }

        $data['disponible'] = $request->has('disponible');
        unset($data['imagen_file']);

        Producto::create($data);
        return redirect()->route('productos.index')->with('success', 'Producto creado.');
    }

    public function edit(Producto $producto)
    {
        $categorias = \App\Models\Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_usd' => 'required|numeric|min:0',
            'orden' => 'integer',
            'imagen_file' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('imagen_file')) {
            $data['imagen'] = $request->file('imagen_file')->store('productos', 'public');
        }

        $data['disponible'] = $request->has('disponible');
        unset($data['imagen_file']);

        $producto->update($data);
        return redirect()->route('productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
}
