<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Título aleatorio: "Viaje a París"
            'title' => 'Viaje a ' . $this->faker->city,
            
            // Slug único: "viaje-a-paris"
            'slug' => $this->faker->unique()->slug,
            
            // País destino para los filtros
            'destination' => $this->faker->country,
            
            'description' => $this->faker->paragraph(3),
            
            // Precio entre 200 y 5000
            'price' => $this->faker->randomFloat(2, 200, 5000), 
            
            // Fechas aleatorias
            'start_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'end_date' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
            
            // Imagen de relleno (placeholder)
            'image' => 'https://via.placeholder.com/640x480.png/007799?text=Viaje',
        ];
    }
}