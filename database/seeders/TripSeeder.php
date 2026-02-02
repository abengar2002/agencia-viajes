<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Trip::truncate();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Categorías
        $categories = ['Playa 🏖️', 'Montaña 🏔️', 'Ciudad 🏙️', 'Aventura 🎒', 'Lujo 💎'];
        $catIds = [];
        foreach ($categories as $c) {
            $cat = Category::create(['name' => $c, 'slug' => Str::slug($c)]);
            $catIds[] = $cat->id;
        }

        // 2. Ciudades con su Continente (Para que el buscador de texto funcione)
        $places = [
            ['city' => 'París, Francia', 'region' => 'Europa'],
            ['city' => 'Tokyo, Japón', 'region' => 'Asia'],
            ['city' => 'Roma, Italia', 'region' => 'Europa'],
            ['city' => 'Nueva York, USA', 'region' => 'Norteamérica'],
            ['city' => 'Bali, Indonesia', 'region' => 'Asia'],
            ['city' => 'Cusco, Perú', 'region' => 'Sudamérica'],
            ['city' => 'El Cairo, Egipto', 'region' => 'África'],
            ['city' => 'Sydney, Australia', 'region' => 'Oceanía'],
            ['city' => 'Santorini, Grecia', 'region' => 'Europa'],
            ['city' => 'Cancún, México', 'region' => 'Norteamérica'],
            ['city' => 'Londres, UK', 'region' => 'Europa'],
            ['city' => 'Bangkok, Tailandia', 'region' => 'Asia']
        ];

        $images = [
            'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800',
            'https://images.unsplash.com/photo-1542051841857-5f90071e7989?auto=format&fit=crop&w=800',
            'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800',
            'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800',
        ];

        // 3. Crear 50 viajes
        for ($i = 0; $i < 50; $i++) {
            $place = $places[array_rand($places)];
            
            Trip::create([
                'title' => 'Escapada a ' . explode(',', $place['city'])[0],
                'slug' => Str::slug('viaje-' . $place['city'] . '-' . $i),
                'destination' => $place['city'],
                // AQUÍ ESTÁ EL TRUCO: Añadimos la región a la descripción
                'description' => 'Disfruta de una experiencia inolvidable en ' . $place['city'] . '. Un destino increíble situado en ' . $place['region'] . ' con todo incluido.',
                'price' => rand(800, 4500),
                'start_date' => now()->addDays(rand(10, 100)),
                'end_date' => now()->addDays(rand(105, 120)),
                'image' => $images[array_rand($images)],
                'category_id' => $catIds[array_rand($catIds)],
            ]);
        }
    }
}