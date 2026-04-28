@extends('layouts.app')
@section('title', 'Categorías')
@section('header_title', 'Gestión de Categorías')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
    <div class="tabs-editorial">
        <a href="{{ route('productos.index') }}" class="tab-link">Productos</a>
        <a href="{{ route('categorias.index') }}" class="tab-link active">Categorías</a>
    </div>
    <a href="{{ route('categorias.create') }}" class="btn-critical" style="padding: 10px 20px; text-decoration:none;"> + Nueva Categoría </a>
</div>

<style>
    .tabs-editorial { display: flex; gap: 20px; border-bottom: 2px solid rgba(0,0,0,0.05); padding-bottom: 10px; margin-bottom: 10px; }
    .tab-link { font-weight: 600; color: var(--color-muted); text-decoration: none; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 0.5px; }
    .tab-link.active { color: var(--color-black); border-bottom: 2px solid var(--color-red); padding-bottom: 10px; margin-bottom: -12px; }
    .tab-link:hover { color: var(--color-text-dark); }
</style>

<x-card>
    <div style="overflow-x:auto;">
        <table role="grid" style="width:100%;">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Orden</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                <tr>
                    <td><strong>{{ $categoria->nombre }}</strong></td>
                    <td>{{ $categoria->orden }}</td>
                    <td>
                        @if($categoria->activa)
                            <span class="badge badge-success">Activa</span>
                        @else
                            <span class="badge badge-warning">Inactiva</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('categorias.edit', $categoria->id) }}" style="color:var(--color-info); margin-right:10px;"><i class="ph ph-pencil-simple" style="font-size:1.2rem;"></i></a>
                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?');">
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
