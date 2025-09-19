<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\CityTour;    
use Carbon\Carbon; 

class CityToursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cityTours = [
            [
                'uuid' => Str::uuid(),
                'name' => 'Cúcuta: Destino Fronterizo e Histórico',
                'tour_date' => '2025-10-23',
                'tour_time' => '17:00:00',
                'max_capacity' => 50,
                'description' => 'Recorrido por diferentes sitios representativos de la historia y la cultura de la zona de frontera, dando a conocer monumentos, arquitectura y puntos de interés para los visitantes y propios, ofreciendo una visión enriquecedora y atractiva de la ciudad.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'uuid' => '990e8400-e29b-41d4-a716-446655440002',
                'name' => 'Ruta Patrimonial: Centro Histórico de Cúcuta',
                'tour_date' => '2025-10-24',
                'tour_time' => '09:00:00',
                'max_capacity' => 40,
                'description' => 'Tour especializado por el centro histórico de Cúcuta, visitando edificios patrimoniales, plazas y sitios de interés cultural con guías especializados en historia local.'
            ],
            [
                'uuid' => '990e8400-e29b-41d4-a716-446655440003',
                'name' => 'Gastronomía Fronteriza: Sabores de Norte de Santander',
                'tour_date' => '2025-10-25',
                'tour_time' => '11:00:00',
                'max_capacity' => 25,
                'description' => 'Recorrido gastronómico por los mejores restaurantes y puestos de comida tradicional, degustando platos típicos de la región y conociendo la historia detrás de cada sabor.'
            ],
            [
                'uuid' => '990e8400-e29b-41d4-a716-446655440004',
                'name' => 'Noche de Museos: Cultura Nocturna en Cúcuta',
                'tour_date' => '2025-10-23',
                'tour_time' => '19:00:00',
                'max_capacity' => 35,
                'description' => 'Visita guiada nocturna por los principales museos y centros culturales de la ciudad, con actividades especiales y experiencias interactivas.'
            ],
            [
                'uuid' => '990e8400-e29b-41d4-a716-446655440005',
                'name' => 'Ecoturismo: Parque Nacional Natural Tamá',
                'tour_date' => '2025-10-26',
                'tour_time' => '07:00:00',
                'max_capacity' => 20,
                'description' => 'Excursión al Parque Nacional Natural Tamá, con caminatas ecológicas, avistamiento de fauna y flora, y experiencias de turismo sostenible en entornos naturales protegidos.'
            ]
        ];

        foreach ($cityTours as $citytour) {        
            CityTour::create($citytour);  
        }

        $this->command->info('City Tours creados exitosamente!');
    }
}
