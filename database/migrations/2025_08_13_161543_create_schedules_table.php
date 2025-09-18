<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * HORARIOS
     * ===================================
     * Función: Gestionar las fechas y horas de eventos y actividades.
     * Ejemplo: Inicio "2025-08-12 09:00:00", Fin "2025-08-12 11:00:00".
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->date('start_date'); // Ej: "2025-08-12"
            $table->date('end_date'); // Ej: "2025-08-12"
            $table->time('start_time'); // Ej: "09:00:00"
            $table->time('end_time'); // Ej: "11:00:00"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
