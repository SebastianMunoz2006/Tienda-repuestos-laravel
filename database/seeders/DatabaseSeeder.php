<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Llama a los seeders en el orden correcto
        $this->call([
            CategorySeeder::class, // Primero categorías
            ProductSeeder::class,   // Luego productos
        ]);
    }
}