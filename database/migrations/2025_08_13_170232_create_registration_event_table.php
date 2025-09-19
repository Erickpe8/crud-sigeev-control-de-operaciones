<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
      * ===================================
      * REGISTRO EVENTOS DEL USUARIO
      * ===================================
      * Función: Eventos a los que un usuario se inscribió dentro de su plan.
      * Ejemplo: Juan Pérez inscrito en Conferencia "IA Aplicada".
      */
    public function up(): void
    {
        Schema::create('registration_event', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('registration_id');
            $table->foreignId('event_id')->constrained('events');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_event');
    }
};
