<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CuentaBancariaController extends Controller
{
    public function index()
    {
        $cuentas = \App\Models\CuentaBancaria::orderBy('orden')->get();
        return view('cuentabancarias.index', compact('cuentas'));
    }

    public function create()
    {
        return view('cuentabancarias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'alias' => 'required|string|max:255',
            'banco' => 'required|string|max:255',
            'tipo_operacion' => 'required|in:pago_movil,transferencia,zelle,efectivo_usd,efectivo_bs',
            'titular' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
            'numero_cuenta' => 'nullable|string|max:50',
            'instrucciones' => 'nullable|string',
            'orden' => 'integer'
        ]);

        $data['activa'] = $request->has('activa');
        \App\Models\CuentaBancaria::create($data);
        return redirect()->route('cuentabancarias.index')->with('success', 'Cuenta bancaria registrada.');
    }

    public function edit(\App\Models\CuentaBancaria $cuentabancaria)
    {
        return view('cuentabancarias.edit', compact('cuentabancaria'));
    }

    public function update(Request $request, \App\Models\CuentaBancaria $cuentabancaria)
    {
        $data = $request->validate([
            'alias' => 'required|string|max:255',
            'banco' => 'required|string|max:255',
            'tipo_operacion' => 'required|in:pago_movil,transferencia,zelle,efectivo_usd,efectivo_bs',
            'titular' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
            'numero_cuenta' => 'nullable|string|max:50',
            'instrucciones' => 'nullable|string',
            'orden' => 'integer'
        ]);

        $data['activa'] = $request->has('activa');
        $cuentabancaria->update($data);
        return redirect()->route('cuentabancarias.index')->with('success', 'Cuenta actualizada.');
    }

    public function destroy(\App\Models\CuentaBancaria $cuentabancaria)
    {
        $cuentabancaria->delete();
        return redirect()->route('cuentabancarias.index')->with('success', 'Cuenta eliminada.');
    }
}
