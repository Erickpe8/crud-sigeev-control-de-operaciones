<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
      * ===================================
      * RELACIÓN PLAN ↔ CITY TOUR
      * ===================================
      * Función: Indicar si un city tour está incluido o tiene descuento en un plan.
      * Ejemplo: Plan Full → Tour Histórico incluido.
      */
    public function up(): void
    {
        Schema::create('subscription_plan_city_tour', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans');
            $table->foreignId('city_tour_id')->nullable()->constrained('city_tours');
            $table->boolean('included')->default(false);  // Indica si el city tour está completamente incluido en el plan sin costo extra (Ej: true = incluido)
            $table->decimal('discount_percentage', 5, 2)->nullable(); // Porcentaje de descuento sobre el precio normal del tour si no está incluido gratis (Ej: 20.00 = 20% de descuento)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plan_city_tour');
    }
};
