<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * PROGRAMAS ACADÉMICOS RELACIONADOS CON EVENTOS
     * ===================================
     * Función: Define los programas académicos de universidades o instituciones que participan 
     * en los eventos, talleres o conferencias.
     * Ejemplo: "Ingeniería de Sistemas", "Administración de Empresas", 
     * "Diseño Gráfico".
     */
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // Ej: "Cultural"
            $table->string('color');  // color de la categoria
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
        Schema::dropIfExists('programs');
    }
};
