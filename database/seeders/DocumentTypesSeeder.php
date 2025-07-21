<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentType;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DocumentTypesSeeder extends Seeder
{
    public function run(): void
    {
        $document_types = [
            [
                'uuid' => Str::uuid(),
                'name' => 'Cédula de Ciudadanía',
                'code' => 'CC',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Pasaporte',
                'code' => 'PASS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Tarjeta de Identidad',
                'code' => 'TI',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Cédula de Extranjería',
                'code' => 'CE',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Tarjeta de Residencia',
                'code' => 'TR',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($document_types as $document_type) {
            DocumentType::create($document_type);
        }
    }
}
