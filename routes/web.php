<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\FavoriteController; // Asegúrate de que esto esté aquí

/*
|--------------------------------------------------------------------------
| 1. ZONA PÚBLICA (Acceso libre)
|--------------------------------------------------------------------------
*/

// Página de inicio: Catálogo de viajes y filtros
Route::get('/', [TripController::class, 'index'])->name('home');

// Detalle del viaje: Muestra información específica
Route::get('/trips/{trip:slug}', [TripController::class, 'show'])->name('trips.show');

/*
|--------------------------------------------------------------------------
| 2. ZONA DE USUARIOS (Requiere Login y Verificación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Panel de Usuario: Mis Reservas
    Route::get('/dashboard', function () {
        $bookings = auth()->user()->bookings()->with('trip')->latest()->get();
        return view('dashboard', compact('bookings'));
    })->name('dashboard');

    // Gestión de Reservas (Comprar y Cancelar)
    Route::post('/trips/{trip}/book', [TripController::class, 'book'])->name('trips.book');
    Route::delete('/bookings/{booking}/cancel', [TripController::class, 'cancelBooking'])->name('bookings.cancel');

    // Gestión de Reseñas
    Route::post('/trips/{trip}/review', [TripController::class, 'storeReview'])->name('trips.review');
    Route::get('/reviews/{review}/edit', [TripController::class, 'editReview'])->name('reviews.edit');
    Route::put('/reviews/{review}', [TripController::class, 'updateReview'])->name('reviews.update');
    Route::delete('/reviews/{review}', [TripController::class, 'deleteReview'])->name('reviews.delete');

    // --- AQUÍ ES DONDE DEBE IR LA RUTA DE FAVORITOS ---
    // (Cualquier usuario logueado puede dar like)
    Route::post('/trips/{trip}/favorite', [FavoriteController::class, 'toggle'])->name('trips.favorite');
    // Ver mis favoritos
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

/*
|--------------------------------------------------------------------------
| 3. PERFIL DE USUARIO (Configuración de cuenta)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| 4. ZONA DE ADMINISTRACIÓN (Acceso restringido)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Panel Principal del Administrador
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // CRUD de Viajes
        Route::get('/trips', [AdminController::class, 'trips'])->name('trips.index');
        Route::get('/trips/create', [AdminController::class, 'create'])->name('trips.create');
        Route::post('/trips', [AdminController::class, 'store'])->name('trips.store');
        Route::get('/trips/{trip}/edit', [AdminController::class, 'edit'])->name('trips.edit');
        Route::put('/trips/{trip}', [AdminController::class, 'update'])->name('trips.update');
        Route::delete('/trips/{trip}', [AdminController::class, 'deleteTrip'])->name('trips.destroy');
        
        // (He quitado la ruta de favoritos de aquí porque estaba mal puesta)

        // Gestión de Reservas
        Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings.index');
        Route::delete('/bookings/{booking}', [AdminController::class, 'deleteBooking'])->name('bookings.destroy');

        // Moderación
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
        Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('reviews.destroy');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    });

require __DIR__ . '/auth.php'; 