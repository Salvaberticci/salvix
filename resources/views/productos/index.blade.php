@extends('layouts.app')
@section('title', 'Productos')
@section('header_title', 'Gestión de Productos')

@section('content')
<div style="display:flex; justify-content:flex-end; margin-bottom: 20px;">
    <a href="{{ route('productos.create') }}" class="btn-critical" style="padding: 10px 20px; text-decoration:none;"> + Nuevo Producto </a>
</div>

<x-card>
    <div style="overflow-x:auto;">
        <table role="grid" style="width:100%;">
            <thead>
                <tr>
                    <th>Img</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td>
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" width="50" height="50" style="object-fit:cover; border-radius:2px;">
                        @else
                            <div style="width:50px; height:50px; background:#eee; display:flex; justify-content:center; align-items:center;"><i class="ph ph-image"></i></div>
                        @endif
                    </td>
                    <td><strong>{{ $producto->nombre }}</strong></td>
                    <td>{{ $producto->categoria->nombre ?? 'N/A' }}</td>
                    <td>${{ number_format($producto->precio_usd, 2) }}</td>
                    <td>
                        @if($producto->disponible)
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-warning">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('productos.edit', $producto->id) }}" style="color:var(--color-info); margin-right:10px;"><i class="ph ph-pencil-simple" style="font-size:1.2rem;"></i></a>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:transparent; border:none; padding:0; color:var(--color-warning); cursor:pointer;"><i class="ph ph-trash" style="font-size:1.2rem;"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>
@endsection
