@extends('layouts.app')
@section('title', 'Nueva Cuenta')
@section('header_title', 'Agregar Método de Pago')

@section('content')
<x-card style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('cuentabancarias.store') }}" method="POST">
        @csrf
        <div class="grid">
            <div>
                <label>Alias (Ej: Mi Pago Móvil Principal)</label>
                <input type="text" name="alias" value="{{ old('alias') }}" required>
            </div>
            <div>
                <label>Tipo de Operación</label>
                <select name="tipo_operacion" required>
                    <option value="pago_movil">Pago Móvil</option>
                    <option value="transferencia">Transferencia Nacional</option>
                    <option value="zelle">Zelle</option>
                    <option value="efectivo_usd">Efectivo ($)</option>
                    <option value="efectivo_bs">Efectivo (Bs)</option>
                </select>
            </div>
        </div>

        <div class="grid" style="margin-top: 15px;">
            <div>
                <label>Banco</label>
                <input type="text" name="banco" value="{{ old('banco') }}" required>
            </div>
            <div>
                <label>Teléfono (Para PM)</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}">
            </div>
        </div>

        <div class="grid" style="margin-top: 15px;">
            <div>
                <label>Cédula/RIF</label>
                <input type="text" name="cedula" value="{{ old('cedula') }}">
            </div>
            <div>
                <label>Titular</label>
                <input type="text" name="titular" value="{{ old('titular') }}">
            </div>
        </div>

        <div style="margin-top: 15px;">
            <label>N° Cuenta (Si es transferencia)</label>
            <input type="text" name="numero_cuenta" value="{{ old('numero_cuenta') }}">
        </div>

        <div style="margin-top: 15px;">
            <label>Instrucciones especiales a mostrar a clientes</label>
            <textarea name="instrucciones" rows="2">{{ old('instrucciones') }}</textarea>
        </div>

        <div class="grid" style="margin-top: 15px;">
            <div>
                <label>Orden visual</label>
                <input type="number" name="orden" value="{{ old('orden', 0) }}">
            </div>
            <div style="display:flex; align-items:flex-end; padding-bottom:10px;">
                <label>
                    <input type="checkbox" name="activa" checked>
                    Habilitar método
                </label>
            </div>
        </div>

        <hr style="margin:25px 0;">
        <div style="display:flex; justify-content:space-between;">
            <a href="{{ route('cuentabancarias.index') }}" class="btn-standard" style="padding: 10px 20px; text-decoration:none;">Cancelar</a>
            <button type="submit" class="btn-critical">Guardar</button>
        </div>
    </form>
</x-card>
@endsection
