<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            ['clave' => 'nombre_restaurante', 'valor' => 'Salvix Restaurant'],
            ['clave' => 'tasa_bcv', 'valor' => '36.50'],
            ['clave' => 'ai_activo', 'valor' => '1'],
            ['clave' => 'ai_provider', 'valor' => 'https://api.openai.com/v1/chat/completions'],
            ['clave' => 'ai_model', 'valor' => 'gpt-4o-mini'],
            ['clave' => 'ai_system_prompt', 'valor' => 'Eres el asistente virtual de Salvix Restaurant. Eres amable, breve y siempre dispuesto a ayudar. Te riges estrictamente por la información dada en contexto.'],
            ['clave' => 'ai_rag_texto', 'valor' => 'Horario: 12:00pm a 10:00pm. Delivery: Sí, a toda la ciudad.'],
        ];

        foreach ($configs as $config) {
            \App\Models\Configuracion::create($config);
        }
    }
}
