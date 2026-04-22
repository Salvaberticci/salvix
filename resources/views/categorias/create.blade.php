@extends('layouts.app')
@section('title', 'Nueva Categoría')
@section('header_title', 'Crear Categoría')

@section('content')
<x-card style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Nombre de la Categoría</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Descripción Corta (Opcional)</label>
            <textarea name="descripcion" rows="2">{{ old('descripcion') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Orden (Prioridad)</label>
            <input type="number" name="orden" value="{{ old('orden', 0) }}">
        </div>

        <div style="margin-top: 15px;">
            <label>
                <input type="checkbox" name="activa" checked>
                Activa / Visible
            </label>
        </div>

        <hr style="margin:25px 0;">
        <div style="display:flex; justify-content:space-between;">
            <a href="{{ route('categorias.index') }}" class="btn-standard" style="padding: 10px 20px; text-decoration:none;">Cancelar</a>
            <button type="submit" class="btn-critical">Guardar</button>
        </div>
    </form>
</x-card>
@endsection
