<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Filtro de Aceite',
                'description' => 'Filtro de aceite de alta calidad para todo tipo de vehículos',
                'price' => 15.99,
                'stock' => 100,
                'image' => 'filtro-aceite.jpg',
                'category_id' => 1,
                'brand' => 'Bosch',
                'vehicle_type' => 'Universal',
                'created_at' => now(),  // ← AGREGADO
                'updated_at' => now()   // ← AGREGADO
            ],
            [
                'name' => 'Pastillas de Freno',
                'description' => 'Pastillas de freno delanteras para sedanes',
                'price' => 45.50,
                'stock' => 50,
                'image' => 'pastillas-freno.jpg',
                'category_id' => 2,
                'brand' => 'Brembo',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),  // ← AGREGADO
                'updated_at' => now()   // ← AGREGADO
            ],
            [
                'name' => 'Batería 12V',
                'description' => 'Batería de 12V 60Ah para automóviles',
                'price' => 89.99,
                'stock' => 30,
                'image' => 'bateria-12v.jpg',
                'category_id' => 5,
                'brand' => 'ACDelco',
                'vehicle_type' => 'Universal',
                'created_at' => now(),  // ← AGREGADO
                'updated_at' => now()   // ← AGREGADO
            ],
            [
                'name' => 'Amortiguadores Delanteros',
                'description' => 'Amortiguadores delanteros para camionetas',
                'price' => 120.00,
                'stock' => 20,
                'image' => 'amortiguadores.jpg',
                'category_id' => 4,
                'brand' => 'Monroe',
                'vehicle_type' => 'Camioneta',
                'created_at' => now(),  // ← AGREGADO
                'updated_at' => now()   // ← AGREGADO
            ],
            [
                'name' => 'Aceite Motor 5W-30',
                'description' => 'Aceite sintético 5W-30 1 litro',
                'price' => 12.75,
                'stock' => 200,
                'image' => 'aceite-motor.jpg',
                'category_id' => 1,
                'brand' => 'Mobil',
                'vehicle_type' => 'Universal',
                'created_at' => now(),  // ← AGREGADO
                'updated_at' => now()   // ← AGREGADO
            ],
        ]);
    }
}