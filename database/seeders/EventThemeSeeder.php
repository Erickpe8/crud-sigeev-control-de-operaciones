<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class EventThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $eventThemes = [
            // Panel Inaugural - General
            [
                'uuid' => Str::uuid(),
                'event_id' => 1,
                'theme_id' => 1, // General
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Martes 21 - Conferencias (Eje 1: Dinámicas Mundiales)
            [
                'uuid' => Str::uuid(),
                'event_id' => 2,
                'theme_id' => 2, // Dinámicas Mundiales
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 3,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 4,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 5,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 6,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Martes 21 - Talleres (Eje 1: Dinámicas Mundiales)
            [
                'uuid' => Str::uuid(),
                'event_id' => 7,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 8,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 9,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 10,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 11,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 12,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Martes 21 - Conferencias Tarde (Eje 1: Dinámicas Mundiales)
            [
                'uuid' => Str::uuid(),
                'event_id' => 13,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 14,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Martes 21 - Conferencias Virtuales (Eje 1: Dinámicas Mundiales)
            [
                'uuid' => Str::uuid(),
                'event_id' => 15,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 16,
                'theme_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Eventos Culturales Martes 21
            [
                'uuid' => Str::uuid(),
                'event_id' => 17,
                'theme_id' => 5, // Cultural
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 18,
                'theme_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Miércoles 22 - Conferencias (Eje 3: Modelos Globales)
            [
                'uuid' => Str::uuid(),
                'event_id' => 19,
                'theme_id' => 3 // Modelos Globales
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 20,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 21,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 22,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 23,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 24,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 25,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 26,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Miércoles 22 - Talleres (Eje 3: Modelos Globales)
            [
                'uuid' => Str::uuid(),
                'event_id' => 27,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 28,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 29,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 30,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 31,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Miércoles 22 - Conferencias Tarde (Eje 3: Modelos Globales)
            [
                'uuid' => Str::uuid(),
                'event_id' => 32,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 33,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 34,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 35,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Miércoles 22 - Conferencias Virtuales (Eje 3: Modelos Globales)
            [
                'uuid' => Str::uuid(),
                'event_id' => 36,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 37,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Miércoles 22 - Conferencia Final (Eje 3: Modelos Globales)
            [
                'uuid' => Str::uuid(),
                'event_id' => 38,
                'theme_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Eventos Culturales Miércoles 22
            [
                'uuid' => Str::uuid(),
                'event_id' => 39,
                'theme_id' => 5, // Cultural
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 40,
                'theme_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Jueves 23 - Conferencias (Eje 4: Impacto de Investigación y Tecnología)
            [
                'uuid' => Str::uuid(),
                'event_id' => 41,
                'theme_id' => 4, // Impacto de Investigación y Tecnología
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 42,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 43,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 44,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 45,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 46,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 47,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Jueves 23 - Talleres (Eje 4: Impacto de Investigación y Tecnología)
            [
                'uuid' => Str::uuid(),
                'event_id' => 48,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 49,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 50,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 51,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 52,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Jueves 23 - Conferencia Tarde (Eje 4: Impacto de Investigación y Tecnología)
            [
                'uuid' => Str::uuid(),
                'event_id' => 53,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Jueves 23 - Talleres Virtuales (Eje 4: Impacto de Investigación y Tecnología)
            [
                'uuid' => Str::uuid(),
                'event_id' => 54,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 55,
                'theme_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Eventos Culturales Jueves 23
            [
                'uuid' => Str::uuid(),
                'event_id' => 56,
                'theme_id' => 5, // Cultural
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 57,
                'theme_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 58,
                'theme_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Viernes 24 - Rueda de Negocios
            [
                'uuid' => Str::uuid(),
                'event_id' => 59,
                'theme_id' => 6, // Negocios
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Viernes 24 - Eventos Culturales
            [
                'uuid' => Str::uuid(),
                'event_id' => 60,
                'theme_id' => 5, // Cultural
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'event_id' => 61,
                'theme_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($eventThemes as $eventTheme) {
            DB::table('event_theme')->insert($eventTheme);
        }

        $this->command->info('eventos y temas creados exitosamente!');
    }
}
