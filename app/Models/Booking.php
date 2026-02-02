<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    use HasFactory;

    // Permite asignación masiva de datos
    protected $guarded = [];

    // Relación: Pertenece a un Usuario
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relación: Pertenece a un Viaje
    public function trip() {
        return $this->belongsTo(Trip::class);
    }
}