<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * PRECIOS CITY TOURS
     * ===================================
     * Función: Establecer precios para los city tours según tipo de usuario.
     * Ejemplo: Tour Histórico → Estudiante = 15.000 COP.
     */
    public function up(): void
    {
        Schema::create('city_tour_prices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('city_tour_id')->constrained('city_tours');

            // Tipo de usuario para el que aplica este precio (Ej: Estudiante, Empresario, Público General)
            // Si es NULL, el precio se considera general para cualquier usuario
            $table->foreignId('user_type_id')->nullable()->constrained('user_types');
            $table->decimal('price', 10, 2);  // Precio del tour en formato numérico con decimales (Ej: 15000.00)
            $table->string('currency', 10)->default('COP'); // Moneda en la que se expresa el precio (Ej: "COP", "USD")
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_tour_prices');
    }
};
