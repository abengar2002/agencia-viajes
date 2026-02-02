<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Booking;
use App\Models\Review;

class TripController extends Controller {

    // Muestra la página principal con filtros (buscador y categorías)
    public function index(Request $request) {
        $query = Trip::query();

        // 1. Filtro por texto (Buscador)
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('destination', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 2. Filtro por Categoría (Botones)
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 3. Resultados ordenados y paginados
        $trips = $query->latest()->paginate(9)->withQueryString();

        // 4. Lista de categorías para los botones
        $categories = Category::all();

        return view('welcome', compact('trips', 'categories'));
    }

    // Muestra el detalle de un viaje específico
    public function show(Trip $trip) {
        return view('trips.show', compact('trip'));
    }

    // Procesa la reserva de un viaje
    public function book(Trip $trip) {
        // Verificar si ya lo tiene reservado
        if (auth()->user()->hasPurchased($trip)) {
            return back()->with('error', '¡Ya tienes este viaje reservado!');
        }

        // Crear la reserva
        Booking::create([
            'user_id' => auth()->id(),
            'trip_id' => $trip->id,
            'price_paid' => $trip->price,
            'status' => 'completed'
        ]);

        return back()->with('success', '¡Reserva confirmada! Prepara las maletas 🧳');
    }

    // Guarda una nueva reseña de un usuario
    public function storeReview(Request $request, Trip $trip) {
        $data = $request->validate([
            'comment' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        if (!auth()->user()->hasPurchased($trip)) {
            return back()->with('error', '¡No puedes opinar de algo que no has probado!');
        }

        $trip->reviews()->create([
            'user_id' => auth()->id(),
            'comment' => $data['comment'],
            'rating' => $data['rating']
        ]);

        return back()->with('success', '¡Gracias por tu opinión!');
    }

    // Cancela una reserva si cumple la política de 7 días
    public function cancelBooking($id) {
        // Buscamos la reserva
        $booking = \App\Models\Booking::findOrFail($id);

        // BUSCAMOS SI HAY RESEÑA Y LA BORRAMOS
        Review::where('user_id', $booking->user_id)
            ->where('trip_id', $booking->trip_id)
            ->delete();

        // Borramos la reserva
        $booking->delete();

        return back()->with('success', 'Reserva cancelada correctamente');
    }

    // Elimina una reseña propia
    public function deleteReview(Review $review) {
        if ($review->user_id !== auth()->id()) {
            abort(403, 'No puedes borrar comentarios de otros.');
        }

        $review->delete();
        return back()->with('success', 'Tu reseña ha sido eliminada.');
    }

    // Muestra formulario para editar una reseña propia
    public function editReview(Review $review) {
        if ($review->user_id !== auth()->id()) {
            abort(403, 'No puedes editar comentarios de otros.');
        }
        return view('trips.edit-review', compact('review'));
    }

    // Actualiza los datos de la reseña
    public function updateReview(Request $request, Review $review) {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('trips.show', $review->trip->slug)->with('success', 'Reseña actualizada correctamente.');
    }
}