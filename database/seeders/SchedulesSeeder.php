<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Schedule;
use Carbon\Carbon;  


class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            // Panel Inaugural - Lunes 20 de octubre
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-20',
                'end_date' => '2025-10-20',
                'start_time' => '18:00:00',
                'end_time' => '20:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Martes 21 - Mañana (Conferencias)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-21',
                'end_date' => '2025-10-21',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-21',
                'end_date' => '2025-10-21',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00'
            ],

            // Martes 21 - Tarde (Workshops)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-21',
                'end_date' => '2025-10-21',
                'start_time' => '14:00:00',
                'end_time' => '17:00:00'
            ],

            // Martes 21 - Tarde (Conferencias)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-21',
                'end_date' => '2025-10-21',
                'start_time' => '17:00:00',
                'end_time' => '18:30:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-21',
                'end_date' => '2025-10-21',
                'start_time' => '18:30:00',
                'end_time' => '20:00:00'
            ],

            // Martes 21 - Festival de Cine
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-21',
                'end_date' => '2025-10-21',
                'start_time' => '14:00:00',
                'end_time' => '18:00:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-21',
                'end_date' => '2025-10-21',
                'start_time' => '19:00:00',
                'end_time' => '21:00:00'
            ],

            // Miércoles 22 - Mañana (Conferencias)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00'
            ],

            // Miércoles 22 - Tarde (Workshops)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '14:00:00',
                'end_time' => '17:00:00'
            ],

            // Miércoles 22 - Tarde (Conferencias)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '17:00:00',
                'end_time' => '18:30:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '18:30:00',
                'end_time' => '20:00:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '20:00:00',
                'end_time' => '21:30:00'
            ],

            // Miércoles 22 - Mesa Redonda
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '16:00:00',
                'end_time' => '17:00:00'
            ],

            // Miércoles 22 - Festival de Cine
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '14:00:00',
                'end_time' => '18:00:00'
            ],

            // Jueves 23 - Mañana (Conferencias)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00'
            ],

            // Jueves 23 - Tarde (Workshops)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '14:00:00',
                'end_time' => '17:00:00'
            ],

            // Jueves 23 - Tarde (Conferencias)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '17:00:00',
                'end_time' => '18:30:00'
            ],

            // Jueves 23 - Tarde (Virtual Workshops)
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '17:00:00',
                'end_time' => '18:30:00'
            ],

            // Jueves 23 - City Tour
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '17:00:00',
                'end_time' => '19:00:00'
            ],

            // Jueves 23 - Desfile de Modas
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '20:00:00',
                'end_time' => '23:00:00'
            ],

            // Jueves 23 - Festival de Cine
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '14:00:00',
                'end_time' => '18:00:00'
            ],

            // Viernes 24 - Rueda de Negocios
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-24',
                'end_date' => '2025-10-24',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00'
            ],

            // Viernes 24 - Feria Cultural
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-24',
                'end_date' => '2025-10-24',
                'start_time' => '08:00:00',
                'end_time' => '18:00:00'
            ],

            // Viernes 24 - Fiesta de Cierre
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-24',
                'end_date' => '2025-10-24',
                'start_time' => '19:00:00',
                'end_time' => '22:00:00'
            ],

            // Horarios adicionales para eventos que se repiten
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-21',
                'end_date' => '2025-10-21',
                'start_time' => '09:30:00',
                'end_time' => '10:00:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-21',
                'end_date' => '2025-10-21',
                'start_time' => '11:30:00',
                'end_time' => '14:00:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '09:30:00',
                'end_time' => '10:00:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '11:30:00',
                'end_time' => '14:00:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '09:30:00',
                'end_time' => '10:00:00'
            ],
            [
                'uuid' => Str::uuid(),
                'start_date' => '2025-10-23',
                'end_date' => '2025-10-23',
                'start_time' => '11:30:00',
                'end_time' => '14:00:00'
            ]
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }

        $this->command->info('Horarios creados exitosamente!');
    }
}
