<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
      * ===================================
      * EVENTOS
      * ===================================
      * Función: Información principal de cada evento.
      * Ejemplo: Conferencia "Innovación Tecnológica 2025".
    */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title', 200); // Ej: "Innovación Tecnológica 2025"
            $table->string('image')->nullable(); // Ej: "https://evento.com/imagenes/innovacion2025.jpg"
            $table->text('description')->nullable(); // Ej: "Evento para explorar las tendencias en IA, IoT y blockchain aplicadas a negocios"
            $table->unsignedInteger('max_capacity')->nullable(); // Ej: 200
            $table->string('virtual_link', 255)->nullable(); // Ej: "https://evento.com/sala1"
            $table->foreignId('modality_id')->constrained('modalitys'); // Ej: "presencial"
            $table->boolean('is_active')->default(true); // Ej: true
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
