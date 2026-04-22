@extends('layouts.app')
@section('title', 'Transcipción de Chat')
@section('header_title', 'Transcripción: ' . $conversacion->nombre_cliente)

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <a href="{{ url('/chatbot') }}" style="color:var(--color-muted); text-decoration:none;">< Volver al Historial</a>
    </div>

    <x-card>
        <x-slot name="header">
            <h3 style="margin:0; font-size: 1.1rem;">
                Detalles del Chat <br>
                <small style="font-weight:normal; color:var(--color-muted); font-size:0.8rem;">Sesión: {{ $conversacion->session_id }}</small>
            </h3>
        </x-slot>

        <div style="display:flex; flex-direction:column; gap:15px; padding:10px;">
            @foreach($conversacion->mensajes as $msg)
                <div style="{{ $msg->rol === 'user' ? 'text-align:right;' : 'text-align:left;' }}">
                    <div style="{{ $msg->rol === 'user' ? 'background:var(--color-black); color:white;' : 'background:#f5f5f5; color:black; border:1px solid #ddd;' }} padding:15px; border-radius:8px; display:inline-block; max-width:85%; text-align:left; font-size:0.95rem;">
                        <span style="display:block; font-size:0.7rem; color:{{ $msg->rol === 'user' ? '#aaa' : '#888' }}; margin-bottom:5px; text-transform:uppercase;">
                            {{ $msg->rol === 'user' ? 'Cliente' : 'IA Asistente' }}
                        </span>
                        {!! nl2br(e($msg->contenido)) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>
</div>
@endsection
