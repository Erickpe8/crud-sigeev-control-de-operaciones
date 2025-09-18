<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
      * ===================================
      * EXPOSITORES
      * ===================================
      * Función: Información de los ponentes o conferencistas.
      * Ejemplo: "María Gómez - Ingeniera de Software con 10 años de experiencia".
      */
    public function up(): void
    {
        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // Ej: "María Gómez"
            $table->string('profession')->nullable(); // Ej: "Ingeniera de Software"
            $table->text('bio')->nullable(); // Ej: "Especialista en inteligencia artificial y análisis de datos con más de 10 años de experiencia..."
            $table->string('photo')->nullable(); // Ej: "https://evento.com/fotos/maria-gomez.jpg"
            $table->string('website')->nullable(); // Ej: "https://mariagomez.com"
            $table->string('social_links')->nullable(); // Ej: "https://linkedin.com/in/mariagomez"
            $table->boolean('is_active')->default(true); // tema activo true / false
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
