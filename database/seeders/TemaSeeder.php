<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tema;

class TemaSeeder extends Seeder
{
    public function run(): void
    {
        $temas = [
            [
                'nombre' => 'Ferrari Chiaroscuro',
                'config' => [
                    'bg_color' => '#ffffff',
                    'header_bg' => '#000000',
                    'header_text' => '#ffffff',
                    'card_bg' => '#ffffff',
                    'card_text' => '#1a1a1a',
                    'primary_color' => '#DA291C',
                    'font_family' => "'Inter', sans-serif",
                    'border_radius' => '2'
                ],
                'es_activo' => true
            ],
            [
                'nombre' => 'Midnight Emerald',
                'config' => [
                    'bg_color' => '#0d1b1e',
                    'header_bg' => '#1b3022',
                    'header_text' => '#e0f2f1',
                    'card_bg' => '#1b3022',
                    'card_text' => '#e0f2f1',
                    'primary_color' => '#c0a080',
                    'font_family' => "'Playfair Display', serif",
                    'border_radius' => '8'
                ],
                'es_activo' => false
            ],
            [
                'nombre' => 'Nordic White',
                'config' => [
                    'bg_color' => '#f4f7f6',
                    'header_bg' => '#ffffff',
                    'header_text' => '#2d3436',
                    'card_bg' => '#ffffff',
                    'card_text' => '#2d3436',
                    'primary_color' => '#4c98b9',
                    'font_family' => "'Montserrat', sans-serif",
                    'border_radius' => '0'
                ],
                'es_activo' => false
            ],
            [
                'nombre' => 'Retro Diner',
                'config' => [
                    'bg_color' => '#fdf5e6',
                    'header_bg' => '#c0392b',
                    'header_text' => '#ffffff',
                    'card_bg' => '#ffffff',
                    'card_text' => '#34495e',
                    'primary_color' => '#e67e22',
                    'font_family' => "'Lora', serif",
                    'border_radius' => '15'
                ],
                'es_activo' => false
            ],
            [
                'nombre' => 'Cyberpunk Night',
                'config' => [
                    'bg_color' => '#000000',
                    'header_bg' => '#000000',
                    'header_text' => '#00ff00',
                    'card_bg' => '#000000',
                    'card_text' => '#ffffff',
                    'primary_color' => '#ff00ff',
                    'font_family' => "'JetBrains Mono', monospace",
                    'border_radius' => '0'
                ],
                'es_activo' => false
            ]
        ];

        foreach ($temas as $tema) {
            Tema::create($tema);
        }
    }
}
