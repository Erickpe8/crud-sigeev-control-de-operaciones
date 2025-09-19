<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * MODALIDADES
     * ===================================
     * Función: Define las modalidades en las que se pueden desarrollar los eventos.
     * Ejemplo: "Presencial", "Virtual", "Híbrido".
     */
    public function up(): void
    {
        Schema::create('modalitys', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); 
            $table->string('name')->unique();  
            $table->boolean('is_active')->default(true); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modalitys');
    }
};
