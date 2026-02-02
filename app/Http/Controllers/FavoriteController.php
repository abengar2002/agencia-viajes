<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller {
    // Mostrar la lista de favoritos
    public function index() {
        // Obtenemos los viajes que el usuario ha marcado como favoritos
        $favorites = Auth::user()->favorites()->latest()->get();
        
        return view('favorites', compact('favorites'));
    }

    public function toggle(Trip $trip) {
        // toggle devuelve un array diciendo qué hizo (si añadió o quitó)
        $result = Auth::user()->favorites()->toggle($trip->id);

        // Si el array 'attached' tiene algo, es que lo ha añadido
        if (count($result['attached']) > 0) {
            return back()->with('success', '¡Añadido a tus favoritos!');
        } 
        
        // Si no, es que lo ha quitado
        return back()->with('success', 'Eliminado de favoritos');
    }
}