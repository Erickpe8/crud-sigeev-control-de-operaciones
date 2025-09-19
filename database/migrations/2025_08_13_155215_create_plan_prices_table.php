<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * PRECIOS DE PLANES
     * ===================================
     * Función: Precios de cada plan según tipo de usuario.
     * Ejemplo: Plan Full Presencial para "Estudiante" = 80.000 COP.
     */
    public function up(): void
    {
        Schema::create('plan_prices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans'); // Ej: Plan Full Presencial
            $table->foreignId('user_type_id')->nullable()->constrained('user_types'); // Ej: Estudiante
            $table->decimal('price', 10, 2); //Valor del plan en formato numérico con dos decimales Ej: 80000.00
            $table->string('currency', 10)->default('COP'); //Moneda en la que se expresa el precio Ej: "COP"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_prices');
    }
};
