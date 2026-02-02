<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('trips', function (Blueprint $table) {
        // Añadimos la columna category_id que apunta a la tabla categories
        // 'nullable' significa que un viaje puede no tener categoría al principio
        $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            //
        });
    }
};
