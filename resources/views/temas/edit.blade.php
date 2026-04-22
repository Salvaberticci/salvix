@extends('layouts.app')
@section('title', 'Editar Estilo')
@section('header_title', 'Personalizar Estilo: ' . $tema->nombre)

@section('content')
<form action="{{ route('temas.update', $tema->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="grid">
        <div style="flex: 2;">
            <x-card>
                <div style="margin-bottom:20px;">
                    <label>Nombre del Estilo</label>
                    <input type="text" name="nombre" value="{{ $tema->nombre }}" required>
                </div>

                <div class="grid">
                    <div>
                        <label>Color de Fondo (Página)</label>
                        <input type="color" name="config[bg_color]" value="{{ $tema->config['bg_color'] ?? '#ffffff' }}">
                    </div>
                    <div>
                        <label>Color del Header (Barra)</label>
                        <input type="color" name="config[header_bg]" value="{{ $tema->config['header_bg'] ?? '#000000' }}">
                    </div>
                </div>

                <div class="grid" style="margin-top:15px;">
                    <div>
                        <label>Texto del Header</label>
                        <input type="color" name="config[header_text]" value="{{ $tema->config['header_text'] ?? '#ffffff' }}">
                    </div>
                    <div>
                        <label>Color de Tarjetas (Cards)</label>
                        <input type="color" name="config[card_bg]" value="{{ $tema->config['card_bg'] ?? '#ffffff' }}">
                    </div>
                </div>

                <div class="grid" style="margin-top:15px;">
                    <div>
                        <label>Texto de Tarjetas</label>
                        <input type="color" name="config[card_text]" value="{{ $tema->config['card_text'] ?? '#1a1a1a' }}">
                    </div>
                    <div>
                        <label>Color Primario (Botones/Destaques)</label>
                        <input type="color" name="config[primary_color]" value="{{ $tema->config['primary_color'] ?? '#DA291C' }}">
                    </div>
                </div>

                <div class="grid" style="margin-top:15px;">
                    <div>
                        <label>Tipografía Google Fonts</label>
                        <select name="config[font_family]">
                            @php
                                $currentFont = $tema->config['font_family'] ?? "'Inter', sans-serif";
                                $fonts = [
                                    "'Inter', sans-serif" => "Inter (Moderna)",
                                    "'Playfair Display', serif" => "Playfair Display (Elegante)",
                                    "'Roboto', sans-serif" => "Roboto (Estándar)",
                                    "'Montserrat', sans-serif" => "Montserrat (Geométrica)",
                                    "'Lora', serif" => "Lora (Editorial)",
                                    "'JetBrains Mono', monospace" => "JetBrains Mono (Técnica)",
                                    "'Bebas Neue', cursive" => "Bebas Neue (Impacto)"
                                ];
                            @endphp
                            @foreach($fonts as $value => $label)
                                <option value="{{ $value }}" {{ $currentFont == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Radio de Borde (px)</label>
                        <input type="range" name="config[border_radius]" min="0" max="30" value="{{ str_replace('px', '', $tema->config['border_radius'] ?? '2') }}">
                    </div>
                </div>

                <div style="margin-top:20px; display:flex; gap:20px; align-items:center;">
                    @if($tema->logo_path)
                        <img src="{{ asset('storage/' . $tema->logo_path) }}" style="max-height:60px; background:#ddd; padding:5px;">
                    @endif
                    <div style="flex:1;">
                        <label>Cambiar Logo para este Tema</label>
                        <input type="file" name="logo" accept="image/*">
                    </div>
                </div>
                
                <hr style="margin:25px 0;">
                <div style="display:flex; justify-content:space-between;">
                    <a href="{{ route('temas.index') }}" class="btn-standard" style="text-decoration:none;">Cancelar</a>
                    <button type="submit" class="btn-critical">Actualizar Estilo</button>
                </div>
            </x-card>
        </div>

        <div style="flex: 1;">
            <x-card style="background:#eee;">
                <h4 style="margin-top:0;">Previsualización de Tema</h4>
                <div style="background: {{ $tema->config['bg_color'] ?? '#fff' }}; padding:20px; border:1px solid #ccc; font-family: {{ $tema->config['font_family'] ?? 'sans-serif' }}; color: {{ $tema->config['card_text'] ?? '#000' }};">
                     <div style="background: {{ $tema->config['header_bg'] ?? '#000' }}; color: {{ $tema->config['header_text'] ?? '#fff' }}; padding:10px; margin-bottom:10px; font-size:0.7rem;">HEADER TEXT</div>
                     <div style="background: {{ $tema->config['card_bg'] ?? '#fff' }}; border: 1px solid #ddd; border-radius: {{ ($tema->config['border_radius'] ?? 2) }}px; padding:15px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                        <strong>Plato De Prueba</strong><br>
                        <p style="font-size:0.8rem; margin:10px 0;">Descripción del plato con la tipografía seleccionada.</p>
                        <button style="background: {{ $tema->config['primary_color'] ?? '#DA291C' }}; color:white; border:none; padding:5px 10px; cursor:default; width:100%; border-radius: {{ ($tema->config['border_radius'] ?? 2) }}px;">BOTÓN ACCIÓN</button>
                     </div>
                </div>
            </x-card>
        </div>
    </div>
</form>
@endsection
