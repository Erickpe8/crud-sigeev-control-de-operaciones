<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class EventSpeakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventSpeakers = [
            // Panel Inaugural
            [
                'uuid' => Str::uuid(),
                'event_id' => 1,
                'speaker_id' => 1, // Julio Cesar Acosta Prado
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440002',
                'event_id' => 1,
                'speaker_id' => 2 // Manuel Fernández - Villacañas Marín
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440003',
                'event_id' => 1,
                'speaker_id' => 3 // Juan Carlos Peña Castro
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440004',
                'event_id' => 1,
                'speaker_id' => 4 // Natalia Bayona
            ],

            // Martes 21 - Conferencias
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440005',
                'event_id' => 2,
                'speaker_id' => 5 // Federico De Arteaga
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440006',
                'event_id' => 3,
                'speaker_id' => 6 // Javier Suescún Duarte
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440007',
                'event_id' => 4,
                'speaker_id' => 7 // María Cecilia López Barrios
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440008',
                'event_id' => 5,
                'speaker_id' => 8 // Juan Carlos León
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440009',
                'event_id' => 6,
                'speaker_id' => 9 // Alberto Mena Claros
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440010',
                'event_id' => 13,
                'speaker_id' => 9 // Alberto Mena Claros
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440011',
                'event_id' => 14,
                'speaker_id' => 1 // Julio Cesar Acosta Prado
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440012',
                'event_id' => 15,
                'speaker_id' => 2 // Manuel Fernández - Villacañas Marín
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440013',
                'event_id' => 16,
                'speaker_id' => 4 // Natalia Bayona
            ],

            // Martes 21 - Talleres
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440014',
                'event_id' => 7,
                'speaker_id' => 10 // Wilfer Montoya Benjumea
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440015',
                'event_id' => 8,
                'speaker_id' => 11 // Jhon Faber Giraldo Giraldo
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440016',
                'event_id' => 9,
                'speaker_id' => 12 // Alberto Mena, Othel J. López Altamirano
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440017',
                'event_id' => 10,
                'speaker_id' => 5 // Federico De Arteaga
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440018',
                'event_id' => 11,
                'speaker_id' => 7 // María Cecilia López Barrios
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440019',
                'event_id' => 12,
                'speaker_id' => 1 // Julio Cesar Acosta Prado
            ],

            // Miércoles 22 - Conferencias
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440020',
                'event_id' => 19,
                'speaker_id' => 13 // Oriniel Josef López Altamirano
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440021',
                'event_id' => 20,
                'speaker_id' => 14 // Alejandra Izquierdo Cujar
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440022',
                'event_id' => 21,
                'speaker_id' => 8 // Juan Carlos León Peñoranda
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440023',
                'event_id' => 22,
                'speaker_id' => 10 // Wilfer Montoya Benjumea
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440024',
                'event_id' => 23,
                'speaker_id' => 15 // Gerardo Luna Gijón
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440025',
                'event_id' => 24,
                'speaker_id' => 16 // Miguelina Ruiz Díaz
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440026',
                'event_id' => 25,
                'speaker_id' => 17 // Héctor Daniel Martínez
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440027',
                'event_id' => 26,
                'speaker_id' => 7 // María Cecilia López Barrios
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440028',
                'event_id' => 32,
                'speaker_id' => 13 // Orriel Josafat López Altamirano
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440029',
                'event_id' => 33,
                'speaker_id' => 18 // Ricardo Alexis López Gallego
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440030',
                'event_id' => 34,
                'speaker_id' => 19 // Lucía Cortil, Nelly Risco Mc Gregor
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440031',
                'event_id' => 35,
                'speaker_id' => 20 // Andrea Paola Santanilla Navvaez
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440032',
                'event_id' => 36,
                'speaker_id' => 21 // Luis Anibal Mora García
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440033',
                'event_id' => 37,
                'speaker_id' => 22 // Angela Pantoja Garzón
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440034',
                'event_id' => 38,
                'speaker_id' => 23 // Franklin Eduardo López Flórez
            ],

            // Miércoles 22 - Talleres
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440035',
                'event_id' => 27,
                'speaker_id' => 8 // Juan Carlos León Peñaranda
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440036',
                'event_id' => 28,
                'speaker_id' => 17 // Héctor Daniel Martínez
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440037',
                'event_id' => 29,
                'speaker_id' => 15 // Gerardo Luna Gijón
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440038',
                'event_id' => 30,
                'speaker_id' => 18 // Ricardo Alexis López Gallego
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440039',
                'event_id' => 31,
                'speaker_id' => 13 // Orriel Josafat López Altamirano
            ],

            // Jueves 23 - Conferencias
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440040',
                'event_id' => 41,
                'speaker_id' => 19 // Lucía Corral, Nelly Risco Mc Gregory
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440041',
                'event_id' => 42,
                'speaker_id' => 24 // Karina Vélez Gómez
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440042',
                'event_id' => 43,
                'speaker_id' => 25 // Magerth Guilárez Vargas
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440043',
                'event_id' => 44,
                'speaker_id' => 26 // Asia Pellegrini, Luna T. García
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440044',
                'event_id' => 45,
                'speaker_id' => 3 // Juan Carlos Peña Castro
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440045',
                'event_id' => 46,
                'speaker_id' => 27 // Alejandro Fajardo López
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440046',
                'event_id' => 47,
                'speaker_id' => 28 // Angela María Galindo Cafón
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440047',
                'event_id' => 53,
                'speaker_id' => 29 // Carlos Enrique Fernández García
            ],

            // Jueves 23 - Talleres
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440048',
                'event_id' => 49,
                'speaker_id' => 29 // Carlos Enrique Fernández García
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440049',
                'event_id' => 50,
                'speaker_id' => 25 // Magerth Gutiérrez Vargas
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440050',
                'event_id' => 51,
                'speaker_id' => 30 // Ointel J. López A., Alberto Mena, Karina Vélez Gómez
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440051',
                'event_id' => 52,
                'speaker_id' => 27 // Alejandro Fajardo López
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440052',
                'event_id' => 54,
                'speaker_id' => 31 // Amalia Aguilar Castillo
            ],
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440053',
                'event_id' => 55,
                'speaker_id' => 32 // Diego Santos González
            ],

            // Eventos adicionales
            [
                'uuid' => '880e8400-e29b-41d4-a716-446655440054',
                'event_id' => 39, // Mesa Redonda
                'speaker_id' => 33 // Alcaldes (por definir)
            ]
        ];

         foreach ($eventSpeakers as $eventSpeaker) {
            DB::table('event_speaker')->insert($eventSpeaker);
        }

        $this->command->info('Relaciones entre eventos y ponentes creadas exitosamente!');
    }
}
