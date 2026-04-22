@extends('layouts.app')
@section('title', 'Nuevo Producto')
@section('header_title', 'Crear Producto')

@section('content')
<x-card style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid">
            <div>
                <label>Nombre del Producto</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required>
            </div>
            <div>
                <label>Categoría</label>
                <select name="categoria_id" required>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid" style="margin-top: 15px;">
            <div>
                <label>Precio (USD)</label>
                <input type="number" step="0.01" name="precio_usd" value="{{ old('precio_usd') }}" required>
            </div>
            <div>
                <label>Orden (Prioridad)</label>
                <input type="number" name="orden" value="{{ old('orden', 0) }}">
            </div>
        </div>

        <div style="margin-top: 15px;">
            <label>Descripción Corta</label>
            <textarea name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
        </div>

        <div style="margin-top: 15px;">
            <label>Subir Imagen (Opcional)</label>
            <input type="file" name="imagen_file" accept="image/*">
        </div>

        <div style="margin-top: 15px;">
            <label>
                <input type="checkbox" name="disponible" checked>
                Disponible en Menú Público
            </label>
        </div>

        <hr style="margin:25px 0;">
        <div style="display:flex; justify-content:space-between;">
            <a href="{{ route('productos.index') }}" class="btn-standard" style="padding: 10px 20px; text-decoration:none;">Cancelar</a>
            <button type="submit" class="btn-critical">Guardar Producto</button>
        </div>
    </form>
</x-card>
@endsection
