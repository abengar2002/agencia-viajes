<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear el Usuario Admin
        $this->call(UserSeeder::class);

        // 2. Crear las Categorías (Playa, Montaña...)
        $this->call(CategorySeeder::class); 

        // 3. (Opcional) Viajes. 
        // Si ya tienes el TripSeeder "manual" que hicimos antes, descoméntalo:
        // $this->call(TripSeeder::class); 
    }
}