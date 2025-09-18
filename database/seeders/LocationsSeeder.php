<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Location;
use Carbon\Carbon; 

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            // Teatro Zulima
            [
                'uuid' => Str::uuid(),
                'name' => 'Teatro Zulima',
                'room' => 'Auditorio Principal',
                'address' => 'Calle 10 #0-45, Cúcuta, Norte de Santander',
                'image' => 'teatro-zulima.jpg',
                'reference_point' => 'Teatro principal de Cúcuta, ubicado en el centro de la ciudad',
                'latitude' => '7.8939',
                'longitude' => '-72.5078',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // FESC - Institución principal
            [
                'uuid' => Str::uuid(),
                'name' => 'FESC - Fundación de Educación Superior Comfanorte',
                'address' => 'Avenida 3 #14-34, Cúcuta, Norte de Santander',
                'image' => 'fesc-main.jpg',
                'reference_point' => 'Institución de educación superior, sede principal',
                'latitude' => '7.8940',
                'longitude' => '-72.5080',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            // Hotel Casablanca - Salones
            [
                'uuid' => Str::uuid(),
                'name' => 'Hotel Casablanca',
                'address' => 'Avenida Libertadores #15-23, Cúcuta, Norte de Santander',
                'image' => 'hotel-casablanca.jpg',
                'reference_point' => 'Hotel sede de conferencias y eventos',
                'latitude' => '7.8950',
                'longitude' => '-72.5090',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            // Centro Cultural Quinta Teresa
            [
                'uuid' => Str::uuid(),
                'name' => 'Centro Cultural Quinta Teresa',
                'address' => 'Calle 14 #2-45, Cúcuta, Norte de Santander',
                'image' => 'quinta-teresa.jpg',
                'reference_point' => 'Centro cultural para eventos artísticos y proyecciones',
                'latitude' => '7.8960',
                'longitude' => '-72.5100',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            // CC Jardín Plaza
            [
                'uuid' => Str::uuid(),
                'name' => 'Centro Comercial Jardín Plaza',
                'address' => 'Avenida Camilo Daza #22-67, Cúcuta, Norte de Santander',
                'image' => 'jardin-plaza.jpg',
                'reference_point' => 'Centro comercial a cielo abierto, sede del desfile de modas',
                'latitude' => '7.8970',
                'longitude' => '-72.5110',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            // Escoparque Comfanorte
            [
                'uuid' => Str::uuid(),
                'name' => 'Escoparque Comfanorte',
                'address' => 'Kilómetro 2 vía a San Cayetano, Cúcuta, Norte de Santander',
                'image' => 'escoparque.jpg',
                'reference_point' => 'Parque recreacional, sede de la fiesta de cierre',
                'latitude' => '7.8980',
                'longitude' => '-72.5120',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            // Lugares del City Tour
            [
                'uuid' => Str::uuid(),
                'name' => 'Cristo Rey',
                'address' => 'Cerro del Cristo Rey, Cúcuta, Norte de Santander',
                'image' => 'cristo-rey.jpg',
                'reference_point' => 'Monumento religioso con vista panorámica de la ciudad',
                'latitude' => '7.8990',
                'longitude' => '-72.5130',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Biblioteca Pública Julio Pérez Ferrero',
                'address' => 'Calle 14 #3-45, Cúcuta, Norte de Santander',
                'image' => 'biblioteca.jpg',
                'reference_point' => 'Biblioteca pública principal de la ciudad',
                'latitude' => '7.9000',
                'longitude' => '-72.5140',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Parque La Victoria',
                'address' => 'Calle 10 #5-67, Cúcuta, Norte de Santander',
                'image' => 'parque-victoria.jpg',
                'reference_point' => 'Parque histórico del centro de Cúcuta',
                'latitude' => '7.9010',
                'longitude' => '-72.5150',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Cúpula Chata - Gobernación de Norte de Santander',
                'address' => 'Avenida 5 #8-90, Cúcuta, Norte de Santander',
                'image' => 'cupula-chata.jpg',
                'reference_point' => 'Sede de la gobernación, edificio histórico',
                'latitude' => '7.9020',
                'longitude' => '-72.5160',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Catedral de San José',
                'address' => 'Calle 11 #6-78, Cúcuta, Norte de Santander',
                'image' => 'catedral.jpg',
                'reference_point' => 'Catedral principal de la ciudad',
                'latitude' => '7.9030',
                'longitude' => '-72.5170',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Torre del Reloj',
                'address' => 'Parque Santander, Cúcuta, Norte de Santander',
                'image' => 'torre-reloj.jpg',
                'reference_point' => 'Monumento histórico en el parque central',
                'latitude' => '7.9040',
                'longitude' => '-72.5180',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Complejo Histórico Villa del Rosario',
                'address' => 'Villa del Rosario, Norte de Santander',
                'image' => 'villa-rosario.jpg',
                'reference_point' => 'Complejo histórico donde se firmó la Constitución de 1821',
                'latitude' => '7.8339',
                'longitude' => '-72.4742',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Villa del Rosario',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Puente Internacional Simón Bolívar',
                'address' => 'Frontera Colombia-Venezuela, Norte de Santander',
                'image' => 'puente-bolivar.jpg',
                'reference_point' => 'Principal puente fronterizo con Venezuela',
                'latitude' => '7.9050',
                'longitude' => '-72.5190',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Puente Internacional Tienditas',
                'address' => 'Frontera Colombia-Venezuela, Norte de Santander',
                'image' => 'puente-tienditas.jpg',
                'reference_point' => 'Nuevo puente fronterizo con Venezuela',
                'latitude' => '7.9060',
                'longitude' => '-72.5200',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            // Aulas FESC (se agregaron como locaciones separadas)
            [
                'uuid' => Str::uuid(),
                'name' => 'FESC - Aula A104',
                'address' => 'Avenida 3 #14-34, Cúcuta, Norte de Santander',
                'image' => 'aula-fesc.jpg',
                'reference_point' => 'Aula de talleres y conferencias - Edificio A',
                'latitude' => '7.8941',
                'longitude' => '-72.5081',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'FESC - Aula A302',
                'address' => 'Avenida 3 #14-34, Cúcuta, Norte de Santander',
                'image' => 'aula-fesc.jpg',
                'reference_point' => 'Aula de talleres y conferencias - Edificio A',
                'latitude' => '7.8942',
                'longitude' => '-72.5082',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'FESC - Aula C301',
                'address' => 'Avenida 3 #14-34, Cúcuta, Norte de Santander',
                'image' => 'aula-fesc.jpg',
                'reference_point' => 'Aula de talleres y conferencias - Edificio C',
                'latitude' => '7.8943',
                'longitude' => '-72.5083',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'FESC - Aula C401',
                'address' => 'Avenida 3 #14-34, Cúcuta, Norte de Santander',
                'image' => 'aula-fesc.jpg',
                'reference_point' => 'Aula de talleres y conferencias - Edificio C',
                'latitude' => '7.8944',
                'longitude' => '-72.5084',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'FESC - Auditorio Sta Avenida',
                'address' => 'Avenida 3 #14-34, Cúcuta, Norte de Santander',
                'image' => 'auditorio-fesc.jpg',
                'reference_point' => 'Auditorio principal para conferencias',
                'latitude' => '7.8945',
                'longitude' => '-72.5085',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            // Salones Hotel Casablanca
            [
                'uuid' => Str::uuid(),
                'name' => 'Hotel Casablanca - Salón Terracota',
                'address' => 'Avenida Libertadores #15-23, Cúcuta, Norte de Santander',
                'image' => 'salon-casablanca.jpg',
                'reference_point' => 'Salón de conferencias - Hotel Casablanca',
                'latitude' => '7.8951',
                'longitude' => '-72.5091',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Hotel Casablanca - Salón Clan',
                'address' => 'Avenida Libertadores #15-23, Cúcuta, Norte de Santander',
                'image' => 'salon-casablanca.jpg',
                'reference_point' => 'Salón de conferencias - Hotel Casablanca',
                'latitude' => '7.8952',
                'longitude' => '-72.5092',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Hotel Casablanca - Salón Rubí',
                'address' => 'Avenida Libertadores #15-23, Cúcuta, Norte de Santander',
                'image' => 'salon-casablanca.jpg',
                'reference_point' => 'Salón de conferencias - Hotel Casablanca',
                'latitude' => '7.8953',
                'longitude' => '-72.5093',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            [
                'uuid' => Str::uuid(),
                'name' => 'Hotel Casablanca - Salón Coral',
                'address' => 'Avenida Libertadores #15-23, Cúcuta, Norte de Santander',
                'image' => 'salon-casablanca.jpg',
                'reference_point' => 'Salón para mesas redondas - Hotel Casablanca',
                'latitude' => '7.8954',
                'longitude' => '-72.5094',
                'google_maps_link' => 'https://goo.gl/maps/example',
                'country' => 'Colombia',
                'city' => 'Cúcuta',
                'is_active' => true
            ],
            
            // Virtual
            [
                'uuid' => Str::uuid(),
                'name' => 'Virtual - Plataforma Online',
                'address' => 'Acceso remoto por internet',
                'image' => 'virtual.jpg',
                'reference_point' => 'Eventos transmitidos por plataforma virtual',
                'latitude' => null,
                'longitude' => null,
                'google_maps_link' => null,
                'country' => null,
                'city' => null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
        
        $this->command->info('Ubicaciones creadas exitosamente!');
    }
}
