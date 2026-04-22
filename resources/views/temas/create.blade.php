@extends('layouts.app')
@section('title', 'Nuevo Estilo')
@section('header_title', 'Diseñar Nuevo Estilo')

@section('content')
<form action="{{ route('temas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid">
        <div style="flex: 2;">
            <x-card>
                <div style="margin-bottom:20px;">
                    <label>Nombre del Estilo</label>
                    <input type="text" name="nombre" placeholder="Ej: Minimalist Summer 2026" required>
                </div>

                <div class="grid">
                    <div>
                        <label>Color de Fondo (Página)</label>
                        <input type="color" name="config[bg_color]" value="#ffffff">
                    </div>
                    <div>
                        <label>Color del Header (Barra)</label>
                        <input type="color" name="config[header_bg]" value="#000000">
                    </div>
                </div>

                <div class="grid" style="margin-top:15px;">
                    <div>
                        <label>Texto del Header</label>
                        <input type="color" name="config[header_text]" value="#ffffff">
                    </div>
                    <div>
                        <label>Color de Tarjetas (Cards)</label>
                        <input type="color" name="config[card_bg]" value="#ffffff">
                    </div>
                </div>

                <div class="grid" style="margin-top:15px;">
                    <div>
                        <label>Texto de Tarjetas</label>
                        <input type="color" name="config[card_text]" value="#1a1a1a">
                    </div>
                    <div>
                        <label>Color Primario (Botones/Destaques)</label>
                        <input type="color" name="config[primary_color]" value="#DA291C">
                    </div>
                </div>

                <div class="grid" style="margin-top:15px;">
                    <div>
                        <label>Tipografía Google Fonts</label>
                        <select name="config[font_family]">
                            <option value="'Inter', sans-serif">Inter (Moderna)</option>
                            <option value="'Playfair Display', serif">Playfair Display (Elegante)</option>
                            <option value="'Roboto', sans-serif">Roboto (Estándar)</option>
                            <option value="'Montserrat', sans-serif">Montserrat (Geométrica)</option>
                            <option value="'Lora', serif">Lora (Editorial)</option>
                            <option value="'JetBrains Mono', monospace">JetBrains Mono (Técnica)</option>
                            <option value="'Bebas Neue', display">Bebas Neue (Impacto)</option>
                        </select>
                    </div>
                    <div>
                        <label>Radio de Borde (px)</label>
                        <input type="range" name="config[border_radius]" min="0" max="30" value="2">
                    </div>
                </div>

                <div style="margin-top:20px;">
                    <label>Logo Personalizado (Dejar vacío para el default)</label>
                    <input type="file" name="logo" accept="image/*">
                </div>
                
                <hr style="margin:25px 0;">
                <div style="display:flex; justify-content:space-between;">
                    <a href="{{ route('temas.index') }}" class="btn-standard" style="text-decoration:none;">Cancelar</a>
                    <button type="submit" class="btn-critical">Guardar Estilo</button>
                </div>
            </x-card>
        </div>

        <div style="flex: 1;">
            <x-card style="background:#eee;">
                <h4 style="margin-top:0;">Info de Fuentes</h4>
                <p style="font-size:0.8rem; color:#666;">
                    Al seleccionar una fuente, el sistema cargará automáticamente la librería desde Google Fonts en el catálogo público.
                </p>
                <div style="padding:20px; border:1px dashed #ccc; text-align:center;">
                    <span style="font-size:0.8rem;">VISTA PREVIA EN VIVO<br>(Proximamente)</span>
                </div>
            </x-card>
        </div>
    </div>
</form>
@endsection
