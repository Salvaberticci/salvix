@extends('layouts.app')
@section('title', 'Editar Categoría')
@section('header_title', 'Editar Categoría: ' . $categoria->nombre)

@section('content')
<x-card style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
        @csrf @method('PUT')
        
        <div style="margin-bottom: 15px;">
            <label>Nombre de la Categoría</label>
            <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Descripción Corta (Opcional)</label>
            <textarea name="descripcion" rows="2">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Orden (Prioridad)</label>
            <input type="number" name="orden" value="{{ old('orden', $categoria->orden) }}">
        </div>

        <div style="margin-top: 15px;">
            <label>
                <input type="checkbox" name="activa" {{ $categoria->activa ? 'checked' : '' }}>
                Activa / Visible
            </label>
        </div>

        <hr style="margin:25px 0;">
        <div style="display:flex; justify-content:space-between;">
            <a href="{{ route('categorias.index') }}" class="btn-standard" style="padding: 10px 20px; text-decoration:none;">Cancelar</a>
            <button type="submit" class="btn-critical">Actualizar</button>
        </div>
    </form>
</x-card>
@endsection
