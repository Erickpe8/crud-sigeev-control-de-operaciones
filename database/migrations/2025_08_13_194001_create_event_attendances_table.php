<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * ASISTENCIA REAL A EVENTOS
     * ===================================
     * Función: Controlar asistencia efectiva de usuarios.
     * Ejemplo: Juan Pérez asistió a Conferencia "IA Aplicada" el 12 Ago 2025.
    */
    public function up(): void
    {
        Schema::create('event_attendances', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('registration_event_id')->nullable()->constrained('registration_event');
            $table->string('access_token')->nullable()->index(); // Código o token de acceso usado en el control de entrada (Ej: código QR "EVT-XYZ-12345")
            $table->timestamp('checked_in_at')->nullable(); // Fecha y hora exacta en la que el usuario ingresó al evento (Ej: "2025-08-12 08:55:00")
            $table->timestamp('checked_out_at')->nullable(); // Fecha y hora exacta en la que el usuario salió del evento (Ej: "2025-08-12 11:10:00")
            $table->enum('status', ['valido', 'rechazado', 'duplicado'])->default('valido'); // Ej: "valido"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendances');
    }
};
