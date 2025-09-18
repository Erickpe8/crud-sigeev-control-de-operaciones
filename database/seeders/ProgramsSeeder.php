<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Program;
use Carbon\Carbon;  


class ProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'uuid' => Str::uuid(),
                'name' => 'Software',
                'color' => '#5174fd', // Azul
                'description' => 'Eventos relacionados con desarrollo de software, programación y tecnologías digitales',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Turismo',
                'color' => '#00baa5', // Verde
                'description' => 'Eventos sobre destinos turísticos, hotelería y gestión de viajes'
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Gráfico',
                'color' => '#ecb400', // Amarillo
                'description' => 'Diseño gráfico, ilustración, branding y comunicación visual'
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Moda',
                'color' => '#784efa', // fucsia
                'description' => 'Eventos de diseño de moda, tendencias y pasarelas'
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Logística',
                'color' => '#fc243c', // Rojo
                'description' => 'Gestión de suministro'
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Bienestar',
                'color' => '#d1d5db', // Gris
                'description' => 'Salud, fitness, mindfulness y vida saludable'
            ]
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }

        $this->command->info('Programas creados exitosamente!');
    }

}
