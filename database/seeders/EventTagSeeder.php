<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class EventTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTags = [
            // ==================== TAGS DE TEMA ====================
            [
                'uuid' => Str::uuid(),
                'tag_id' => 1, // Turismo
                'event_id' => 2,  // Preservación de la Cocina Tradicional
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440002',
                'tag_id' => 1,
                'event_id' => 5  // Marketing Promocional de Destinos Turísticos
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440003',
                'tag_id' => 1,
                'event_id' => 6  // El Poder de WayFinding
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440004',
                'tag_id' => 1,
                'event_id' => 13 // Automatización y Talento Humano
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440005',
                'tag_id' => 1,
                'event_id' => 14 // Innovación como Herramienta
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440006',
                'tag_id' => 1,
                'event_id' => 16 // Estrategias Comerciales
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440007',
                'tag_id' => 1,
                'event_id' => 20 // Modelos de Desarrollo Turístico
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440008',
                'tag_id' => 1,
                'event_id' => 25 // Turismo Rural Sostenible
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440009',
                'tag_id' => 1,
                'event_id' => 32 // Estrategias Trasmedía
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440010',
                'tag_id' => 1,
                'event_id' => 35 // Inversión Extranjera y Turismo
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440011',
                'tag_id' => 1,
                'event_id' => 37 // Conecta para Crecer
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440012',
                'tag_id' => 1,
                'event_id' => 38 // Branding Experiencia
            ],

            // ==================== TAGS DE TECNOLOGÍA ====================
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440013',
                'tag_id' => 2, // Tecnología
                'event_id' => 4  // Soluciones Digitales
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440014',
                'tag_id' => 2,
                'event_id' => 7  // IA para la Generación Gráfica
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440015',
                'tag_id' => 2,
                'event_id' => 13 // Automatización y Talento Humano
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440016',
                'tag_id' => 2,
                'event_id' => 22 // Generación Gráfica con IA
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440017',
                'tag_id' => 2,
                'event_id' => 32 // Estrategias Trasmedía
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440018',
                'tag_id' => 2,
                'event_id' => 42 // Cerrando Brechas Digitales
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440019',
                'tag_id' => 2,
                'event_id' => 43 // Soluciones Fintech
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440020',
                'tag_id' => 2,
                'event_id' => 44 // Innovación en la Industria Calzado
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440021',
                'tag_id' => 2,
                'event_id' => 45 // E-Commerce
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440022',
                'tag_id' => 2,
                'event_id' => 46 // E-Commerce
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440023',
                'tag_id' => 2,
                'event_id' => 47 // E-Commerce
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440024',
                'tag_id' => 2,
                'event_id' => 48 // Realidad Aumentada
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440025',
                'tag_id' => 2,
                'event_id' => 49 // Tecnologías Financieras
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440026',
                'tag_id' => 2,
                'event_id' => 53 // Proyectos con Inteligencia Artificial
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440027',
                'tag_id' => 2,
                'event_id' => 54 // Comercio Electrónico
            ],

            // ==================== TAGS DE INNOVACIÓN ====================
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440028',
                'tag_id' => 3, // Innovación
                'event_id' => 3  // La Neo Artesanía
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440029',
                'tag_id' => 3,
                'event_id' => 4  // Soluciones Digitales
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440030',
                'tag_id' => 3,
                'event_id' => 10 // Despertando la Mentalidad Innovadora
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440031',
                'tag_id' => 3,
                'event_id' => 12 // Desarrollo de Capacidades de Innovación
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440032',
                'tag_id' => 3,
                'event_id' => 14 // Innovación como Herramienta
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440033',
                'tag_id' => 3,
                'event_id' => 26 // Sesión 2. La Neo Artesanía
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440034',
                'tag_id' => 3,
                'event_id' => 44 // Innovación en la Industria Calzado
            ],

            // ==================== TAGS DE ECONOMÍA CIRCULAR ====================
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440035',
                'tag_id' => 4, // Economía Circular
                'event_id' => 3  // La Neo Artesanía
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440036',
                'tag_id' => 4,
                'event_id' => 26 // Sesión 2. La Neo Artesanía
            ],

            // ==================== TAGS DE GASTRONOMÍA ====================
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440037',
                'tag_id' => 5, // Gastronomía
                'event_id' => 2  // Preservación de la Cocina Tradicional
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440038',
                'tag_id' => 5,
                'event_id' => 34 // Retail Design para UX Gastronómico
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440039',
                'tag_id' => 5,
                'event_id' => 41 // Retail Design para UX Gastronómico
            ],

            // ==================== TAGS DE MODA ====================
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440040',
                'tag_id' => 6, // Moda
                'event_id' => 21 // Destino Moda
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440041',
                'tag_id' => 6,
                'event_id' => 27 // Ficha Técnica Fashion Pro
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440042',
                'tag_id' => 6,
                'event_id' => 57 // Desfile de Modas
            ],

            // ==================== TAGS DE SOSTENIBILIDAD ====================
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440043',
                'tag_id' => 7, // Sostenibilidad
                'event_id' => 20 // Modelos de Desarrollo Turístico Sostenibles
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440044',
                'tag_id' => 7,
                'event_id' => 25 // Turismo Rural Sostenible
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440045',
                'tag_id' => 7,
                'event_id' => 45 // E-Commerce + Sostenibilidad
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440046',
                'tag_id' => 7,
                'event_id' => 46 // E-Commerce + Sostenibilidad
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440047',
                'tag_id' => 7,
                'event_id' => 47 // E-Commerce + Sostenibilidad
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440048',
                'tag_id' => 7,
                'event_id' => 52 // De la Idea al Impacto
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440049',
                'tag_id' => 7,
                'event_id' => 55 // Sostenibilidad y Reducción de Impactos
            ],

            // ==================== TAGS DE CULTURA ====================
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440050',
                'tag_id' => 8, // Cultura
                'event_id' => 2  // Preservación de la Cocina Tradicional
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440051',
                'tag_id' => 8,
                'event_id' => 11 // Narrativas de Región
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440052',
                'tag_id' => 8,
                'event_id' => 17 // FESCtival de Cine
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440053',
                'tag_id' => 8,
                'event_id' => 18 // Gala Inaugural
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440054',
                'tag_id' => 8,
                'event_id' => 40 // Proyección de Cortometrajes
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440055',
                'tag_id' => 8,
                'event_id' => 56 // City Tour
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440056',
                'tag_id' => 8,
                'event_id' => 57 // Desfile de Modas
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440057',
                'tag_id' => 8,
                'event_id' => 58 // Proyección de Cortometrajes
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440058',
                'tag_id' => 8,
                'event_id' => 60 // Feria Cultural
            ],

            // ==================== TAGS DE NEGOCIOS ====================
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440059',
                'tag_id' => 9, // Negocios
                'event_id' => 5  // Marketing Promocional como Idea de Negocio
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440060',
                'tag_id' => 9,
                'event_id' => 16 // Estrategias Comerciales
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440061',
                'tag_id' => 9,
                'event_id' => 24 // Identificación de Productos Exportables
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440062',
                'tag_id' => 9,
                'event_id' => 33 // Organización de financiación
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440063',
                'tag_id' => 9,
                'event_id' => 35 // Inversión Extranjera
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440064',
                'tag_id' => 9,
                'event_id' => 36 // Impulso a la Competitividad
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440065',
                'tag_id' => 9,
                'event_id' => 37 // Asociatividad en el Turismo
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440066',
                'tag_id' => 9,
                'event_id' => 38 // Branding Experiencia
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440067',
                'tag_id' => 9,
                'event_id' => 43 // Soluciones Fintech
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440068',
                'tag_id' => 9,
                'event_id' => 45 // E-Commerce como Apuesta de Negocio
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440069',
                'tag_id' => 9,
                'event_id' => 46 // E-Commerce como Apuesta de Negocio
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440070',
                'tag_id' => 9,
                'event_id' => 47 // E-Commerce como Apuesta de Negocio
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440071',
                'tag_id' => 9,
                'event_id' => 49 // Tecnologías Financieras para Negocios
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440072',
                'tag_id' => 9,
                'event_id' => 54 // Comercio Electrónico
            ],
            [
                'uuid' => 'gg0e8400-e29b-41d4-a716-446655440073',
                'tag_id' => 9,
                'event_id' => 59 // Rueda de Negocios
            ]
        ];

        foreach ($eventTags as $eventTag) {
            DB::table('event_tag')->insert($eventTag);
        }

        $this->command->info('Relaciones Evento-Tag creadas exitosamente!');
    }
}
