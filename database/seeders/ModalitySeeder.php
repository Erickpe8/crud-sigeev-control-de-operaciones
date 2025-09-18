<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Modality;
use Carbon\Carbon; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modalities = [
            [
                'name' => 'Presencial',
                'uuid' => Str::uuid(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Virtual',
                'uuid' => Str::uuid(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Híbrido',
                'uuid' => Str::uuid(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'A Distancia',
                'uuid' => Str::uuid(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        foreach ($modalities as $modality) {
            Modality::create($modality);
        }

        $this->command->info('Modalidades creadas exitosamente!');
    }
}
