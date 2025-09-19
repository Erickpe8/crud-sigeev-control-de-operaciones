<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class CityTourPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $cityTourPrices = [
            // ==================== TOUR 1: Cúcuta Destino Fronterizo e Histórico ====================
            [
                'uuid' => Str::uuid(),
                'city_tour_id' => 1,
                'user_type_id' => 1, // Estudiante
                'price' => 25000.00,
                'currency' => 'COP',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440002',
                'city_tour_id' => 1,
                'user_type_id' => 2, // Docente
                'price' => 30000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440003',
                'city_tour_id' => 1,
                'user_type_id' => 3, // Empresario
                'price' => 40000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440004',
                'city_tour_id' => 1,
                'user_type_id' => 4, // Público General
                'price' => 50000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440005',
                'city_tour_id' => 1,
                'user_type_id' => null, // Precio general (si no se especifica tipo de usuario)
                'price' => 45000.00,
                'currency' => 'COP'
            ],

            // ==================== TOUR 2: Ruta Patrimonial ====================
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440006',
                'city_tour_id' => 2,
                'user_type_id' => 1, // Estudiante
                'price' => 20000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440007',
                'city_tour_id' => 2,
                'user_type_id' => 2, // Docente
                'price' => 25000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440008',
                'city_tour_id' => 2,
                'user_type_id' => 4, // Público General
                'price' => 35000.00,
                'currency' => 'COP'
            ],

            // ==================== TOUR 3: Gastronomía Fronteriza ====================
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440009',
                'city_tour_id' => 3,
                'user_type_id' => 1, // Estudiante
                'price' => 35000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440010',
                'city_tour_id' => 3,
                'user_type_id' => 2, // Docente
                'price' => 40000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440011',
                'city_tour_id' => 3,
                'user_type_id' => 3, // Empresario
                'price' => 50000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440012',
                'city_tour_id' => 3,
                'user_type_id' => 4, // Público General
                'price' => 55000.00,
                'currency' => 'COP'
            ],

            // ==================== TOUR 4: Noche de Museos ====================
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440013',
                'city_tour_id' => 4,
                'user_type_id' => 1, // Estudiante
                'price' => 15000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440014',
                'city_tour_id' => 4,
                'user_type_id' => 2, // Docente
                'price' => 20000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440015',
                'city_tour_id' => 4,
                'user_type_id' => null, // Precio general
                'price' => 25000.00,
                'currency' => 'COP'
            ],

            // ==================== TOUR 5: Ecoturismo Parque Tamá ====================
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440016',
                'city_tour_id' => 5,
                'user_type_id' => 1, // Estudiante
                'price' => 80000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440017',
                'city_tour_id' => 5,
                'user_type_id' => 2, // Docente
                'price' => 90000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440018',
                'city_tour_id' => 5,
                'user_type_id' => 3, // Empresario
                'price' => 120000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440019',
                'city_tour_id' => 5,
                'user_type_id' => 4, // Público General
                'price' => 150000.00,
                'currency' => 'COP'
            ],

            // ==================== PRECIOS EN USD PARA TURISTAS INTERNACIONALES ====================
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440020',
                'city_tour_id' => 1,
                'user_type_id' => 5, // Turista Internacional
                'price' => 15.00,
                'currency' => 'USD'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440021',
                'city_tour_id' => 3,
                'user_type_id' => 5, // Turista Internacional
                'price' => 18.00,
                'currency' => 'USD'
            ],
            [
                'uuid' => 'bb0e8400-e29b-41d4-a716-446655440022',
                'city_tour_id' => 5,
                'user_type_id' => 5, // Turista Internacional
                'price' => 35.00,
                'currency' => 'USD'
            ]
        ];

        foreach ($cityTourPrices as $price) {
            DB::table('city_tour_prices')->insert($price);
        }

        $this->command->info('City Tour Prices creados exitosamente!');
    }
}
