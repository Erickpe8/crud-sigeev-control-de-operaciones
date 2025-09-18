<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * CITY TOURS
     * ===================================
     * Función: Paseos turísticos organizados como parte del evento.
     * Ejemplo: "Recorrido Histórico por el Centro de Cúcuta".
     */
    public function up(): void
    {
        Schema::create('city_tours', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // Ej: "Recorrido Histórico por el Centro de Cúcuta"
            $table->date('tour_date')->nullable(); // Ej: "2025-08-14"
            $table->time('tour_time')->nullable(); // Hora de inicio del tour (Ej: "09:30:00")
            $table->unsignedInteger('max_capacity')->nullable(); // Ej: 30
            $table->text('description')->nullable(); // Ej: "Visita guiada por sitios emblemáticos de la ciudad con historia y gastronomía local"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_tours');
    }
};
