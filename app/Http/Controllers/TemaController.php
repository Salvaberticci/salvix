<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use Illuminate\Support\Facades\Storage;

class TemaController extends Controller
{
    public function index()
    {
        $temas = Tema::orderBy('created_at', 'desc')->get();
        return view('temas.index', compact('temas'));
    }

    public function create()
    {
        return view('temas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'config' => 'required|array',
            'logo' => 'nullable|image|max:2048'
        ]);

        $logoPath = null;
        if($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Tema::create([
            'nombre' => $request->nombre,
            'config' => $request->config,
            'logo_path' => $logoPath,
            'es_activo' => false
        ]);

        return redirect()->route('temas.index')->with('success', 'Tema creado correctamente.');
    }

    public function edit(Tema $tema)
    {
        return view('temas.edit', compact('tema'));
    }

    public function update(Request $request, Tema $tema)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'config' => 'required|array',
            'logo' => 'nullable|image|max:2048'
        ]);

        $data = [
            'nombre' => $request->nombre,
            'config' => $request->config
        ];

        if($request->hasFile('logo')) {
            if($tema->logo_path) Storage::disk('public')->delete($tema->logo_path);
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $tema->update($data);

        return redirect()->route('temas.index')->with('success', 'Tema actualizado.');
    }

    public function destroy(Tema $tema)
    {
        if($tema->es_activo) {
            return back()->with('error', 'No puedes eliminar el tema activo.');
        }
        if($tema->logo_path) Storage::disk('public')->delete($tema->logo_path);
        $tema->delete();
        return redirect()->route('temas.index')->with('success', 'Tema eliminado.');
    }

    public function activar($id)
    {
        Tema::where('es_activo', true)->update(['es_activo' => false]);
        $tema = Tema::findOrFail($id);
        $tema->update(['es_activo' => true]);

        return back()->with('success', 'Tema ' . $tema->nombre . ' activado correctamente.');
    }
}
