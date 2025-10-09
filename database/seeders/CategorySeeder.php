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
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Frenos', 
                'description' => 'Sistemas de frenado y componentes',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Transmisión', 
                'description' => 'Componentes de la transmisión',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Suspensión', 
                'description' => 'Sistemas de suspensión y dirección',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Eléctrico', 
                'description' => 'Componentes del sistema eléctrico',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Carrocería', 
                'description' => 'Partes externas y carrocería',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Accesorios', 
                'description' => 'Accesorios y complementos para vehículos',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}