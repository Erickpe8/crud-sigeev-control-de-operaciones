<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ===================================
     * USUARIOS
     * ===================================
     * Función: Almacenar datos de todos los usuarios registrados en el sistema.
     * Ejemplo: Un asistente, un expositor o un administrador.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('first_name'); // Nombres
            $table->string('last_name'); //apellidos
            $table->string('email')->unique(); //email
            $table->string('phone'); //teléfono
            $table->string('country'); //país
            $table->string('city'); //ciudad
            $table->date('birthdate'); //fecha de cumpleaños

            $table->string('profile_photo')->nullable(); // Foto de perfil

            $table->foreignId('gender_id')->constrained(); // Género
            $table->foreignId('document_type_id')->constrained(); // Tipo de documento
            $table->foreignId('user_type_id')->constrained(); // Tipo de persona
            $table->string('document_number')->unique(); // Número de documento
        
            // Estudiante
            $table->string('institution_name')->nullable();  // Nombre de la institución educativa
            $table->string('academic_program')->nullable();  // Programa académico
            $table->string('modality')->nullable();  // Programa académico

            // Campos específicos para Docentes
            $table->string('university')->nullable();

            // campos de Empresa / Institución (Trabajador/Funcionario)
            $table->string('company_name')->nullable(); // Nombre de la compañía
            $table->string('company_position')->nullable(); // Cargo en la compañía
            $table->text('company_address')->nullable(); // Dirección de la compañía

            // Emprendedor
            $table->string('entrepreneur_name')->nullable();
            $table->string('product_type')->nullable();

            // Independiente
            $table->string('occupation')->nullable();

            $table->boolean('status')->default(true); // Estado del usuario (activo/inactivo)

            // Términos y condiciones
            $table->boolean('accepted_terms')->default(false); // Aceptación de términos

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // Borrado suave (deleted_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
