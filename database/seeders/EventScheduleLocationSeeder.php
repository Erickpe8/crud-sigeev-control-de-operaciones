<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class EventScheduleLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventScheduleLocations = [
            // Lunes 20 - Panel Inaugural
            [
                'uuid' => Str::uuid(),
                'event_id' => 1,
                'schedule_id' => 1,
                'location_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

          // Panel Inaugural - 20 de octubre
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440001',
                'event_id' => 1,
                'schedule_id' => 1, // 20 Oct, 18:00-20:00
                'location_id' => 1  // Teatro Zulima
            ],

            // Martes 21 - Mañana (8:00-9:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440002',
                'event_id' => 2,
                'schedule_id' => 2, // 21 Oct, 8:00-9:30
                'location_id' => 2  // Salón Terracota, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440003',
                'event_id' => 3,
                'schedule_id' => 2,
                'location_id' => 3  // Salón Clan, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440004',
                'event_id' => 4,
                'schedule_id' => 2,
                'location_id' => 4  // Salón Rubí, Hotel Casablanca
            ],

            // Martes 21 - Mañana (10:00-11:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440005',
                'event_id' => 5,
                'schedule_id' => 3, // 21 Oct, 10:00-11:30
                'location_id' => 3  // Salón Clan, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440006',
                'event_id' => 6,
                'schedule_id' => 3,
                'location_id' => 4  // Salón Rubí, Hotel Casablanca
            ],

            // Martes 21 - Tarde Workshops (14:00-17:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440007',
                'event_id' => 7,
                'schedule_id' => 4, // 21 Oct, 14:00-17:00
                'location_id' => 5  // Aula A104, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440008',
                'event_id' => 8,
                'schedule_id' => 4,
                'location_id' => 5  // Aula A104, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440009',
                'event_id' => 9,
                'schedule_id' => 4,
                'location_id' => 5  // Aula A104, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440010',
                'event_id' => 10,
                'schedule_id' => 4,
                'location_id' => 5  // Aula A104, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440011',
                'event_id' => 11,
                'schedule_id' => 4,
                'location_id' => 6  // Aula C401, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440012',
                'event_id' => 12,
                'schedule_id' => 4,
                'location_id' => 7  // Aula A302, FESC
            ],

            // Martes 21 - Tarde Conferencias (17:00-18:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440013',
                'event_id' => 13,
                'schedule_id' => 5, // 21 Oct, 17:00-18:30
                'location_id' => 4  // Salón Rubí, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440014',
                'event_id' => 14,
                'schedule_id' => 5,
                'location_id' => 2  // Salón Terracota, Hotel Casablanca
            ],

            // Martes 21 - Tarde Conferencias Virtuales (18:30-20:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440015',
                'event_id' => 15,
                'schedule_id' => 6, // 21 Oct, 18:30-20:00
                'location_id' => 8  // Virtual
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440016',
                'event_id' => 16,
                'schedule_id' => 6,
                'location_id' => 8  // Virtual
            ],

            // Martes 21 - Eventos Culturales
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440017',
                'event_id' => 17,
                'schedule_id' => 4, // 21 Oct, 14:00-18:00
                'location_id' => 9  // Centro Cultural Quinta Teresa
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440018',
                'event_id' => 18,
                'schedule_id' => 7, // 21 Oct, 19:00-21:00
                'location_id' => 9  // Centro Cultural Quinta Teresa
            ],

            // Miércoles 22 - Mañana (8:00-9:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440019',
                'event_id' => 19,
                'schedule_id' => 8, // 22 Oct, 8:00-9:30
                'location_id' => 3  // Salón Clan, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440020',
                'event_id' => 20,
                'schedule_id' => 8,
                'location_id' => 4  // Salón Rubí, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440021',
                'event_id' => 21,
                'schedule_id' => 8,
                'location_id' => 10 // Auditorio Sta Avenida, FESC
            ],

            // Miércoles 22 - Mañana (10:00-11:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440022',
                'event_id' => 22,
                'schedule_id' => 9, // 22 Oct, 10:00-11:30
                'location_id' => 3  // Salón Clan, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440023',
                'event_id' => 23,
                'schedule_id' => 9,
                'location_id' => 3  // Salón Clan, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440024',
                'event_id' => 24,
                'schedule_id' => 9,
                'location_id' => 2  // Salón Terracota, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440025',
                'event_id' => 25,
                'schedule_id' => 9,
                'location_id' => 4  // Salón Rubí, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440026',
                'event_id' => 26,
                'schedule_id' => 9,
                'location_id' => 10 // Auditorio Sta Avenida, FESC
            ],

            // Miércoles 22 - Tarde Workshops (14:00-17:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440027',
                'event_id' => 27,
                'schedule_id' => 10, // 22 Oct, 14:00-17:00
                'location_id' => 7   // Aula A302, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440028',
                'event_id' => 28,
                'schedule_id' => 10,
                'location_id' => 6   // Aula C401, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440029',
                'event_id' => 29,
                'schedule_id' => 10,
                'location_id' => 11  // Aula C301, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440030',
                'event_id' => 30,
                'schedule_id' => 10,
                'location_id' => 12  // Aula FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440031',
                'event_id' => 31,
                'schedule_id' => 10,
                'location_id' => 12  // Aula FESC
            ],

            // Miércoles 22 - Mesa Redonda (16:00-17:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440032',
                'event_id' => 39,
                'schedule_id' => 11, // 22 Oct, 16:00-17:00
                'location_id' => 13  // Salón Coral, Hotel Casablanca
            ],

            // Miércoles 22 - Tarde Conferencias (17:00-18:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440033',
                'event_id' => 32,
                'schedule_id' => 12, // 22 Oct, 17:00-18:30
                'location_id' => 4   // Salón Rubí, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440034',
                'event_id' => 33,
                'schedule_id' => 12,
                'location_id' => 2   // Salón Terracota, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440035',
                'event_id' => 34,
                'schedule_id' => 12,
                'location_id' => 10  // Auditorio Sta Avenida, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440036',
                'event_id' => 35,
                'schedule_id' => 12,
                'location_id' => 10  // Auditorio Sta Avenida, FESC
            ],

            // Miércoles 22 - Tarde Conferencias Virtuales (18:30-20:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440037',
                'event_id' => 36,
                'schedule_id' => 13, // 22 Oct, 18:30-20:00
                'location_id' => 8   // Virtual
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440038',
                'event_id' => 37,
                'schedule_id' => 13,
                'location_id' => 8   // Virtual
            ],

            // Miércoles 22 - Conferencia Final (20:00-21:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440039',
                'event_id' => 38,
                'schedule_id' => 14, // 22 Oct, 20:00-21:30
                'location_id' => 10  // Auditorio Sta Avenida, FESC
            ],

            // Miércoles 22 - Evento Cultural
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440040',
                'event_id' => 40,
                'schedule_id' => 10, // 22 Oct, 14:00-18:00
                'location_id' => 9   // Centro Cultural Quinta Teresa
            ],

            // Jueves 23 - Mañana (8:00-9:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440041',
                'event_id' => 41,
                'schedule_id' => 15, // 23 Oct, 8:00-9:30
                'location_id' => 3   // Salón Clan, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440042',
                'event_id' => 42,
                'schedule_id' => 15,
                'location_id' => 2   // Salón Terracota, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440043',
                'event_id' => 43,
                'schedule_id' => 15,
                'location_id' => 4   // Salón Rubí, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440044',
                'event_id' => 44,
                'schedule_id' => 15,
                'location_id' => 10  // Auditorio Sta Avenida, FESC
            ],

            // Jueves 23 - Mañana (10:00-11:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440045',
                'event_id' => 45,
                'schedule_id' => 16, // 23 Oct, 10:00-11:30
                'location_id' => 3   // Salón Clan, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440046',
                'event_id' => 46,
                'schedule_id' => 16,
                'location_id' => 2   // Salón Terracota, Hotel Casablanca
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440047',
                'event_id' => 47,
                'schedule_id' => 16,
                'location_id' => 4   // Salón Rubí, Hotel Casablanca
            ],

            // Jueves 23 - Tarde Workshops (14:00-17:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440048',
                'event_id' => 48,
                'schedule_id' => 17, // 23 Oct, 14:00-17:00
                'location_id' => 5   // Aula A104, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440049',
                'event_id' => 49,
                'schedule_id' => 17,
                'location_id' => 11  // Aula C301, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440050',
                'event_id' => 50,
                'schedule_id' => 17,
                'location_id' => 14  // Aula C302 a C306, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440051',
                'event_id' => 51,
                'schedule_id' => 17,
                'location_id' => 15  // Aula A103, FESC
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440052',
                'event_id' => 52,
                'schedule_id' => 17,
                'location_id' => 6   // Aula C401, FESC
            ],

            // Jueves 23 - Tarde Conferencia (17:00-18:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440053',
                'event_id' => 53,
                'schedule_id' => 18, // 23 Oct, 17:00-18:30
                'location_id' => 10  // Auditorio Sta Avenida, FESC
            ],

            // Jueves 23 - Tarde Virtual (17:00-18:30)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440054',
                'event_id' => 54,
                'schedule_id' => 18,
                'location_id' => 8   // Virtual
            ],
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440055',
                'event_id' => 55,
                'schedule_id' => 18,
                'location_id' => 8   // Virtual
            ],

            // Jueves 23 - City Tour (17:00-19:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440056',
                'event_id' => 56,
                'schedule_id' => 19, // 23 Oct, 17:00-19:00
                'location_id' => 16  // Varios lugares de Cúcuta
            ],

            // Jueves 23 - Desfile de Modas (20:00-23:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440057',
                'event_id' => 57,
                'schedule_id' => 20, // 23 Oct, 20:00-23:00
                'location_id' => 17  // C.C. Jardín Plaza
            ],

            // Jueves 23 - Evento Cultural
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440058',
                'event_id' => 58,
                'schedule_id' => 17, // 23 Oct, 14:00-18:00
                'location_id' => 9   // Centro Cultural Quinta Teresa
            ],

            // Viernes 24 - Rueda de Negocios (8:00-12:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440059',
                'event_id' => 59,
                'schedule_id' => 21, // 24 Oct, 8:00-12:00
                'location_id' => 9   // Centro Cultural Quinta Teresa
            ],

            // Viernes 24 - Feria Cultural (8:00-18:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440060',
                'event_id' => 60,
                'schedule_id' => 22, // 24 Oct, 8:00-18:00
                'location_id' => 9   // Centro Cultural Quinta Teresa
            ],

            // Viernes 24 - Fiesta de Cierre (19:00-22:00)
            [
                'uuid' => '770e8400-e29b-41d4-a716-446655440061',
                'event_id' => 61,
                'schedule_id' => 23, // 24 Oct, 19:00-22:00
                'location_id' => 18  // Escoparque Comfanorte
            ]
        ];

        foreach ($eventScheduleLocations as $eventScheduleLocation) {
             DB::table('event_schedule_location')->insert($eventScheduleLocation);
        }

        $this->command->info('Relaciones evento-horario-ubicación creadas exitosamente!');
    }
}
