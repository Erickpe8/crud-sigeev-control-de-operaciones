<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('speakers')) {
            Schema::create('speakers', function (Blueprint $table) {
                $table->id();
                $table->string('full_name', 180);
                $table->string('email', 120)->nullable()->unique();
                $table->string('phone', 40)->nullable();
                $table->string('company', 120)->nullable();
                $table->string('role', 120)->nullable();
                $table->text('bio')->nullable();
                $table->string('status', 20)->default('activo'); // activo|inactivo
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('speakers', function (Blueprint $table) {
                if (!Schema::hasColumn('speakers','full_name'))   $table->string('full_name',180);
                if (!Schema::hasColumn('speakers','email'))       $table->string('email',120)->nullable()->unique();
                if (!Schema::hasColumn('speakers','phone'))       $table->string('phone',40)->nullable();
                if (!Schema::hasColumn('speakers','company'))     $table->string('company',120)->nullable();
                if (!Schema::hasColumn('speakers','role'))        $table->string('role',120)->nullable();
                if (!Schema::hasColumn('speakers','bio'))         $table->text('bio')->nullable();
                if (!Schema::hasColumn('speakers','status'))      $table->string('status',20)->default('activo');
                if (!Schema::hasColumn('speakers','created_at'))  $table->timestamps();
                if (!Schema::hasColumn('speakers','deleted_at'))  $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        // No la bajamos para no perder datos.
    }
};
