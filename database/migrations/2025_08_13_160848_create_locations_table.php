<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
      * ===================================
      * UBICACIONES
      * ===================================
      * Función: Lugares físicos donde se realizan eventos.
      * Ejemplo: "Auditorio Principal FESC", "Sala de Conferencias Hotel Bolívar".
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');  // nombre de la ubicacion
            $table->string('address');  // direccion de la ubicacion
            $table->string('room')->nullable();  // sala de la ubicacion
            $table->string('image')->nullable();  // imagen de la ubicacion
            $table->string('reference_point')->nullable();  // descripcion de la ubicacion
            $table->string('latitude')->nullable(); // latitud
            $table->string('longitude')->nullable(); // longitud
            $table->text('google_maps_link')->nullable(); // enlace de Google Maps
            $table->string('country')->nullable(); // país
            $table->string('city')->nullable(); // ciudad
            $table->boolean('is_active')->default(true);  // estado de la ubicacion
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
