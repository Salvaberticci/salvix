<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function index()
    {
        $conversaciones = \App\Models\ChatbotConversacion::orderBy('updated_at', 'desc')->paginate(20);
        return view('chatbot.index', compact('conversaciones'));
    }

    public function show($id)
    {
        $conversacion = \App\Models\ChatbotConversacion::with('mensajes')->findOrFail($id);
        return view('chatbot.show', compact('conversacion'));
    }
}
