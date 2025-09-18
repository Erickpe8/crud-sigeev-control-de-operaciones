<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class SubscriptionPlanEventAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptionPlanEventAccess = [
            // ==================== PLAN FULL PRESENCIAL FAMILIA FESC ====================
            [
                'uuid' => Str::uuid(),
                'subscription_plan_id' => 1, // Full Presencial Familia FESC
                'category_id' => null,
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso completo a todas las conferencias presenciales',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440002',
                'subscription_plan_id' => 1,
                'category_id' => 2, // Workshops
                'event_id' => null,
                'mode' => 'cuota',
                'quota' => 3,
                'notes' => 'Máximo 3 workshops presenciales'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440003',
                'subscription_plan_id' => 1,
                'category_id' => 4, // Eventos Especiales
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a todos los eventos especiales'
            ],

            // ==================== PLAN FULL PRESENCIAL PARTICULARES ====================
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440004',
                'subscription_plan_id' => 2, // Full Presencial Particulares
                'category_id' => null,
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso completo a todas las conferencias presenciales'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440005',
                'subscription_plan_id' => 2,
                'category_id' => 2, // Workshops
                'event_id' => null,
                'mode' => 'cuota',
                'quota' => 2,
                'notes' => 'Máximo 2 workshops presenciales'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440006',
                'subscription_plan_id' => 2,
                'category_id' => 4, // Eventos Especiales
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a todos los eventos especiales'
            ],

            // ==================== PLAN FULL VIRTUAL FAMILIA FESC ====================
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440007',
                'subscription_plan_id' => 3, // Full Virtual Familia FESC
                'category_id' => null,
                'event_id' => null,
                'mode' => 'denegar',
                'quota' => null,
                'notes' => 'Sin acceso a eventos presenciales'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440008',
                'subscription_plan_id' => 3,
                'category_id' => 1, // Conferencias
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a todas las conferencias virtuales'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440009',
                'subscription_plan_id' => 3,
                'category_id' => 2, // Workshops
                'event_id' => null,
                'mode' => 'cuota',
                'quota' => 2,
                'notes' => 'Máximo 2 workshops virtuales'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440010',
                'subscription_plan_id' => 3,
                'category_id' => 4, // Eventos Especiales
                'event_id' => null,
                'mode' => 'denegar',
                'quota' => null,
                'notes' => 'Sin acceso a eventos especiales presenciales'
            ],

            // ==================== PLAN FULL VIRTUAL PARTICULARES ====================
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440011',
                'subscription_plan_id' => 4, // Full Virtual Particulares
                'category_id' => null,
                'event_id' => null,
                'mode' => 'denegar',
                'quota' => null,
                'notes' => 'Sin acceso a eventos presenciales'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440012',
                'subscription_plan_id' => 4,
                'category_id' => 1, // Conferencias
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a todas las conferencias virtuales'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440013',
                'subscription_plan_id' => 4,
                'category_id' => 2, // Workshops
                'event_id' => null,
                'mode' => 'cuota',
                'quota' => 1,
                'notes' => 'Máximo 1 workshop virtual'
            ],

            // ==================== PLAN ESTÁNDAR PRESENCIAL ====================
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440014',
                'subscription_plan_id' => 5, // Estándar Presencial
                'category_id' => 1, // Conferencias
                'event_id' => null,
                'mode' => 'cuota',
                'quota' => 5,
                'notes' => 'Acceso a 5 conferencias presenciales'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440015',
                'subscription_plan_id' => 5,
                'category_id' => 2, // Workshops
                'event_id' => null,
                'mode' => 'cuota',
                'quota' => 1,
                'notes' => 'Máximo 1 workshop presencial'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440016',
                'subscription_plan_id' => 5,
                'category_id' => 4, // Eventos Especiales
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a eventos especiales'
            ],

            // ==================== PLAN BÁSICO PRESENCIAL ====================
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440017',
                'subscription_plan_id' => 6, // Básico Presencial
                'category_id' => 1, // Conferencias
                'event_id' => null,
                'mode' => 'cuota',
                'quota' => 1,
                'notes' => 'Acceso a 1 conferencia presencial'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440018',
                'subscription_plan_id' => 6,
                'category_id' => 2, // Workshops
                'event_id' => null,
                'mode' => 'denegar',
                'quota' => null,
                'notes' => 'Sin acceso a workshops'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440019',
                'subscription_plan_id' => 6,
                'category_id' => 4, // Eventos Especiales
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a eventos especiales'
            ],

            // ==================== PLAN BÁSICO VIRTUAL ====================
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440020',
                'subscription_plan_id' => 7, // Básico Virtual
                'category_id' => 1, // Conferencias
                'event_id' => null,
                'mode' => 'cuota',
                'quota' => 1,
                'notes' => 'Acceso a 1 conferencia virtual'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440021',
                'subscription_plan_id' => 7,
                'category_id' => 2, // Workshops
                'event_id' => null,
                'mode' => 'denegar',
                'quota' => null,
                'notes' => 'Sin acceso a workshops virtuales'
            ],

            // ==================== PLAN PREMIUM ====================
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440022',
                'subscription_plan_id' => 8, // Premium
                'category_id' => null,
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso VIP a todos los eventos sin restricciones'
            ],

            // ==================== PLAN EMPRESARIAL ====================
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440023',
                'subscription_plan_id' => 9, // Empresarial
                'category_id' => null,
                'event_id' => null,
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso corporativo completo a todos los eventos'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440024',
                'subscription_plan_id' => 9,
                'category_id' => 2, // Workshops
                'event_id' => null,
                'mode' => 'cuota',
                'quota' => 5,
                'notes' => 'Máximo 5 workshops premium por empresa'
            ],

            // ==================== RESTRICCIONES ESPECÍFICAS POR EVENTO ====================
            // Rueda de Negocios solo para planes completos
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440025',
                'subscription_plan_id' => 1, // Familia FESC
                'category_id' => null,
                'event_id' => 59, // Rueda de Negocios
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a rueda de negocios'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440026',
                'subscription_plan_id' => 2, // Particulares
                'category_id' => null,
                'event_id' => 59, // Rueda de Negocios
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a rueda de negocios'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440027',
                'subscription_plan_id' => 6, // Básico Presencial
                'category_id' => null,
                'event_id' => 59, // Rueda de Negocios
                'mode' => 'denegar',
                'quota' => null,
                'notes' => 'Sin acceso a rueda de negocios en plan básico'
            ],

            // Eventos exclusivos para planes superiores
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440028',
                'subscription_plan_id' => 8, // Premium
                'category_id' => null,
                'event_id' => 61, // Evento exclusivo (ejemplo)
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso exclusivo a evento VIP'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440029',
                'subscription_plan_id' => 1, // Familia FESC
                'category_id' => null,
                'event_id' => 61, // Evento exclusivo
                'mode' => 'denegar',
                'quota' => null,
                'notes' => 'Evento exclusivo para plan premium'
            ],

            // Workshops premium con restricciones
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440030',
                'subscription_plan_id' => 1, // Familia FESC
                'category_id' => null,
                'event_id' => 7, // IA para la Generación Gráfica
                'mode' => 'cuota',
                'quota' => 1,
                'notes' => 'Máximo 1 workshop de IA'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440031',
                'subscription_plan_id' => 2, // Particulares
                'category_id' => null,
                'event_id' => 7, // IA para la Generación Gráfica
                'mode' => 'cuota',
                'quota' => 1,
                'notes' => 'Máximo 1 workshop de IA'
            ],

            // Eventos virtuales específicos
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440032',
                'subscription_plan_id' => 3, // Virtual Familia FESC
                'category_id' => null,
                'event_id' => 15, // Logística de Eventos (virtual)
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a conferencia virtual'
            ],
            [
                'uuid' => 'ff0e8400-e29b-41d4-a716-446655440033',
                'subscription_plan_id' => 4, // Virtual Particulares
                'category_id' => null,
                'event_id' => 16, // Estrategias Comerciales (virtual)
                'mode' => 'permitir',
                'quota' => null,
                'notes' => 'Acceso a conferencia virtual'
            ]
        ];

        foreach ($subscriptionPlanEventAccess as $planEventAccess) {
            DB::table('subscription_plan_event_access')->insert($planEventAccess);
        }

        $this->command->info('Permisos de acceso a eventos por plan creados exitosamente!');
    }
}
