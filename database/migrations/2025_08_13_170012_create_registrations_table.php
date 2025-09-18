<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
      * ===================================
      * REGISTROS DE PLANES
      * ===================================
      * Función: Registro de usuarios en planes.
      * Ejemplo: Juan Pérez inscrito en Plan Full.
      */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans');
            $table->dateTime('registered_at')->default(now()); // Ej: "2025-07-01 10:00:00"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
