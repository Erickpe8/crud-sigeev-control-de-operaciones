<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * RELACIÓN EVENTO ↔ HORARIO ↔ UBICACIÓN
     * ===================================
     * Función: Asignar una ubicación y horario a un evento.
     * Ejemplo: Evento "Innovación Tecnológica 2025" → 12 Ago 09:00 → Auditorio Principal FESC.
     */
    public function up(): void
    {
        Schema::create('event_schedule_location', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('schedule_id')->constrained('schedules');
            $table->foreignId('location_id')->constrained('locations');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_schedule_location');
    }
};
