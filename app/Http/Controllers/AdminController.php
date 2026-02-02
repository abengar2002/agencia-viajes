<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AdminController extends Controller {

    // Muestra el panel principal con estadísticas
    public function index() {
        $stats = [
            'users' => User::count(),
            'trips' => Trip::count(),
            'bookings' => Booking::count(),
            'reviews' => Review::count(),
            'income' => Booking::sum('price_paid')
        ];
        return view('admin.dashboard', compact('stats'));
    }

    // Muestra la lista de viajes con sus categorías
    public function trips() {
        $trips = Trip::with('category')->get();
        return view('admin.trips.index', compact('trips'));
    }

    public function deleteTrip(Trip $trip) {
        // 1. OBTENER LA RUTA LIMPIA
        // Tu base de datos tiene "storage/trips/foto.jpg", pero necesitamos solo "trips/foto.jpg"
        // Usamos str_replace para quitar "storage/" del principio.
        $path = str_replace('storage/', '', $trip->image); 

        // 2. BORRAR LA IMAGEN
        // Ahora $path será algo como "trips/wSYvS..." y Laravel lo encontrará.
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // 3. BORRAR EL REGISTRO
        $trip->delete();

        return back()->with('success', 'Viaje y su imagen eliminados correctamente.');
    }

    // Muestra el formulario para crear un nuevo viaje
    public function create() {
        $categories = Category::all();
        return view('admin.trips.create', compact('categories'));
    }

    // Valida y guarda un nuevo viaje
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'destination' => 'required',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'required|image|mimes:jpeg,png,jpg,avif,webp|max:2048',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = $request->file('image')->store('trips', 'public');

        Trip::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'destination' => $request->destination,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'image' => 'storage/' . $imagePath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.trips.index')->with('success', '¡Viaje creado con éxito!');
    }

    // Muestra el formulario para editar un viaje existente
    public function edit(Trip $trip) {
        $categories = Category::all();
        return view('admin.trips.edit', compact('trip', 'categories'));
    }

    // Valida y actualiza los datos de un viaje
    public function update(Request $request, Trip $trip) {
        $request->validate([
            'title' => 'required',
            'destination' => 'required',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,avif,webp|max:2048',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'destination' => $request->destination,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('trips', 'public');
            $data['image'] = 'storage/' . $imagePath;
        }

        $trip->update($data);
        return redirect()->route('admin.trips.index')->with('success', '¡Viaje actualizado correctamente!');
    }

    // Muestra la lista de reservas realizadas
    public function bookings() {
        $bookings = Booking::with(['user', 'trip'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    // Cancela y elimina una reserva
    public function deleteBooking(Booking $booking) {
        $booking->delete();
        return back()->with('success', 'Reserva cancelada correctamente.');
    }

    // Muestra la lista de reseñas de usuarios
    public function reviews() {
        $reviews = Review::with(['user', 'trip'])->latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    // Elimina una reseña
    public function deleteReview(Review $review) {
        $review->delete();
        return back()->with('success', 'Comentario eliminado correctamente.');
    }

    // Muestra la lista de usuarios registrados
    public function users() {
        $users = User::withCount('bookings')->get();
        return view('admin.users.index', compact('users'));
    }

    public function deleteUser(User $user) {
        // 1. SEGURIDAD: No borrarte a ti mismo
        if ($user->id === auth()->id()) {
            return back()->with('error', '¡No puedes eliminar tu propia cuenta!');
        }

        // 2. BORRAR LA FOTO
        // Usamos la columna real que vimos en la captura: 'avatar'
        $path = $user->avatar;

        // Si tiene avatar y el archivo existe en el disco...
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // 3. BORRAR EL USUARIO
        $user->delete();

        return back()->with('success', 'Usuario y su avatar eliminados correctamente.');
    }
}