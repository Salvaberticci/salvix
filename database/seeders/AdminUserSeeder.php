<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin Salvix',
            'email' => 'admin@salvix.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'rol' => 'admin',
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'Mesero Juan',
            'email' => 'juan@salvix.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'rol' => 'mesero',
        ]);
    }
}
