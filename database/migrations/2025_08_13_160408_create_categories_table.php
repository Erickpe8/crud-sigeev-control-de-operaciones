<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * CATEGORÍAS
     * ===================================
     * Función: Agrupar eventos en categorías temáticas o de formato.
     * Ejemplo: "Cultural", "Académico", "Tecnología".
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // Ej: "Cultural"
            $table->boolean('is_active')->default(true);  // estado de la categoria
            $table->string('description')->nullable(); // Ej: "Eventos relacionados con arte, música y patrimonio"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
