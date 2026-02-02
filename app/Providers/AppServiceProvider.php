<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider {

    // Registra servicios de la aplicación
    public function register(): void {
        //
    }

    // Inicializa servicios y configura la paginación con Tailwind
    public function boot(): void {
        Paginator::useTailwind();
    }
}