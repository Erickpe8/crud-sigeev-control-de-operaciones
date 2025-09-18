<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class SubscriptionPlanCityTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptionPlanCityTours = [
            // Plan Full Presencial Familia FESC - Incluye City Tour gratis
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 1, // Full Presencial Familia FESC
                'city_tour_id' => 1, // Cúcuta: Destino Fronterizo e Histórico
                'included' => true,
                'discount_percentage' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440002',
                'subscription_plan_id' => 1,
                'city_tour_id' => 2, // Ruta Patrimonial
                'included' => false,
                'discount_percentage' => 20.00 // 20% de descuento
            ],
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440003',
                'subscription_plan_id' => 1,
                'city_tour_id' => 3, // Gastronomía Fronteriza
                'included' => false,
                'discount_percentage' => 15.00 // 15% de descuento
            ],

            // Plan Full Presencial Particulares - Incluye City Tour con descuento
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440004',
                'subscription_plan_id' => 2, // Full Presencial Particulares
                'city_tour_id' => 1, // Cúcuta: Destino Fronterizo e Histórico
                'included' => false,
                'discount_percentage' => 25.00 // 25% de descuento
            ],
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440005',
                'subscription_plan_id' => 2,
                'city_tour_id' => 2, // Ruta Patrimonial
                'included' => false,
                'discount_percentage' => 20.00 // 20% de descuento
            ],

            // Plan Full Virtual Familia FESC - No incluye City Tours físicos
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440006',
                'subscription_plan_id' => 3, // Full Virtual Familia FESC
                'city_tour_id' => 1,
                'included' => false,
                'discount_percentage' => 10.00 // 10% de descuento
            ],

            // Plan Full Virtual Particulares - No incluye City Tours físicos
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440007',
                'subscription_plan_id' => 4, // Full Virtual Particulares
                'city_tour_id' => 1,
                'included' => false,
                'discount_percentage' => 15.00 // 15% de descuento
            ],

            // Plan Estándar Presencial - Descuento moderado
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440008',
                'subscription_plan_id' => 5, // Estándar Presencial
                'city_tour_id' => 1,
                'included' => false,
                'discount_percentage' => 15.00 // 15% de descuento
            ],
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440009',
                'subscription_plan_id' => 5,
                'city_tour_id' => 4, // Noche de Museos
                'included' => false,
                'discount_percentage' => 10.00 // 10% de descuento
            ],

            // Plan Básico Presencial - Descuento básico
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440010',
                'subscription_plan_id' => 6, // Básico Presencial
                'city_tour_id' => 1,
                'included' => false,
                'discount_percentage' => 10.00 // 10% de descuento
            ],

            // Plan Básico Virtual - Descuento mínimo
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440011',
                'subscription_plan_id' => 7, // Básico Virtual
                'city_tour_id' => 1,
                'included' => false,
                'discount_percentage' => 5.00 // 5% de descuento
            ],

            // Plan Premium (si existe) - Incluye múltiples tours gratis
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440012',
                'subscription_plan_id' => 8, // Premium (ejemplo)
                'city_tour_id' => 1,
                'included' => true,
                'discount_percentage' => null
            ],
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440013',
                'subscription_plan_id' => 8,
                'city_tour_id' => 2,
                'included' => true,
                'discount_percentage' => null
            ],
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440014',
                'subscription_plan_id' => 8,
                'city_tour_id' => 4,
                'included' => true,
                'discount_percentage' => null
            ],

            // Plan Empresarial (si existe) - Descuentos corporativos
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440015',
                'subscription_plan_id' => 9, // Empresarial (ejemplo)
                'city_tour_id' => 1,
                'included' => false,
                'discount_percentage' => 30.00 // 30% de descuento corporativo
            ],
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440016',
                'subscription_plan_id' => 9,
                'city_tour_id' => 3,
                'included' => false,
                'discount_percentage' => 25.00 // 25% de descuento corporativo
            ],
            [
                'uuid' => 'cc0e8400-e29b-41d4-a716-446655440017',
                'subscription_plan_id' => 9,
                'city_tour_id' => 5,
                'included' => false,
                'discount_percentage' => 35.00 // 35% de descuento corporativo
            ]
        ];

        foreach ($subscriptionPlanCityTours as $subscriptionPlanCityTour) {
            DB::table('subscription_plan_city_tour')->insert($subscriptionPlanCityTour);
        }

         $this->command->info('Subscription Plan City Tours creados exitosamente!');

    }
}
