<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tag;
use Carbon\Carbon;  

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'uuid' => Str::uuid(),
                'name' => 'Turismo', 
                'color' => '#10B981',
                'description' => 'Eventos relacionados con desarrollo turístico',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Innovación',
                'color' => '#8B5CF6', // buscar los colores segun el tipo de nombre
                'description' => 'Eventos de emprendimiento e innovación',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Programación',
                'color' => '#3B82F6', 
                'description' => 'Eventos relacionados con desarrollo de software',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Inteligencia Artificial',
                'color' => '#F472B6',
                'description' => 'Machine Learning, Deep Learning y aplicaciones de IA',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Diseño UX/UI',
                'color' => '#F472B6',
                'description' => 'Experiencia de usuario e interfaces digitales',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Marketing Digital',
                'color' => '#F472B6',
                'description' => 'Estrategias digitales y growth hacking',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Emprendimiento',
                'color' => '#F472B6',
                'description' => 'Startups y modelos de negocio innovadores',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Cultura',
                'color' => '#F59E0B',
                'description' => 'Eventos culturales y artísticos',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Negocios',
                'color' => '#6366F1',
                'description' => 'Eventos de networking y oportunidades de negocio',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Gastronomía',
                'color' => '#EF4444',
                'description' => 'Eventos relacionados con cocina y alimentación',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Moda',
                'color' => '#EC4899',
                'description' => 'Eventos de diseño de moda y tendencias',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Sostenibilidad',
                'color' => '#22C55E',
                'description' => 'Eventos sobre desarrollo sostenible',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Economía Circular',
                'color' => '#06B6D4',
                'description' => 'Eventos sobre sostenibilidad y economía circular',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Ciberseguridad',
                'color' => '#F472B6',
                'description' => 'Seguridad informática y protección de datos',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Blockchain',
                'color' => '#F472B6',
                'description' => 'Tecnología de cadenas de bloques y criptomonedas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Cloud Computing',
                'color' => '#F472B6',
                'description' => 'Servicios en la nube y arquitecturas escalables',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'DevOps',
                'color' => '#F472B6',
                'description' => 'Integración continua y despliegues automatizados',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Data Science',
                'color' => '#F472B6',
                'description' => 'Análisis de datos y business intelligence',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        $this->command->info('Etiquetas creadas exitosamente!');
    }
}
