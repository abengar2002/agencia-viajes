<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Antonio Admin', // O el nombre que quieras
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password'), // La contraseña 'password' encriptada
            'avatar'   => null, // O una ruta si quieres que tenga foto por defecto
            // 'role'  => 'admin', // Si tienes roles, descomenta y pon 'admin'
        ]);
        
        // (Opcional) Puedes crear usuarios extra de prueba si quieres
        // User::factory(5)->create(); 
    }
}