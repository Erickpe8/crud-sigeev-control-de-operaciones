<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Agenda;
use Carbon\Carbon; 

class AgendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = [
            [
                'uuid'        => Str::uuid(),
                'title'       => 'Proyectando FESC 2025 - II',
                'start_date'  => '2025-10-20',
                'end_date'    => '2025-10-24',
                'start_time'  => '08:00:00',
                'end_time'    => '23:00:00',
                'description' => 'Evento institucional de la FESC: "Impulsamos el Desarrollo Turístico y Productivo de Norte de Santander a través de la Educación Superior", celebrado del 20 al 24 de octubre de 2025.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }

        $this->command->info('Agenda principal insertada correctamente.');
    }
}
