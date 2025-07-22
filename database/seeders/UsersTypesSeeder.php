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
            'type' => 'Persona Natural',
            'description' => 'Persona Natural',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'uuid' => Str::uuid(),
            'type' => 'Persona Jurídica',
            'description' => 'Persona Jurídica',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'uuid' => Str::uuid(),
            'type' => 'Compañia',
            'description' => 'Entidad Legal o Coorporación',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'uuid' => Str::uuid(),
            'type' => 'Estudiante',
            'description' => 'Miembro de Academia Institucional',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'uuid' => Str::uuid(),
            'type' => 'Gobierno',
            'description' => 'Gobierno representativo',
            'created_at' => now(),
            'updated_at' => now()
        ]
    ];


        foreach ($user_types as $user_type) {
            UserType::create($user_type);
        }
    }
}
