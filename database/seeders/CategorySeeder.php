<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Motor', 
                'description' => 'Partes y repuestos para el motor del vehículo',
                'created_at' => now(),  // ← AGREGAR ESTA LÍNEA
                'updated_at' => now()   // ← AGREGAR ESTA LÍNEA
            ],
            [
                'name' => 'Frenos', 
                'description' => 'Sistemas de frenado y componentes',
                'created_at' => now(),  // ← AGREGAR ESTA LÍNEA
                'updated_at' => now()   // ← AGREGAR ESTA LÍNEA
            ],
            [
                'name' => 'Transmisión', 
                'description' => 'Componentes de la transmisión',
                'created_at' => now(),  // ← AGREGAR ESTA LÍNEA
                'updated_at' => now()   // ← AGREGAR ESTA LÍNEA
            ],
            [
                'name' => 'Suspensión', 
                'description' => 'Sistemas de suspensión y dirección',
                'created_at' => now(),  // ← AGREGAR ESTA LÍNEA
                'updated_at' => now()   // ← AGREGAR ESTA LÍNEA
            ],
            [
                'name' => 'Eléctrico', 
                'description' => 'Componentes del sistema eléctrico',
                'created_at' => now(),  // ← AGREGAR ESTA LÍNEA
                'updated_at' => now()   // ← AGREGAR ESTA LÍNEA
            ],
            [
                'name' => 'Carrocería', 
                'description' => 'Partes externas y carrocería',
                'created_at' => now(),  // ← AGREGAR ESTA LÍNEA
                'updated_at' => now()   // ← AGREGAR ESTA LÍNEA
            ],
        ]);
    }
}