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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // Identificador único universal (UUID), útil para exponer públicamente sin revelar el ID interno
            $table->string('name'); // Nombre completo de la institución o universidad
            $table->string('acronym')->nullable(); // Sigla o acrónimo (opcional), por ejemplo: UNAL, MIT
            $table->string('city')->nullable(); // Ciudad donde se ubica la institución (opcional)
            $table->string('country')->nullable(); // País de la institución (opcional)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
