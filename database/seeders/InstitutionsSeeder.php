<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InstitutionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutions = [
             // Universidad Francisco de Paula Santander (UFPS) - ID 1
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad Francisco de Paula Santander',
                'acronym' => 'UFPS',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Universidad de Santander (UDES) - ID 2
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad de Santander', 
                'acronym' => 'UDES',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],  
            // Universidad Simón Bolívar (USB) - ID 3
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad Simón Bolívar',
                'acronym' => 'USB',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Universidad Nacional Abierta y a Distancia (UNAD) - ID 4
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad Nacional Abierta y a Distancia',
                'acronym' => 'UNAD',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Servicio Nacional de Aprendizaje (SENA) - ID 5
            [
                'uuid' => Str::uuid(),
                'name' => 'Servicio Nacional de Aprendizaje',
                'acronym' => 'SENA',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Corporación Universitaria Minuto de Dios (UNIMINUTO) - ID 6
            [
                'uuid' => Str::uuid(),
                'name' => 'Corporación Universitaria Minuto de Dios',
                'acronym' => 'UNIMINUTO',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Corporación Universitaria Autónoma de Nariño (AUNAR) - ID 7
            [
                'uuid' => Str::uuid(),
                'name' => 'Corporación Universitaria Autónoma de Nariño',
                 'acronym' => 'AUNAR',
                 'city' => 'Cúcuta',
                 'country' => 'Colombia',
            ],
            // Politécnico Grancolombiano (PGC) - ID 8
            [
                'uuid' => Str::uuid(),
                'name' => 'Politécnico Grancolombiano',
                'acronym' => 'PGC',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Corporación Instituto de Administración y Finanzas (CIAF) - ID 9
            [
                'uuid' => Str::uuid(),
                'name' => 'Corporación Instituto de Administración y Finanzas',
                'acronym' => 'CIAF',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Corporación Universitaria Remington (Uniremington) - ID 10
            [
                'uuid' => Str::uuid(),
                'name' => 'Corporación Universitaria Remington',
                'acronym' => 'Uniremington',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Universidad de Pamplona (Unipamplona) - ID 11
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad de Pamplona',
                'acronym' => 'Unipamplona',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Universidad Cooperativa de Colombia (UCC) - ID 12
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad Cooperativa de Colombia',
                'acronym' => 'UCC',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Universidad de San Buenaventura (USB) - ID 13
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad de San Buenaventura',
                'acronym' => 'USB',
                'city' => 'Medellín',
                'country' => 'Colombia',
            ],
            // Universidad Autónoma de Bucaramanga (UNAB) - ID 14
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad Autónoma de Bucaramanga',
                'acronym' => 'UNAB',
                'city' => 'Bucaramanga',
                'country' => 'Colombia',
            ],
            // Universidad de Investigación y Desarrollo (UDI) - ID 15
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad de Investigación y Desarrollo',
                'acronym' => 'UDI',
                'city' => 'Bucaramanga',
                'country' => 'Colombia',
            ],
            // Universidad Católica de Manizales (UCM) - ID 16
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad Católica de Manizales',
                'acronym' => 'UCM',
                'city' => 'Manizales',
                'country' => 'Colombia',
            ],
            // Universidad EAN (UEAN) - ID 17
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad EAN',
                'acronym' => 'UEAN',
                'city' => 'Bogotá',
                'country' => 'Colombia',
            ],
            // Corporación Universitaria Autónoma del Cauca (CUAC) - ID 18
            [
                'uuid' => Str::uuid(),
                'name' => 'Corporación Universitaria Autónoma del Cauca',
                'acronym' => 'CUAC',
                'city' => 'Valle del Cauca',
                'country' => 'Colombia',
            ],
            // Fundación de Estudios Superiores Comfanorte (FESC) - ID 19
            [
                'uuid' => Str::uuid(),
                'name' => 'Fundación de Estudios Superiores Comfanorte',
                'acronym' => 'FESC',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Escuela de Estudios Técnicos (EDES) - ID 20
            [
                'uuid' => Str::uuid(),
                'name' => 'Escuela de Estudios Técnicos',
                'acronym' => 'EDES',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ],
            // Institución Universitaria ITSA (ITSA) - ID 21
            [
                'uuid' => Str::uuid(),
                'name' => 'Institución Universitaria ITSA',
                'acronym' => 'ITSA',
                'city' => 'Barranquilla',
                'country' => 'Colombia',
            ],
            // Corporación Universitaria Rafael Núñez (CURN) - ID 22
            [
                'uuid' => Str::uuid(),
                'name' => 'Corporación Universitaria Rafael Núñez',
                'acronym' => 'CURN',
                'city' => 'Cartagena',
                'country' => 'Colombia',
            ],
            // Institución Universitaria Digital de Antioquia (IUDA) - ID 23
            [
                'uuid' => Str::uuid(),
                'name' => 'Institución Universitaria Digital de Antioquia',
                'acronym' => 'IUDA',
                'city' => 'Medellín',
                'country' => 'Colombia',
            ],
            // Universidad Libre (Unilibre) - ID 24
            [
                'uuid' => Str::uuid(),
                'name' => 'Universidad Libre',
                'acronym' => 'Unilibre',
                'city' => 'Cúcuta',
                'country' => 'Colombia',
            ]
        ];

        foreach ($institutions as $institution) {
            Institution::create($institution);
        }
    }
}
