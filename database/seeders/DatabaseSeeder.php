<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar seeders base
        $this->call([
            GendersSeeder::class,
            DocumentTypesSeeder::class,
            UsersTypesSeeder::class,
            InstitutionsSeeder::class,
            AcademicProgramsSeeder::class,
            RoleSeeder::class,
            UsersSeeder::class, // Usuarios fijos con roles
        ]);

        // Crear usuarios aleatorios con factory
        User::factory()->count(100)->create()->each(function ($user) {
            // Asignar rol según tipo de usuario
            if ($user->user_type_id === 1) {
                $user->assignRole('super admin');
            } elseif ($user->user_type_id === 4) {
                $user->assignRole('admin');
            } else {
                $user->assignRole('user');
            }
        });
    }
}
