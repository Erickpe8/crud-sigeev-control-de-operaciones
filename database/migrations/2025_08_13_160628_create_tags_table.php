<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * ETIQUETAS (TAGS)
     * ===================================
     * Función: Añadir etiquetas específicas a eventos.
     * Ejemplo: "Música", "Programación", "Moda".
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // Ej: "Programación"
            $table->string('color'); // Ej: "#FF5733"
            $table->string('description')->nullable(); // Ej: "Eventos relacionados con desarrollo de software"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
