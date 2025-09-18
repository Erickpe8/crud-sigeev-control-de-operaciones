<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
      * ===================================
      * TIPOS DE USUARIO
      * ===================================
      * Función: Diferenciar el tipo de usuario (ej: estudiante, empresario).
      * Ejemplo: "Particular", "Expositor".
      */
    public function up(): void
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('type')->unique(); // Tipo de persona
            $table->string('description'); // Descripción del tipo
            $table->boolean('is_active')->default(true); 
            $table->timestamps(); // Fechas de creación y actualización
            $table->softDeletes(); // Borrado suave (deleted_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_types');
    }
};
