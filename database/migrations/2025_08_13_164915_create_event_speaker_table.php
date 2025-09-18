<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
      * ===================================
      * RELACIÓN EVENTO ↔ EXPOSITOR
      * ===================================
      * Función: Un evento puede tener varios expositores y un expositor puede participar en varios eventos.
      * Ejemplo: Conferencia "Innovación Tecnológica" con expositores "María Gómez" y "Carlos Pérez".
    */
    public function up(): void
    {
        Schema::create('event_speaker', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('speaker_id')->constrained('speakers');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_speaker');
    }
};
