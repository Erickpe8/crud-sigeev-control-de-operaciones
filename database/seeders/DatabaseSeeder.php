<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            GendersSeeder::class,
            DocumentTypesSeeder::class,
            UsersTypesSeeder::class,
            InstitutionsSeeder::class,
            AcademicProgramsSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            UsersSeeder::class,
        ]);

        User::factory()->count(10000)->create()->each(function ($user) {
            if ($user->user_type_id === 1) {
                $user->assignRole('superadmin');
            } elseif ($user->user_type_id === 4) {
                $user->assignRole('admin');
            } else {
                $user->assignRole('user');
            }
        });
    }
}