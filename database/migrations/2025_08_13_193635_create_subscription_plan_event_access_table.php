<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * ACCESO DE PLANES A EVENTOS
     * ===================================
     * Función: Define qué eventos o categorías de eventos están disponibles 
     * para un usuario según el plan de suscripción que adquiera.
     * Ejemplo: Un "Plan Básico" solo permite conferencias; 
     * un "Plan Full" permite conferencias y talleres ilimitados.
     */
    public function up(): void
    {
        Schema::create('subscription_plan_event_access', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('event_id')->nullable()->constrained('events');
            $table->enum('mode', ['permitir', 'denegar', 'cuota'])->default('permitir'); // Define si el plan permite, niega o limita (quota) el acceso a un evento
            $table->unsignedInteger('quota')->nullable(); // Límite máximo de eventos permitidos si mode = 'quota' (Ej: 2 talleres)
            $table->string('notes')->nullable(); // Ej: "Incluye máximo 2 talleres premium"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plan_event_access');
    }
};
