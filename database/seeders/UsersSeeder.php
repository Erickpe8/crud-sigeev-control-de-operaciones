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
                'password' => Hash::make('Password123'),
                'birthdate' => Carbon::create(1985, 7, 15),
                'gender_id' => 1, 
                'document_type_id' => 1,
                'user_type_id' => 1, 
                'academic_program_id' => 1, 
                'document_number' => '10012345',
                'institution_id' => 1,
                'accepted_terms' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Erick Sebastián
            [
                'id' => 2,
                'uuid' => Str::uuid(),
                'first_name' => 'Erick',
                'last_name' => 'Sebastián',
                'email' => 'erick.sebastian@comfanorte.edu.co',
                'password' => Hash::make('Password123'),
                'birthdate' => Carbon::create(1992, 3, 22),
                'gender_id' => 1,
                'document_type_id' => 1,
                'user_type_id' => 1,
                'academic_program_id' => 1,
                'document_number' => '10022346',
                'institution_id' => 1,
                'accepted_terms' => true,
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
                'password' => Hash::make('Password123'),
                'birthdate' => Carbon::create(1990, 11, 5),
                'gender_id' => 1, 
                'document_type_id' => 1,
                'user_type_id' => 1,
                'academic_program_id' => 1,
                'document_number' => '10032347',
                'institution_id' => 1,
                'accepted_terms' => true,
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
                'password' => Hash::make('Password123'),
                'birthdate' => Carbon::create(1988, 9, 30),
                'gender_id' => 1,
                'document_type_id' => 1,
                'user_type_id' => 1,
                'academic_program_id' => 1,
                'document_number' => '10042348',
                'institution_id' => 1,
                'accepted_terms' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
