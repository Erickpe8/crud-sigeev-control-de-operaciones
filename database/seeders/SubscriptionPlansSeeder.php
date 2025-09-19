<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Carbon\Carbon;  

class SubscriptionPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptionsPlans = [
            // Planes para Familia FESC
            [
                'uuid'         => Str::uuid(),
                'name' => 'Plan Full PRESENCIAL - Familia FESC',
                'description' => 'Acceso a todas las conferencias Presenciales del Congreso, de acuerdo a la disponibilidad de salas por aforos. Acceso a las conferencias Virtuales del congreso. Entradas al Panel Inaugural, FESCitval de Cine, Desfile de Modas, Feria Cultural, Fiesta de Cierre.',
                'modality_id' => 1,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid'         => Str::uuid(),
                'name' => 'Plan Full VIRTUAL - Familia FESC',
                'description' => 'Acceso a todas las conferencias virtuales del Congreso. Conexión online al Panel Inaugural, Desfile de Modas y Feria Cultural.',
                'modality_id' => 2,
                'is_active' => true
            ],

            // Planes para Particulares - Full
            [
                'uuid'         => Str::uuid(),
                'name' => 'Plan Full PRESENCIAL - Particulares',
                'description' => 'Acceso a todas las conferencias Presenciales del Congreso, de acuerdo a la disponibilidad de salas por aforos. Acceso a las conferencias Virtuales del congreso. Entradas al Panel Inaugural, FESCitval de Cine, Desfile de Modas, Feria Cultural, Fiesta de Cierre.',
                'modality_id' => 1,
                'is_active' => true
            ],
            [
                'uuid'         => Str::uuid(),
                'name' => 'Plan Full VIRTUAL - Particulares',
                'description' => 'Acceso a todas las conferencias virtuales del Congreso. Conexión online al Panel Inaugural, Desfile de Modas y Feria Cultural.',
                'modality_id' => 2,
                'is_active' => true
            ],

            // Planes para Particulares - Estándar y Básico
            [
                'uuid'         => Str::uuid(),
                'name' => 'Plan Estándar PRESENCIAL - Particulares',
                'description' => 'Acceso a 5 conferencias Presenciales del Congreso, de acuerdo a la disponibilidad de salas por aforos. Acceso a las conferencias Virtuales del congreso. Entradas al Panel Inaugural, FESCitival de Cine, Desfile de Modas, Feria Cultural, Fiesta de Cierre.',
                'modality_id' => 1,
                'is_active' => true
            ],
            [
                'uuid'         => Str::uuid(),
                'name' => 'Plan Básico PRESENCIAL - Particulares',
                'description' => 'Acceso a 1 conferencia Presencial del Congreso, de acuerdo a la disponibilidad de salas por aforos. Entradas al Panel Inaugural, FESCitival de Cine, Desfile de Modas, Feria Cultural, Fiesta de Cierre.',
                'modality_id' => 1,
                'is_active' => true
            ],
            [
                'uuid'         => Str::uuid(),
                'name' => 'Plan Básico VIRTUAL - Particulares',
                'description' => 'Acceso a 1 conferencia virtual del Congreso. Conexión online al Panel Inaugural, Desfile de Modas y Feria Cultural.',
                'modality_id' => 2,
                'is_active' => true
            ],

            // Planes para City Tour
            [
                'uuid'        => Str::uuid(),
                'name'        => 'City Tour - Familia FESC',
                'description' => 'Recorrido por diferentes sitios representativos de la historia y la cultura de la zona de frontera, incluyendo Centro Cultural Quinta Teresa, Cristo Rey, Biblioteca Pública Julio Pérez Ferrero, Parque La Victoria, Cúpula Chata, Catedral de San José, Torre del Reloj, Complejo Histórico Villa del Rosario, Puente Internacional Simón Bolívar, Puente Internacional Tienditas y C.C. a cielo abierto Jardín Plaza.',
                'modality_id' => 1,
                'is_active' => true
            ],
            [
                'uuid'        => Str::uuid(),
                'name'        => 'City Tour - Particulares',
                'description' => 'Recorrido por diferentes sitios representativos de la historia y la cultura de la zona de frontera, incluyendo Centro Cultural Quinta Teresa, Cristo Rey, Biblioteca Pública Julio Pérez Ferrero, Parque La Victoria, Cúpula Chata, Catedral de San José, Torre del Reloj, Complejo Histórico Villa del Rosario, Puente Internacional Simón Bolívar, Puente Internacional Tienditas y C.C. a cielo abierto Jardín Plaza.',
                'modality_id' => 1,
                'is_active' => true
            ],

            // Planes especiales (si los hubiera)
            [
                'uuid'        => Str::uuid(),
                'name'        => 'Plan Invitados Especiales',
                'description' => 'Acceso completo a todas las actividades del congreso, incluyendo eventos especiales y áreas VIP.',
                'modality_id' => 3,
                'is_active' => true
            ],
            [
                'uuid'        => Str::uuid(),
                'name'        => 'Plan Prensa y Medios',
                'description' => 'Acceso especial para medios de comunicación con credenciales de prensa.',
                'modality_id' => 3,
                'is_active' => true
            ],
            [
                'uuid'        => Str::uuid(),
                'name'        => 'Plan Expositores',
                'description' => 'Plan especial para expositores y participantes de la feria cultural y rueda de negocios.',
                'modality_id' => 1,
                'is_active' => true
            ]
        ];

        foreach ($subscriptionsPlans as $subscriptionPlan) {
            SubscriptionPlan::create($subscriptionPlan);
        }

        $this->command->info('Planes de suscripción creados exitosamente!');
    }
}
