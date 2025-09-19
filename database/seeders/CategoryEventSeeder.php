<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class CategoryEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $categoryEvents = [
            // Conferencias (Categoría 1)
            [
                'uuid' => Str::uuid(),
                'category_id' => 1, // Conferencias
                'event_id' => 1,     // Panel Inaugural
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440002',
                'category_id' => 1,
                'event_id' => 2     // Preservación de la Cocina Tradicional
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440003',
                'category_id' => 1,
                'event_id' => 3     // Sesión 1. La Neo Artesanía
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440004',
                'category_id' => 1,
                'event_id' => 4     // Soluciones Digitales
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440005',
                'category_id' => 1,
                'event_id' => 5     // Marketing Promocional
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440006',
                'category_id' => 1,
                'event_id' => 6     // El Poder de WayFinding
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440007',
                'category_id' => 1,
                'event_id' => 13    // Automatización y Talento Humano
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440008',
                'category_id' => 1,
                'event_id' => 14    // Innovación como Herramienta
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440009',
                'category_id' => 1,
                'event_id' => 15    // Logística de Eventos
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440010',
                'category_id' => 1,
                'event_id' => 16    // Estrategias Comerciales
            ],

            // Workshops (Categoría 2)
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440011',
                'category_id' => 2, // Workshops
                'event_id' => 7     // IA para la Generación Gráfica
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440012',
                'category_id' => 2,
                'event_id' => 8     // Fotografía de Producto
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440013',
                'category_id' => 2,
                'event_id' => 9     // Fase 1. Validación de Soluciones
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440014',
                'category_id' => 2,
                'event_id' => 10    // Despertando la Mentalidad Innovadora
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440015',
                'category_id' => 2,
                'event_id' => 11    // Narrativas de Región
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440016',
                'category_id' => 2,
                'event_id' => 12    // Desarrollo de Capacidades
            ],

            // Paneles (Categoría 3)
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440017',
                'category_id' => 3, // Paneles
                'event_id' => 1     // Panel Inaugural
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440018',
                'category_id' => 3,
                'event_id' => 39    // Mesa Redonda "Hablando con los Alcaldes"
            ],

            // Eventos Especiales (Categoría 4)
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440019',
                'category_id' => 4, // Eventos Especiales
                'event_id' => 17    // 4º FESCtival Internacional de Cine
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440020',
                'category_id' => 4,
                'event_id' => 18    // Gala Inaugural
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440021',
                'category_id' => 4,
                'event_id' => 40    // Proyección de Cortometrajes (Miércoles)
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440022',
                'category_id' => 4,
                'event_id' => 56    // City Tour
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440023',
                'category_id' => 4,
                'event_id' => 57    // Desfile de Modas
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440024',
                'category_id' => 4,
                'event_id' => 58    // Proyección de Cortometrajes (Jueves)
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440025',
                'category_id' => 4,
                'event_id' => 59    // Rueda de Negocios
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440026',
                'category_id' => 4,
                'event_id' => 60    // Feria Cultural
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440027',
                'category_id' => 4,
                'event_id' => 61    // Fiesta de Cierre
            ],

            // Eventos que pertenecen a múltiples categorías
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440028',
                'category_id' => 1, // Conferencias
                'event_id' => 1     // Panel Inaugural (también es Panel)
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440029',
                'category_id' => 2, // Workshops
                'event_id' => 54    // Comercio Electrónico (Workshop Virtual)
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440030',
                'category_id' => 2, // Workshops
                'event_id' => 55    // Sostenibilidad (Workshop Virtual)
            ],

            // Conferencias del Miércoles 22
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440031',
                'category_id' => 1, // Conferencias
                'event_id' => 19    // Entornos Mediáticos Expandidos
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440032',
                'category_id' => 1,
                'event_id' => 20    // Modelos de Desarrollo Turístico
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440033',
                'category_id' => 1,
                'event_id' => 21    // Destino Moda
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440034',
                'category_id' => 1,
                'event_id' => 22    // Generación Gráfica con IA
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440035',
                'category_id' => 1,
                'event_id' => 23    // Integraría para Souvenirs
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440036',
                'category_id' => 1,
                'event_id' => 24    // Identificación de Productos Exportables
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440037',
                'category_id' => 1,
                'event_id' => 25    // Turismo Rural Sostenible
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440038',
                'category_id' => 1,
                'event_id' => 26    // Sesión 2. La Neo Artesanía
            ],

            // Workshops del Miércoles 22
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440039',
                'category_id' => 2, // Workshops
                'event_id' => 27    // Ficha Técnica Fashion Pro
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440040',
                'category_id' => 2,
                'event_id' => 28    // Taller de Diseño de Experiencias Turísticas
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440041',
                'category_id' => 2,
                'event_id' => 29    // Herramientas Tecnológicas
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440042',
                'category_id' => 2,
                'event_id' => 30    // Componentes Financieros
            ],
            [
                'uuid' => 'ee0e8400-e29b-41d4-a716-446655440043',
                'category_id' => 2,
                'event_id' => 31    // Fase 2. Priorización y Validación
            ]
        ];

        foreach ($categoryEvents as $categoryEvent) {
            DB::table('category_event')->insert($categoryEvent);
        }

        $this->command->info('Relaciones Categoría-Evento creadas exitosamente!');
    }
}
