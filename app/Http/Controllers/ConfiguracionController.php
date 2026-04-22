<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configs = Configuracion::pluck('valor', 'clave')->toArray();
        return view('configuracion.index', compact('configs'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        
        foreach ($data as $key => $value) {
            Configuracion::updateOrCreate(
                ['clave' => $key],
                ['valor' => $value]
            );
        }

        return back()->with('success', 'Configuración guardada correctamente.');
    }

    public function syncBcv(Request $request)
    {
        try {
            // Usar cURL nativo como solicitó el usuario para evitar fallos de Laravel HTTP en XAMPP
            $ch = curl_init("https://ve.dolarapi.com/v1/dolares/oficial");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Apagar verificación SSL local
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36'); // Evitar bloqueo 403
            $response = curl_exec($ch);
            
            if(curl_errno($ch)) {
                throw new \Exception(curl_error($ch));
            }
            curl_close($ch);
            
            $data = json_decode($response, true);
            
            if(is_array($data) && isset($data['promedio'])) {
                $monto = number_format($data['promedio'], 2, '.', '');
                Configuracion::updateOrCreate(
                    ['clave' => 'tasa_bcv'],
                    ['valor' => $monto]
                );
                
                if($request->wantsJson() || $request->is('api/*')) {
                    return response()->json(['success' => true, 'tasa' => $monto]);
                }
                return back()->with('success', 'Tasa BCV sincronizada exitosamente: Bs ' . $monto);
            }
            
            if($request->wantsJson() || $request->is('api/*')) return response()->json(['success' => false, 'error' => 'La llave promedio no se encontró']);
            return back()->with('error', 'La API respondió, pero no se encontró la tasa.');
        } catch (\Exception $e) {
            if($request->wantsJson() || $request->is('api/*')) return response()->json(['success' => false, 'error' => $e->getMessage()]);
            return back()->with('error', 'Error al consultar DolarAPI: ' . $e->getMessage());
        }
    }
}
