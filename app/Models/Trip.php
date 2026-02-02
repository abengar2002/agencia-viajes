<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model {
    use HasFactory;

    // Esto permite guardar todos los datos sin restricciones
    protected $guarded = [];

    // Relación: Un viaje tiene muchas reservas
    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    // Relación: Un viaje tiene muchas reseñas
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    protected $fillable = [
        'title', 
        'slug', 
        'destination', 
        'description', 
        'price', 
        'start_date', 
        'end_date', 
        'image',
        'category_id' // <--- NUEVO
    ];

    // Un viaje pertenece a una categoría
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Usuarios que han guardado este viaje
    public function favoritedBy() {
        return $this->belongsToMany(User::class, 'trip_user')->withTimestamps();
    }
}