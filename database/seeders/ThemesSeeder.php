<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Theme;
use Carbon\Carbon;  

class ThemesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            [
                'uuid' => Str::uuid(),
                'name' => 'Dinámicas Mundiales que Transforman Nuestra Industria Turística',
                'description' => 'Aportes para Impulsar las riquezas turísticas de Norte de Santander. Análisis de tendencias globales, estrategias de marketing turístico, preservación de patrimonio cultural y gastronómico, y soluciones digitales para la gestión del sector turístico.',
                'agenda_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Modelos Globales que Potencializan el Desarrollo Económico de la Región',
                'description' => 'Análisis de las apuestas productivas que fortalecen el sector empresarial. Estrategias de financiación, modelos de negocio sostenibles, comercio internacional, turismo rural, y fortalecimiento de cadenas productivas locales.',
                'agenda_id' => 1
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Impacto de la Investigación y la Tecnología en el Desarrollo Turístico y Productivo de la Región',
                'description' => 'Implementación de tecnologías emergentes y trabajos investigativos como herramientas fundamentales para impulsar la innovación y el desarrollo. Incluye inteligencia artificial, fintech, e-commerce, realidad aumentada, y soluciones tecnológicas para empresas rurales.',
                'agenda_id' => 1
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Cultural y Artístico',
                'description' => 'Eventos culturales, artísticos y de entretenimiento que promueven la identidad regional. Incluye festival de cine, desfiles de moda, ferias culturales, y muestras del patrimonio norte santandereano.',
                'agenda_id' => 1
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Networking y Negocios',
                'description' => 'Espacios de conexión empresarial, ruedas de negocio, mesas redondas y actividades de networking para fortalecer el ecosistema productivo de la región.',
                'agenda_id' => 1
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Educación y Formación',
                'description' => 'Talleres, workshops y actividades formativas para el desarrollo de capacidades en innovación, tecnología, gestión empresarial y competencias profesionales.',
                'agenda_id' => 1
            ]
        ];

        foreach ($themes as $theme) {
            Theme::create($theme);
        }

        $this->command->info('Ejes temáticos creados exitosamente!');
    }
}
