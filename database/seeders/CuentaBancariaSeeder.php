<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuentaBancariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\CuentaBancaria::create([
            'alias' => 'Pago Móvil Banesco',
            'banco' => 'Banesco',
            'tipo_operacion' => 'pago_movil',
            'titular' => 'Salvix Restaurante CA',
            'cedula' => 'J-12345678-9',
            'telefono' => '0414-1234567',
        ]);
        
        \App\Models\CuentaBancaria::create([
            'alias' => 'Efectivo $',
            'banco' => 'Caja',
            'tipo_operacion' => 'efectivo_usd',
            'titular' => 'Caja',
        ]);
    }
}
