<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('events')) {
            // Si NO existe, se crea normal
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->string('title', 180);
                $table->text('description')->nullable();
                $table->dateTime('start_at')->nullable();
                $table->dateTime('end_at')->nullable();
                $table->string('location', 180)->nullable();
                $table->unsignedInteger('capacity')->nullable();
                $table->string('status', 20)->default('activo'); // activo|inactivo
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            // Si SÍ existe, solo aseguramos columnas faltantes
            Schema::table('events', function (Blueprint $table) {
                if (!Schema::hasColumn('events', 'title')) {
                    $table->string('title', 180)->after('id');
                }
                if (!Schema::hasColumn('events', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::hasColumn('events', 'start_at')) {
                    $table->dateTime('start_at')->nullable();
                }
                if (!Schema::hasColumn('events', 'end_at')) {
                    $table->dateTime('end_at')->nullable();
                }
                if (!Schema::hasColumn('events', 'location')) {
                    $table->string('location', 180)->nullable();
                }
                if (!Schema::hasColumn('events', 'capacity')) {
                    $table->unsignedInteger('capacity')->nullable();
                }
                if (!Schema::hasColumn('events', 'status')) {
                    $table->string('status', 20)->default('activo');
                }
                if (!Schema::hasColumn('events', 'created_at')) {
                    $table->timestamps();
                }
                if (!Schema::hasColumn('events', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    public function down(): void
    {
        // NO borramos la tabla (puedes tener datos). Solo retiramos columnas que
        // esta migración pudo haber agregado.
        Schema::table('events', function (Blueprint $table) {
            // Ojo: quitar columnas una por una si existen
            if (Schema::hasColumn('events','deleted_at')) { $table->dropSoftDeletes(); }
            // Quitar timestamps solo si no los usas en otros lados:
            // if (Schema::hasColumn('events','created_at') && Schema::hasColumn('events','updated_at')) { $table->dropTimestamps(); }

            // Estas solo si sabes que las añadió esta migración. Normalmente NO las quitamos.
            // if (Schema::hasColumn('events','status'))   { $table->dropColumn('status'); }
            // if (Schema::hasColumn('events','capacity')) { $table->dropColumn('capacity'); }
            // if (Schema::hasColumn('events','location')) { $table->dropColumn('location'); }
            // if (Schema::hasColumn('events','end_at'))   { $table->dropColumn('end_at'); }
            // if (Schema::hasColumn('events','start_at')) { $table->dropColumn('start_at'); }
            // if (Schema::hasColumn('events','description')) { $table->dropColumn('description'); }
            // if (Schema::hasColumn('events','title'))    { $table->dropColumn('title'); }
        });
    }
};
