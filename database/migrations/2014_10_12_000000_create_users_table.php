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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('first_name'); // Nombres
            $table->string('last_name');  // Apellidos
            $table->string('email')->unique(); // Email
            $table->date('birthdate'); // Fecha de nacimiento

            // Foto de perfil
            $table->string('profile_photo')->nullable();

            // Foreign keys
            $table->foreignId('gender_id')->constrained(); // Género
            $table->foreignId('document_type_id')->constrained(); // Tipo de documento
            $table->foreignId('user_type_id')->constrained(); // Tipo de persona
            $table->foreignId('academic_program_id')->nullable()->constrained(); // Programa académico

            // Documentación
            $table->string('document_number')->unique(); // Número de documento

            // Institución
            $table->foreignId('institution_id')->nullable()->constrained();

            // Información empresarial
            $table->string('company_name')->nullable();    // Nombre de la compañía
            $table->text('company_address')->nullable();   // Dirección de la compañía
            $table->string('phone', 20)->nullable();       // Teléfono

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
