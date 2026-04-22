@extends('layouts.app')
@section('title', 'Gestión de Estilos')
@section('header_title', 'Personalización del Menú Digital')

@section('content')
<div style="display:flex; justify-content:flex-end; margin-bottom: 20px;">
    <a href="{{ route('temas.create') }}" class="btn-critical" style="padding: 10px 20px; text-decoration:none;"> + Crear Nuevo Estilo </a>
</div>

<div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
    @foreach($temas as $tema)
    <x-card style="position:relative; border-top: 4px solid {{ $tema->config['primary_color'] ?? '#DA291C' }};">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <h3 style="margin:0;">{{ $tema->nombre }}</h3>
                @if($tema->es_activo)
                    <span class="badge badge-success">Activo</span>
                @endif
            </div>
            <div style="display:flex; gap:10px;">
                <a href="{{ route('temas.edit', $tema->id) }}" style="color:var(--color-info);"><i class="ph ph-pencil-simple" style="font-size:1.2rem;"></i></a>
                @if(!$tema->es_activo)
                <form action="{{ route('temas.destroy', $tema->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este estilo?');">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:transparent; border:none; padding:0; color:var(--color-warning); cursor:pointer;"><i class="ph ph-trash" style="font-size:1.2rem;"></i></button>
                </form>
                @endif
            </div>
        </div>

        <div style="margin: 20px 0; background: {{ $tema->config['bg_color'] ?? '#ffffff' }}; padding:15px; border:1px solid #ddd; height:120px; display:flex; flex-direction:column; justify-content:center; align-items:center;">
             <div style="width:100px; height:8px; background:{{ $tema->config['header_bg'] ?? '#000000' }}; margin-bottom:10px;"></div>
             <div style="display:flex; gap:5px;">
                 <div style="width:30px; height:40px; background:white; border:1px solid #eee; border-radius: {{ $tema->config['border_radius'] ?? '2px' }};"></div>
                 <div style="width:30px; height:40px; background:white; border:1px solid #eee; border-radius: {{ $tema->config['border_radius'] ?? '2px' }};"></div>
                 <div style="width:30px; height:40px; background:white; border:1px solid #eee; border-radius: {{ $tema->config['border_radius'] ?? '2px' }};"></div>
             </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:10px;">
            @if(!$tema->es_activo)
            <form action="{{ route('temas.activar', $tema->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-standard" style="width:100%;">Activar este Estilo</button>
            </form>
            @else
            <button class="btn-standard" disabled style="width:100%; opacity:0.5;">Activo actualmente</button>
            @endif
        </div>
    </x-card>
    @endforeach
</div>

@if($temas->isEmpty())
    <div style="text-align:center; padding:50px;">
        <i class="ph ph-palette" style="font-size:4rem; color:#eee;"></i>
        <p style="color:#888;">No hay temas personalizados creados.</p>
    </div>
@endif

@endsection
