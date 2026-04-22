@extends('layouts.app')
@section('title', 'Historial del Chatbot IA')
@section('header_title', 'Conversaciones del Asistente Virtual')

@section('content')
<x-card>
    <div style="overflow-x:auto;">
        <table role="grid" style="width:100%;">
            <thead>
                <tr>
                    <th>Sesión ID</th>
                    <th>Cliente</th>
                    <th>IP</th>
                    <th>Última Interacción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conversaciones as $chat)
                <tr>
                    <td><small style="font-family:monospace; color:var(--color-muted);">{{ substr($chat->session_id, 0, 15) }}...</small></td>
                    <td><strong>{{ $chat->nombre_cliente }}</strong></td>
                    <td>{{ $chat->ip }}</td>
                    <td>{{ $chat->updated_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ url('/chatbot/' . $chat->id) }}" class="btn-standard" style="padding:2px 10px; font-size:0.8rem; text-decoration:none;">Leer Transcripción</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>
@endsection
