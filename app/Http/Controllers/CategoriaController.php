<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = \App\Models\Categoria::orderBy('orden')->get();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'integer',
            'activa' => 'boolean'
        ]);

        $data['activa'] = $request->has('activa');
        \App\Models\Categoria::create($data);
        return redirect()->route('categorias.index')->with('success', 'Categoría creada.');
    }

    public function edit(\App\Models\Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, \App\Models\Categoria $categoria)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'integer'
        ]);

        $data['activa'] = $request->has('activa');
        $categoria->update($data);
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(\App\Models\Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada.');
    }
}
