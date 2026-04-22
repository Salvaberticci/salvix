@extends('layouts.app')
@section('title', 'Editar Producto')
@section('header_title', 'Editar Producto: ' . $producto->nombre)

@section('content')
<x-card style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid">
            <div>
                <label>Nombre del Producto</label>
                <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>
            <div>
                <label>Categoría</label>
                <select name="categoria_id" required>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid" style="margin-top: 15px;">
            <div>
                <label>Precio (USD)</label>
                <input type="number" step="0.01" name="precio_usd" value="{{ old('precio_usd', $producto->precio_usd) }}" required>
            </div>
            <div>
                <label>Orden (Prioridad)</label>
                <input type="number" name="orden" value="{{ old('orden', $producto->orden) }}">
            </div>
        </div>

        <div style="margin-top: 15px;">
            <label>Descripción Corta</label>
            <textarea name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div style="margin-top: 15px; display:flex; gap:20px; align-items:center;">
            @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" width="100" style="border-radius:4px; border:1px solid var(--color-border);">
            @endif
            <div style="flex-grow:1;">
                <label>Reemplazar Imagen</label>
                <input type="file" name="imagen_file" accept="image/*">
            </div>
        </div>

        <div style="margin-top: 15px;">
            <label>
                <input type="checkbox" name="disponible" {{ $producto->disponible ? 'checked' : '' }}>
                Disponible en Menú Público
            </label>
        </div>

        <hr style="margin:25px 0;">
        <div style="display:flex; justify-content:space-between;">
            <a href="{{ route('productos.index') }}" class="btn-standard" style="padding: 10px 20px; text-decoration:none;">Cancelar</a>
            <button type="submit" class="btn-critical">Actualizar Producto</button>
        </div>
    </form>
</x-card>
@endsection
