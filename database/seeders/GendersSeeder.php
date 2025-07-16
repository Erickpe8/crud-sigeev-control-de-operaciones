<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Gender;
use Carbon\Carbon;  

class GendersSeeder extends Seeder
{
   public function run(): void
{
    $genders = [
        [
            'uuid' => Str::uuid(),
            'name' => 'Hombre',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'uuid' => Str::uuid(),
            'name' => 'Mujer',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'uuid' => Str::uuid(),
            'name' => 'Prefiero no decir',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'uuid' => Str::uuid(),
            'name' => 'Otro',
            'created_at' => now(),
            'updated_at' => now()
        ],
    ];

    foreach ($genders as $gender) {
        Gender::create($gender);
    }
}
}
