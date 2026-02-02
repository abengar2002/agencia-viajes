<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    // Campos permitidos para asignación masiva
    protected $fillable = ['name', 'slug'];

    // Relación: Una categoría tiene muchos viajes
    public function trips() {
        return $this->hasMany(Trip::class);
    }
}