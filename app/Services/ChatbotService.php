<?php

namespace App\Services;

use App\Models\Configuracion;
use App\Models\ChatbotConversacion;
use App\Models\ChatbotMensaje;
use App\Models\Producto;
use Illuminate\Support\Facades\Http;

class ChatbotService
{
    protected $provider;
    protected $apiKey;
    protected $systemPrompt;

    public function __construct()
    {
        $configs = Configuracion::pluck('valor', 'clave')->toArray();
        $this->provider = $configs['ia_provider'] ?? 'gemini';
        $this->apiKey = $configs['ia_api_key'] ?? '';
        $this->systemPrompt = $configs['ia_system_prompt'] ?? 'Eres un asisnte virtual.';
    }

    public function processMessage($sessionId, $userMessage, $ip)
    {
        if (empty($this->apiKey)) {
            return "El servicio de IA no está configurado de momento.";
        }

        // Obtener o crear conversación
        $conver = ChatbotConversacion::firstOrCreate(
            ['session_id' => $sessionId],
            ['ip' => $ip, 'nombre_cliente' => 'Cliente Web']
        );

        // Guardar mensaje de usuario
        ChatbotMensaje::create([
            'conversacion_id' => $conver->id,
            'rol' => 'user',
            'contenido' => $userMessage
        ]);

        // Construir RAG context
        $ragContext = $this->buildRAGContext();
        $fullSystemMessage = $this->systemPrompt . "\n\nINFORMACIÓN DEL NEGOCIO:\n" . $ragContext;

        // Historial reciente para contexto
        $history = ChatbotMensaje::where('conversacion_id', $conver->id)
                    ->orderBy('created_at', 'desc')
                    ->take(6)->get()->reverse();

        $reply = "No pude conectar con el proveedor de IA.";

        if ($this->provider == 'gemini') {
            $reply = $this->askGemini($fullSystemMessage, $history, $userMessage);
        } else {
            // OpenAI / Groq Compatible
            $reply = $this->askOpenAICompatible($fullSystemMessage, $history, $userMessage);
        }

        // Guardar respuesta asistente
        ChatbotMensaje::create([
            'conversacion_id' => $conver->id,
            'rol' => 'assistant',
            'contenido' => $reply
        ]);

        return $reply;
    }

    private function buildRAGContext()
    {
        $productos = Producto::where('disponible', 1)->get();
        $menuInfo = "Catálogo / Menú actual:\n";
        foreach ($productos as $p) {
            $menuInfo .= "- " . $p->nombre . " ($" . number_format($p->precio_usd, 2) . "): " . $p->descripcion . "\n";
        }
        
        $configs = \App\Models\Configuracion::pluck('valor', 'clave')->toArray();
        $tasa = $configs['tasa_bcv'] ?? '36.50';
        $menuInfo .= "\nLa tasa oficial del Dólar hoy es de Bs $tasa.\n";
        
        return $menuInfo;
    }

    private function askGemini($system, $history, $latest)
    {
        $contents = [];
        
        // Gemini pro requires system message in a specific way or as the first prompt
        // For simple v1beta we can just prefix the latest message if no system instruction param is available,
        // or use system_instruction if available in api. Let's just prefix it to the first interaction.
        
        $hasInjectedSystem = false;
        foreach($history as $msg) {
            $text = $msg->contenido;
            if(!$hasInjectedSystem && $msg->rol == 'user') {
                $text = "INSTRUCCIONES DEL SISTEMA:\n" . $system . "\n\nMENSAJE DEL CLIENTE:\n" . $text;
                $hasInjectedSystem = true;
            }
            
            $contents[] = [
                'role' => ($msg->rol == 'assistant') ? 'model' : 'user',
                'parts' => [['text' => $text]]
            ];
        }

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $this->apiKey, [
                'contents' => $contents
            ]);

        if ($response->successful()) {
            $json = $response->json();
            return $json['candidates'][0]['content']['parts'][0]['text'] ?? "Sin respuesta válida.";
        }
        
        return "Error en API Gemini: " . $response->status();
    }

    private function askOpenAICompatible($system, $history, $latest)
    {
        $baseUrl = $this->provider == 'groq' ? 'https://api.groq.com/openai/v1/chat/completions' : 'https://api.openai.com/v1/chat/completions';
        $model = $this->provider == 'groq' ? 'llama3-8b-8192' : 'gpt-3.5-turbo';

        $messages = [
            ['role' => 'system', 'content' => $system]
        ];

        foreach($history as $msg) {
            $messages[] = [
                'role' => $msg->rol, 
                'content' => $msg->contenido
            ];
        }

        $response = Http::withToken($this->apiKey)
            ->post($baseUrl, [
                'model' => $model,
                'messages' => $messages,
                'max_tokens' => 300
            ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'] ?? "Sin respuesta.";
        }
        
        return "Error en API IA: " . $response->status();
    }
}
