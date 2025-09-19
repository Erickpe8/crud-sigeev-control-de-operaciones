<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * PLANES DE SUSCRIPCIÓN
     * ===================================
     * Función: Define los planes que un usuario puede adquirir.
     * Ejemplo: "Plan Full Presencial", "Plan Básico Virtual".
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->unique(); // Ej: "Plan Full Presencial"
            $table->text('description')->nullable(); // Ej: "Incluye acceso ilimitado a todas las conferencias presenciales y virtuales"
            $table->foreignId('modality_id')->constrained('modalitys');
            $table->boolean('is_active')->default(true); // Ej: true
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
