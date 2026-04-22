@extends('layouts.app')
@section('title', 'Editar Cuenta')
@section('header_title', 'Editar Método de Pago: ' . $cuentabancaria->alias)

@section('content')
<x-card style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('cuentabancarias.update', $cuentabancaria->id) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="grid">
            <div>
                <label>Alias (Ej: Mi Pago Móvil Principal)</label>
                <input type="text" name="alias" value="{{ old('alias', $cuentabancaria->alias) }}" required>
            </div>
            <div>
                <label>Tipo de Operación</label>
                <select name="tipo_operacion" required>
                    <option value="pago_movil" {{ $cuentabancaria->tipo_operacion == 'pago_movil' ? 'selected' : '' }}>Pago Móvil</option>
                    <option value="transferencia" {{ $cuentabancaria->tipo_operacion == 'transferencia' ? 'selected' : '' }}>Transferencia Nacional</option>
                    <option value="zelle" {{ $cuentabancaria->tipo_operacion == 'zelle' ? 'selected' : '' }}>Zelle</option>
                    <option value="efectivo_usd" {{ $cuentabancaria->tipo_operacion == 'efectivo_usd' ? 'selected' : '' }}>Efectivo ($)</option>
                    <option value="efectivo_bs" {{ $cuentabancaria->tipo_operacion == 'efectivo_bs' ? 'selected' : '' }}>Efectivo (Bs)</option>
                </select>
            </div>
        </div>

        <div class="grid" style="margin-top: 15px;">
            <div>
                <label>Banco</label>
                <input type="text" name="banco" value="{{ old('banco', $cuentabancaria->banco) }}" required>
            </div>
            <div>
                <label>Teléfono (Para PM)</label>
                <input type="text" name="telefono" value="{{ old('telefono', $cuentabancaria->telefono) }}">
            </div>
        </div>

        <div class="grid" style="margin-top: 15px;">
            <div>
                <label>Cédula/RIF</label>
                <input type="text" name="cedula" value="{{ old('cedula', $cuentabancaria->cedula) }}">
            </div>
            <div>
                <label>Titular</label>
                <input type="text" name="titular" value="{{ old('titular', $cuentabancaria->titular) }}">
            </div>
        </div>

        <div style="margin-top: 15px;">
            <label>N° Cuenta (Si es transferencia)</label>
            <input type="text" name="numero_cuenta" value="{{ old('numero_cuenta', $cuentabancaria->numero_cuenta) }}">
        </div>

        <div style="margin-top: 15px;">
            <label>Instrucciones especiales a mostrar a clientes</label>
            <textarea name="instrucciones" rows="2">{{ old('instrucciones', $cuentabancaria->instrucciones) }}</textarea>
        </div>

        <div class="grid" style="margin-top: 15px;">
            <div>
                <label>Orden visual</label>
                <input type="number" name="orden" value="{{ old('orden', $cuentabancaria->orden) }}">
            </div>
            <div style="display:flex; align-items:flex-end; padding-bottom:10px;">
                <label>
                    <input type="checkbox" name="activa" {{ $cuentabancaria->activa ? 'checked' : '' }}>
                    Habilitar método
                </label>
            </div>
        </div>

        <hr style="margin:25px 0;">
        <div style="display:flex; justify-content:space-between;">
            <a href="{{ route('cuentabancarias.index') }}" class="btn-standard" style="padding: 10px 20px; text-decoration:none;">Cancelar</a>
            <button type="submit" class="btn-critical">Actualizar</button>
        </div>
    </form>
</x-card>
@endsection
