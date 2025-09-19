<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * AGENDA DE EVENTOS
     * ===================================
     * Función: Define el cronograma detallado de cada evento, con fecha, hora, lugar y ponente.
     * Ejemplo: "Conferencia de IA" → 14/08/2025 10:00 AM - 11:30 AM, Auditorio Principal.
     */
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id(); // Identificador único de la entrada de agenda
            $table->uuid('uuid')->unique(); // Identificador único universal
            $table->string('title'); // Título específico de la actividad (Ej: "Aplicaciones de IA en Negocios")
            $table->date('start_date'); // Ej: "2025-08-12"
            $table->date('end_date'); // Ej: "2025-08-12"
            $table->time('start_time'); // Ej: "09:00:00"
            $table->time('end_time'); // Ej: "11:00:00"
            $table->text('description')->nullable(); // Descripción breve de la actividad
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
