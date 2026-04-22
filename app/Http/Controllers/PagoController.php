<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = \App\Models\Pago::with('pedido', 'cuentaBancaria')
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        // El wizard de pago público
        $cuentas = \App\Models\CuentaBancaria::where('activa', true)->orderBy('orden')->get();
        $tasaBcv = \App\Models\Configuracion::where('clave', 'tasa_bcv')->value('valor') ?? 0;
        
        return view('pagos.wizard', compact('cuentas', 'tasaBcv'));
    }

    public function store(Request $request)
    {
        // Este método recibe data del Wizard de pagos público y crea el Pedido + Pago pendiente
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'cart_data' => 'required|json',
            'metodo' => 'required|string',
            'cuenta_bancaria_id' => 'nullable|exists:cuenta_bancarias,id',
            'referencia' => 'nullable|string',
            'comprobante_imagen' => 'nullable|image|max:3072',
            'tasa_bcv' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return back()->with('error', 'Error en los datos suministrados.');
        }

        $cart = json_decode($request->cart_data, true);
        if(empty($cart)) return back()->with('error', 'Su carrito está vacío.');

        $totalUsd = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['qty']), 0);
        $totalBs = $totalUsd * $request->tasa_bcv;

        // 1. Crear Pedido
        $pedido = \App\Models\Pedido::create([
            'estado' => 'pendiente',
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

        // 3. Crear Pago
        $pagoPath = null;
        if($request->hasFile('comprobante_imagen')) {
            $pagoPath = $request->file('comprobante_imagen')->store('comprobantes', 'public');
        }

        \App\Models\Pago::create([
            'pedido_id' => $pedido->id,
            'cuenta_bancaria_id' => $request->cuenta_bancaria_id,
            'metodo' => $request->metodo,
            'monto_usd' => $totalUsd,
            'monto_bs' => $totalBs,
            'tasa_bcv' => $request->tasa_bcv,
            'referencia' => $request->referencia,
            'comprobante_imagen' => $pagoPath,
            'estado' => 'pendiente' // Admin will verify this in /pagos
        ]);

        // Vaciar el carrito mediante AlpineJS se hace en el render de response (o pasando data a la view 'pagos.exito')
        return view('pagos.exito', compact('pedido'));
    }

    public function show(string $id)
    {
        // Return JSON details for modal
        $pago = \App\Models\Pago::with('pedido.detalle.producto', 'cuentaBancaria')->findOrFail($id);
        return $pago;
    }

    public function update(Request $request, string $id)
    {
        $pago = \App\Models\Pago::findOrFail($id);
        $pago->update(['estado' => $request->estado, 'verificado_por' => auth()->id(), 'verificado_at' => now()]);
        
        // Si el pago se confirma y el pedido estaba pendiente, movemos el pedido a 'cocina' automáticamente
        if($request->estado == 'confirmado' && $pago->pedido->estado == 'pendiente') {
            $pago->pedido->update(['estado' => 'cocina']);
        }
        
        return back()->with('success', 'Estado del pago actualizado.');
    }
}
