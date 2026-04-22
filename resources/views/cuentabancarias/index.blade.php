@extends('layouts.app')
@section('title', 'Cuentas Bancarias')
@section('header_title', 'Métodos de Pago del Negocio')

@section('content')
<div style="display:flex; justify-content:flex-end; margin-bottom: 20px;">
    <a href="{{ route('cuentabancarias.create') }}" class="btn-critical" style="padding: 10px 20px; text-decoration:none;"> + Agregar Cuenta </a>
</div>

<x-card>
    <div style="overflow-x:auto;">
        <table role="grid" style="width:100%;">
            <thead>
                <tr>
                    <th>Alias</th>
                    <th>Tipo</th>
                    <th>Banco</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuentas as $cuenta)
                <tr>
                    <td><strong>{{ $cuenta->alias }}</strong></td>
                    <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $cuenta->tipo_operacion) }}</td>
                    <td>{{ $cuenta->banco }}</td>
                    <td>
                        @if($cuenta->activa)
                            <span class="badge badge-success">Activa</span>
                        @else
                            <span class="badge badge-warning">Inactiva</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cuentabancarias.edit', $cuenta->id) }}" style="color:var(--color-info); margin-right:10px;"><i class="ph ph-pencil-simple" style="font-size:1.2rem;"></i></a>
                        <form action="{{ route('cuentabancarias.destroy', $cuenta->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que deseas eliminar esta cuenta?');">
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
