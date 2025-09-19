<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // full_name, company, role, bio (derivado de tu info original)
        $base = [
            ['Federico De Arteaga Vidiella','Red de Destinos Turísticos Inteligentes','Ph.D. en Innovación y Responsabilidad Social','Experto con Doctorado (Ph.D.) en Innovación y Responsabilidad Social, MBA en Negocios Internacionales e Ingeniería Agrónoma. Presidente de la Red de Destinos Turísticos Inteligentes de Iberoamérica y consultor para el BID.'],
            ['Javier Suescún','Universidad de Pamplona','Magíster en Educación','Comunicador social, candidato a Magíster en Educación y docente en fotografía, TV y medios audiovisuales.'],
            ['María Cecilia López','Independiente','Magíster en Mercadeo y Diseñadora de Modas','Más de 27 años de experiencia en moda y textiles. Conferencista nacional e internacional.'],
            ['Andrés Díaz Molina','MinTIC / ICBF','Especialista en Seguridad de la Información','Ingeniero de Sistemas. Estrategias de ciberseguridad en entidades públicas (16+ años).'],
            ['Jhon Faber Giraldo','Parque Nacional del Café','Comunicador Social / Estratega de Contenido','Fotógrafo y creador audiovisual; marketing, turismo y cultura (26 años).'],
            ['Lucas López','Universidad Javeriana','Magíster en Diseño y Creación Interactiva','Diseñador gráfico, docente y autor de “Ciudades legibles”.'],
            ['Alberto Mena','X-TRATEGIC','CEO & Consultor Estratégico','Fundador de X-TRATEGIC (El Salvador). 12+ años de experiencia en turismo.'],
            ['Juan Carlos León','Independiente','Maestrante en Gestión de Organizaciones','Diseñador de modas y alta costura; producción textil e industrial.'],
            ['Natalia Bayona','ProColombia','Gestora en Promoción Turística','Pionera en promoción turística; gestora más joven de Colombia en 2013.'],
            ['Wilfer Montoya Benjumea','Cine & TV','Diseñador Visual y Compositor VFX','11+ años en cine/TV. Explora IA generativa para producción audiovisual.'],
            ['Otniel Josafat López Altamirano','UABJO','Doctor en Diseño de Producto','Profesor titular; investigador SNI (México); doctor por UNESP (Brasil).'],
            ['Ricardo Alexis López Gallego','Consultoría','Consultor en Finanzas para la Conservación','12+ años en financiamiento de proyectos ambientales y cambio climático.'],
            ['Gerardo Luna Gijón','BUAP','Especialista en Diseño de Información','Profesor; diseño de información, editorial y UX.'],
            ['Miguelina Ruiz Díaz','OPT Colombia','Especialista en Marketing Turístico','Experiencia en promoción turística en Venezuela y Colombia.'],
            ['Héctor Daniel Martínez','Consultor Internacional','Experto en Turismo Rural','Licenciado en Turismo; planificación y desarrollo sustentable.'],
            ['Alejandra Izquierdo Cujar','Cámara de Representantes','Asesora en Asuntos Legislativos','Líder étnica IKU; Ing. Industrial; Project Management y Gestión Pública.'],
            ['Andrea Paola Santanilla Narvaez','MinComercio','Economista','Maestrías en economía y emprendimiento social; dirige Inversión Extranjera y Servicios.'],
            ['Luis Aníbal Mora García','Universidad Nacional','Ingeniero Industrial','Esp. en Mercadeo Internacional y Máster en Dirección Logística; docente catedrático.'],
            ['Angela Pantoja','Turismo Comunitario Bogotá','Especialista en Turismo Comunitario','11+ años en estrategias turísticas innovadoras y sostenibles.'],
            ['Franklin Eduardo López','Universidad UDI','Magíster en Marketing Estratégico','Publicista y docente investigador en marketing digital.'],
            ['Julio César Acosta Prado','Consultor Internacional','Doctor en Dirección y Organización de Empresas','Post-Doctor en Administración; gestión del conocimiento e innovación.'],
            ['Manuel Fernández-Villacañas Marín','Independiente','Docente e Investigador','Información no disponible actualmente.'],
            ['Lucía Corali Nelly Risco Mc Gregor','UPC (Perú)','Magíster en Administración y Negocios Internacionales','Diseñadora de interiores y docente universitaria.'],
            ['Karina Vélez Gómez','Telefónica Hispanoamérica','Especialista en Comunicaciones y Medios','15+ años liderando estrategias de posicionamiento.'],
            ['Magreth Gutiérrez Vargas','Aavance Solutions Fintech','Ingeniera Financiera y CEO','Fundadora; reconocida por innovación financiera.'],
            ['Asia Pellegrini','Nothink Shoes','Co-fundadora','Licenciada en Business Management; tacones intercambiables.'],
            ['Luna T. García','Nothink Shoes','Co-fundadora','Especialista en expansión de marcas hispanohablantes.'],
            ['Juan Carlos Peña Castro','Consultoría Estratégica','MBA en Business & Marketing','Finanzas y Relaciones Internacionales; transformación digital.'],
            ['Alejandro Fajardo','Independiente','Especialista en Proyectos Turísticos','Ingeniero agrónomo; turismo comunitario y planificación territorial.'],
            ['Angela María Galindo Cañon','Artesanías de Colombia','Maestra en Textiles y Máster en Alta Dirección','Programas de innovación textil y fortalecimiento empresarial.'],
            ['Claudia Marcela Sanz','Universidad San Buenaventura','Doctora en Diseño','Directora del Programa de Diseño de Vestuario; investigadora en moda.'],
            ['Carlos Enrique Fernández García','Universidad Nacional','Magíster en Educación','Tecnologías emergentes y RA aplicadas al periodismo.'],
            ['Amalia Aguilar Castillo','Universidad Xochicalco','Doctorado en Educación','Economista; directora de Facultad de Comercio Internacional y Aduanas.'],
            ['Diego Santos González','EAE Business School','Doctor en Sociología del Turismo','Director de máster en turismo; doctor por la Univ. Rey Juan Carlos.'],
        ];

        // Columnas reales presentes en la tabla (para insertar SOLO lo que existe)
        $cols = Schema::getColumnListing('speakers');
        $has = fn(string $c) => in_array($c, $cols, true);

        $rows = [];
        foreach ($base as $i => [$fullName, $company, $role, $bio]) {
            // email/phone ficticios consistentes
            $email = Str::slug(iconv('UTF-8', 'ASCII//TRANSLIT', $fullName), '').'@example.com';
            $phone = '+57 3001'.str_pad((string)($i+1), 3, '0', STR_PAD_LEFT);

            $row = [];

            // comunes
            if ($has('uuid'))        $row['uuid'] = (string) Str::uuid();
            if ($has('created_at'))  $row['created_at'] = $now;
            if ($has('updated_at'))  $row['updated_at'] = $now;

            // nombres (llenamos ambos si existen)
            if ($has('full_name'))   $row['full_name'] = $fullName;
            if ($has('name'))        $row['name'] = $fullName;

            // contacto/detalles modernos
            if ($has('email'))       $row['email'] = $email;
            if ($has('phone'))       $row['phone'] = $phone;
            if ($has('company'))     $row['company'] = $company;
            if ($has('role'))        $row['role'] = $role;

            // esquema viejo (compatibilidad)
            if ($has('profession'))  $row['profession'] = $role;
            if ($has('website'))     $row['website'] = null;
            if ($has('photo'))       $row['photo'] = null;
            if ($has('social_links'))$row['social_links'] = null;

            // bio
            if ($has('bio'))         $row['bio'] = $bio;

            // flags de estado (uno u otro según exista)
            if ($has('status'))      $row['status'] = true;
            if ($has('is_active'))   $row['is_active'] = true;

            // soft deletes no se llenan (deleted_at)

            $rows[] = $row;
        }

        DB::table('speakers')->insert($rows);

        $this->command?->info('Ponentes creados exitosamente!');
    }
}
