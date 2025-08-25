<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'first_name' => 'Manuel',
                'last_name' => 'Parada',
                'email' => 'manuel@fesc.edu.co',
                'password' => Hash::make('Password123'),
                'birthdate' => Carbon::createFromFormat('d/m/Y', '15/07/1985'),
                'gender_id' => 1,
                'document_type_id' => 1,
                'user_type_id' => 1,
                'document_number' => '1001222345',
                'accepted_terms' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'superadmin'
            ],
            [
                'id' => 2,
                'uuid' => Str::uuid(),
                'first_name' => 'Erick',
                'last_name' => 'Perez',
                'email' => 'erick@fesc.edu.co',
                'password' => Hash::make('Password123'),
                'birthdate' => Carbon::createFromFormat('d/m/Y', '21/01/2006'),
                'gender_id' => 1,
                'document_type_id' => 1,
                'user_type_id' => 4,
                'academic_program_id' => 1,
                'document_number' => '1093592445',
                'institution_id' => 1,
                'accepted_terms' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'admin'
            ],
            [
                'id' => 3,
                'uuid' => Str::uuid(),
                'first_name' => 'Nelly',
                'last_name' => 'Cano',
                'email' => 'nelly@fesc.edu.co',
                'password' => Hash::make('Password123'),
                'birthdate' => Carbon::createFromFormat('d/m/Y', '05/11/1990'),
                'gender_id' => 2,
                'document_type_id' => 1,
                'user_type_id' => 4,
                'academic_program_id' => 1,
                'document_number' => '1003222347',
                'institution_id' => 1,
                'accepted_terms' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'user'
            ],
            [
                'id' => 4,
                'uuid' => Str::uuid(),
                'first_name' => 'Santiago',
                'last_name' => 'Rueda',
                'email' => 'santiago@fesc.edu.co',
                'password' => Hash::make('Password123'),
                'birthdate' => Carbon::createFromFormat('d/m/Y', '30/09/1988'),
                'gender_id' => 1,
                'document_type_id' => 1,
                'user_type_id' => 4,
                'academic_program_id' => 1,
                'document_number' => '1002242348',
                'institution_id' => 1,
                'accepted_terms' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'user'
            ]
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);
            $user = User::create($userData);
            $user->assignRole($role);
        }
    }
}
