<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\UserType;
use Carbon\Carbon;  

class UsersTypesSeeder extends Seeder
{  

    public function run(): void
    {
        $user_types = [
            [
                'uuid' => Str::uuid(),
                'type' => 'Estudiante',
                'description' => 'Usuario con perfil académico estudiantil',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'type' => 'Docente',
                'description' => 'Profesor o instructor académico',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => Str::uuid(),
                'type' => 'Trabajador/Colaborador',
                'description' => 'Personal administrativo o de apoyo institucional',
                'created_at' => now(),
                'updated_at' => now()
            ],  
            [
                'uuid' => Str::uuid(),
                'type' => 'Funcionario Público',
                'description' => 'Empleado de entidad gubernamental',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => Str::uuid(),
                'type' => 'Emprendedor',
                'description' => 'Dueño o fundador de negocio/startup',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => Str::uuid(),
                'type' => 'Independiente',
                'description' => 'Profesional autónomo o freelance',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];


        foreach ($user_types as $user_type) {
            UserType::create($user_type);
        }

        $this->command->info('Tipos de usuario creados exitosamente!');
    }
}
