<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Creamos las categorías limpias
        $categories = [
            ['name' => 'Playa', 'slug' => 'playa'],
            ['name' => 'Montaña', 'slug' => 'montana'],
            ['name' => 'Ciudad', 'slug' => 'ciudad'],
            ['name' => 'Aventura', 'slug' => 'aventura'],
            ['name' => 'Lujo', 'slug' => 'lujo'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}