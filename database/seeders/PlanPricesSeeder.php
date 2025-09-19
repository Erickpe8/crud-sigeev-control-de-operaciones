<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\PlanPrice;
use Carbon\Carbon;  


class PlanPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $planPrices = [
            // Planes Familia FESC
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 1,
                'user_type_id' => 1,
                'price' => 180000.00,
                'currency' => 'COP',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 2,
                'user_type_id' => 1,
                'price' => 80000.00,
                'currency' => 'COP'
            ],

            // Planes Particulares - Full
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 3,
                'user_type_id' => 6,
                'price' => 200000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 4,
                'user_type_id' => 6,
                'price' => 100000.00,
                'currency' => 'COP'
            ],

            // Planes Particulares - Estándar y Básico
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 5,
                'user_type_id' => 6,
                'price' => 100000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 6,
                'user_type_id' => 6,
                'price' => 50000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 7,
                'user_type_id' => 6,
                'price' => 50000.00,
                'currency' => 'COP'
            ],

            // City Tour
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 8,
                'user_type_id' => 1,
                'price' => 30000.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 9,
                'user_type_id' => 6,
                'price' => 50000.00,
                'currency' => 'COP'
            ],

            // Planes especiales (gratuitos o con descuentos)
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 10,
                'user_type_id' => 6,
                'price' => 0.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 11,
                'user_type_id' => 6,
                'price' => 0.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 12,
                'user_type_id' => 6,
                'price' => 0.00,
                'currency' => 'COP'
            ],
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 12,
                'user_type_id' => null, // Sin tipo de usuario específico
                'price' => 0.00,
                'currency' => 'COP'
            ],

            // Precios alternativos para diferentes tipos de usuario (ejemplo)
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 3,
                'user_type_id' => 1, // Estudiante comprando plan particular
                'price' => 180000.00, // Precio con descuento estudiantil
                'currency' => 'COP'
            ],
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 4,
                'user_type_id' => 1, // Estudiante comprando plan particular
                'price' => 80000.00, // Precio con descuento estudiantil
                'currency' => 'COP'
            ]
        ];

        foreach ($planPrices as $planPrice) {
            PlanPrice::create($planPrice);
        }

         $this->command->info('precios creadas exitosamente!');
    }
}
