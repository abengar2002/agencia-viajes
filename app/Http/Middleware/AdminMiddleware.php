<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware {

    // Intercepta la petición para verificar si el usuario es Administrador
    public function handle(Request $request, Closure $next): Response {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'ACCESO DENEGADO: Solo para el Administrador.');
        }

        return $next($request);
    }
}