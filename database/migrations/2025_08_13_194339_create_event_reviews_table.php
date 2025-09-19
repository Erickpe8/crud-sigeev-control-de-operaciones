<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * COMENTARIOS Y RESEÑAS DE EVENTOS
     * ===================================
     * Función: Guardar valoraciones y opiniones de los usuarios sobre eventos.
     * Ejemplo: Juan Pérez calificó con 5 estrellas y comentó "Excelente ponencia".
     */
    public function up(): void
    {
        Schema::create('event_reviews', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('event_attendance_id')->nullable()->constrained('event_attendances');
            $table->tinyInteger('rating')->nullable(); // Calificación del evento en escala numérica (Ej: 1 a 5 estrellas)
            $table->text('comment')->nullable(); // Ej: "Excelente ponencia, aprendí mucho sobre IA aplicada a negocios"
            $table->boolean('is_anonymous')->default(false); // si la calificación es anónima
            $table->boolean('is_positive')->nullable(); // Indica si la reseña es positiva (true) o negativa (false)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_reviews');
    }
};
