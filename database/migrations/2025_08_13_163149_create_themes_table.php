<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * ===================================
    * THEMES (EJES TEMÁTICOS)
    * ===================================
    * Función: Almacena los ejes temáticos principales del congreso para clasificar eventos.
    * Relaciones: Se conecta con eventos mediante tabla pivot 'event_theme'.
    * Ejemplo:
    * - Nombre: "Impacto de la Investigación y Tecnología"
    * - Descripción: "Implementación de tecnologías emergentes para impulsar innovación"
    * Uso: Filtrado de actividades, análisis por áreas de conocimiento.
    */
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // Nombre del eje temático (ej: "Dinámicas Mundiales que Transforman Nuestra Industria Turística")
            $table->text('description'); // Descripción detallada del eje temático
            $table->boolean('is_active')->default(true); 
            $table->foreignId('agenda_id')->constrained('agendas'); // Relación con agendas, permite agrupar temas por evento específico
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
