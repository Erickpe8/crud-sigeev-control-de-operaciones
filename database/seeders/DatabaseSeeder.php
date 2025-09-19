<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Catálogos base requeridos por Users (FKs)
        $this->call([
            GendersSeeder::class,
            DocumentTypesSeeder::class,
            UsersTypesSeeder::class,
        ]);

        // ── Roles y permisos (Spatie) → antes de UsersSeeder
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // ── Usuarios (ya existen roles/perm y catálogos)
        $this->call([
            UsersSeeder::class,
        ]);

        // ── Resto de seeders de dominio
        $this->call([
            ModalitySeeder::class,
            SubscriptionPlansSeeder::class,
            PlanPricesSeeder::class,
            ProgramsSeeder::class,
            TagSeeder::class,
            LocationsSeeder::class,
            SchedulesSeeder::class,
            AgendasSeeder::class,
            ThemesSeeder::class,
            SpeakerSeeder::class,
            EventsSeeder::class,
            CategorySeeder::class,
            CategoryEventSeeder::class,
            EventThemeSeeder::class,
            EventScheduleLocationSeeder::class,
            EventSpeakerSeeder::class,
            CityToursSeeder::class,
            CityTourPricesSeeder::class,
            SubscriptionPlanCityTourSeeder::class,
            EventTagSeeder::class,
            SubscriptionPlanEventAccessSeeder::class,
        ]);
    }
}
