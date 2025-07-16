<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academic_programs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name'); // Nombre completo del programa
            $table->string('code')->nullable(); // Código del programa
            $table->string('color')->nullable(); // Color del programa
            $table->text('description')->nullable(); // Descripción del programa
            $table->foreignId('institution_id')->constrained(); // Institución institucional
            $table->timestamps(); // Fechas de creación y actualización
            $table->softDeletes(); // Borrado suave (deleted_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_programs');
    }
};
