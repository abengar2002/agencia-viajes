<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail {
    use HasFactory, Notifiable;

    // Atributos asignables masivamente
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Atributos ocultos (no se envían en JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Conversión automática de tipos
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /* --- Relaciones y Métodos Personalizados --- */

    // Relación: Usuario tiene muchas reservas
    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    // Relación: Usuario tiene muchas reseñas
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    // Verifica si el usuario compró un viaje específico
    public function hasPurchased(Trip $trip) {
        return $this->bookings()->where('trip_id', $trip->id)->exists();
    }

    // Relación de Favoritos (Muchos a Muchos)
    public function favorites() {
        return $this->belongsToMany(Trip::class, 'trip_user')->withTimestamps();
    }
}