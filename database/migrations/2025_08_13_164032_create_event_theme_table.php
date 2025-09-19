<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * ===================================
    * EVENT_THEME (RELACIÓN EVENTOS ↔ EJES TEMÁTICOS)
    * ===================================
    * Función: Establecer relación muchos-a-muchos entre eventos y ejes temáticos del congreso.
    * Campos:
    * - uuid: Identificador único universal para trazabilidad
    * - event_id: FK al evento (ej: Taller de IA para turismo)
    * - theme_id: FK al eje temático (ej: "Tecnología e Innovación")
    * Ejemplo:
    * - event_id: 25 (Conferencia de Fintech)
    * - theme_id: 3 (Modelos de Desarrollo Económico)
    * Uso: Clasificación temática, filtrado de agenda y reportes por área de conocimiento.
    */
    public function up(): void
    {
        Schema::create('event_theme', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('event_id')->constrained();
            $table->foreignId('theme_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_theme');
    }
};
