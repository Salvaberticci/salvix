<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catEntradas = \App\Models\Categoria::create(['nombre' => 'Entradas', 'orden' => 1]);
        $catFuertes = \App\Models\Categoria::create(['nombre' => 'Platos Fuertes', 'orden' => 2]);
        $catBebidas = \App\Models\Categoria::create(['nombre' => 'Bebidas', 'orden' => 3]);

        \App\Models\Producto::create([
            'categoria_id' => $catEntradas->id,
            'nombre' => 'Tequeños',
            'descripcion' => 'Ración de 5 tequeños de queso con salsa de ajo.',
            'precio_usd' => 4.50,
            'orden' => 1
        ]);

        \App\Models\Producto::create([
            'categoria_id' => $catFuertes->id,
            'nombre' => 'Pasta Carbonara',
            'descripcion' => 'Auténtica carbonara italiana con guanciale y pecorino.',
            'precio_usd' => 12.00,
            'orden' => 1
        ]);

        \App\Models\Producto::create([
            'categoria_id' => $catBebidas->id,
            'nombre' => 'Refresco 1.5L',
            'descripcion' => 'Coca-Cola o Chinotto.',
            'precio_usd' => 3.00,
            'orden' => 1
        ]);
    }
}
