@extends('layouts.app')
@section('title', 'Configuración General')
@section('header_title', 'Ajustes del Sistema e IA')

@section('content')
<form action="{{ url('/configuracion') }}" method="POST">
    @csrf @method('PUT')
    
    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <!-- Ajustes Financieros -->
        <x-card>
            <x-slot name="header">
                <h3 style="margin:0; font-size:1.2rem;">Finanzas y Sistema</h3>
            </x-slot>
            
            <div style="margin-bottom:15px;">
                <label>Tasa BCV del día (Bolívares por 1 USD)</label>
                <div style="display:flex; gap:10px;">
                    <input class="tasa-bcv-display" style="margin:0; flex-grow:1;" type="number" step="0.01" name="tasa_bcv" value="{{ $configs['tasa_bcv'] ?? '36.50' }}" readonly title="Actualizada automáticamente vía DolarAPI">
                </div>
            </div>
            
            <div style="margin-bottom:15px;">
                <label>Nombre del Restaurante</label>
                <input type="text" name="nombre_restaurante" value="{{ $configs['nombre_restaurante'] ?? 'Salvix Restaurant' }}" required>
            </div>
            
            <div style="margin-bottom:15px;">
                <label>Mensaje de Cierre (Ticket)</label>
                <textarea name="mensaje_ticket" rows="2">{{ $configs['mensaje_ticket'] ?? '¡Gracias por su visita!' }}</textarea>
            </div>
        </x-card>

        <!-- Ajustes de Inteligencia Artificial (RAG) -->
        <x-card>
            <x-slot name="header">
                <h3 style="margin:0; font-size:1.2rem;">Asistente Virtual (Chatbot IA)</h3>
            </x-slot>
            
            <div style="margin-bottom:15px;">
                <label>Proveedor de IA</label>
                <select name="ia_provider">
                    <option value="gemini" {{ ($configs['ia_provider'] ?? '') == 'gemini' ? 'selected' : '' }}>Google Gemini (Recomendado)</option>
                    <option value="openai" {{ ($configs['ia_provider'] ?? '') == 'openai' ? 'selected' : '' }}>OpenAI (ChatGPT)</option>
                    <option value="groq" {{ ($configs['ia_provider'] ?? '') == 'groq' ? 'selected' : '' }}>Groq (Llama 3)</option>
                </select>
            </div>
            
            <div style="margin-bottom:15px;">
                <label>API Key (Dejar en blanco para no cambiar)</label>
                <input type="password" name="ia_api_key" value="{{ $configs['ia_api_key'] ?? '' }}" placeholder="sk-...">
            </div>
            
            <div style="margin-bottom:15px;">
                <label>Contexto Base / RAG Estático (Reglas del restaurante para la IA)</label>
                <textarea name="ia_system_prompt" rows="8" placeholder="Eres un mesero virtual del restaurante... El horario es de 10am a 10pm...">{{ $configs['ia_system_prompt'] ?? "Eres un amable mesero virtual del restaurante. Tu objetivo es ayudar a los clientes a elegir platos de nuestro menú. Responde siempre de forma corta, con un tono elegante pero cercano. El horario de atención es de 11:00 AM a 11:00 PM." }}</textarea>
                <small style="color:var(--color-muted);">El sistema automáticamente inyectará el menú actualizado (RAG dinámico) en el prompt junto a estas reglas.</small>
            </div>
        </x-card>
        
    </div>

    <div style="text-align:right; margin-top:20px;">
        <button type="submit" class="btn-critical" style="padding:15px 40px; font-size:1.1rem;">Guardar Toda la Configuración</button>
    </div>
</form>
@endsection
