<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Manuel Parada
            [
                'id' => 1, 
                'uuid' => Str::uuid(),
                'first_name' => 'Manuel',
                'last_name' => 'Parada',
                'email' => 'manuel.parada@comfanorte.edu.co',
                'phone' => '3001234567',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'birthdate' => Carbon::create(1992, 3, 22),
                'gender_id' => 1, // Hombre
                'document_type_id' => 1, // CC
                'user_type_id' => 2, // Docente
                'document_number' => '1002003001',
                'institution_name' => 'Universidad FESC',
                'academic_program' => 'Ingeniería de Sistemas',
                'status' => 1,
                'accepted_terms' => 1,
                'password' => Hash::make('Password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // Erick Sebastián
            [
                'id' => 2,
                'uuid' => Str::uuid(),
                'first_name' => 'Erick',
                'last_name' => 'Sebastián',
                'email' => 'erick.sebastian@comfanorte.edu.co',
                'phone' => '3001234567',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'birthdate' => Carbon::create(1992, 3, 22),
                'gender_id' => 1, // Hombre
                'document_type_id' => 1, // CC
                'user_type_id' => 1, // Estudiante
                'document_number' => '1002873001',
                'institution_name' => 'Universidad FESC',
                'academic_program' => 'Ingeniería de Software',
                'status' => 1,
                'accepted_terms' => true,
                'password' => Hash::make('Password123'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Nelly Cano
            [
                'id' => 3,
                'uuid' => Str::uuid(),
                'first_name' => 'Nelly',
                'last_name' => 'Cano',
                'email' => 'nelly.cano@comfanorte.edu.co',
                'phone' => '3701234567',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'birthdate' => Carbon::create(1990, 11, 5),
                'gender_id' => 2, 
                'document_type_id' => 1,
                'user_type_id' => 1,
                'document_number' => '10032347',
                'institution_name' => 'Universidad FESC',
                'academic_program' => 'Ingeniería de Software',
                'status' => 1,
                'accepted_terms' => true,
                'password' => Hash::make('Password123'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Santiago Rueda
            [
                'id' => 4,
                'uuid' => Str::uuid(),
                'first_name' => 'Santiago',
                'last_name' => 'Rueda',
                'email' => 'santiago.rueda@comfanorte.edu.co',
                'phone' => '3001234567',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'birthdate' => Carbon::create(1988, 9, 30),
                'gender_id' => 1,
                'document_type_id' => 1,
                'user_type_id' => 1,
                'document_number' => '1002773001',
                'institution_name' => 'Universidad FESC',
                'academic_program' => 'Ingeniería de Software',
                'status' => 1,
                'accepted_terms' => true,
                'password' => Hash::make('Password123'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('Usuarios creados exitosamente!');
    }
}
