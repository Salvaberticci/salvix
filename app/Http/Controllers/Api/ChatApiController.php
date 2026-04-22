<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ChatApiController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'message' => 'required|string',
            'history' => 'array'
        ]);

        try {
            $bot = app(\App\Services\ChatbotService::class);
            $response = $bot->processMessage($request->session_id, $request->message, $request->ip());
            
            return response()->json(['success' => true, 'reply' => $response]);
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            return response()->json(['success' => false, 'reply' => 'Lo siento, estoy teniendo problemas técnicos en este momento. ' . $e->getMessage()], 500);
        }
    }
}
