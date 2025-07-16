<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AcademicProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;  

class AcademicProgramsSeeder extends Seeder
{
    public function run(): void
    {
            $academic_programs = [

                // Universidad Francisco de Paula Santander (UFPS) - ID 1
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Sistemas',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Sistemas',
                    'institution_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Medicina',
                    'code' => 'MED',
                    'description' => 'Programa de Medicina',
                    'institution_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Contaduría Pública',
                    'code' => 'CP',
                    'description' => 'Programa de Contaduría Pública',
                    'institution_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

                // Universidad de Santander (UDES) - ID 2
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Enfermería',
                    'code' => 'ENF',
                    'description' => 'Programa de Enfermería',
                    'institution_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería Industrial',
                    'code' => 'II',
                    'description' => 'Programa de Ingeniería Industrial',
                    'institution_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Comunicación Social',
                    'code' => 'CS',
                    'description' => 'Programa de Comunicación Social',
                    'institution_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Fisioterapia',
                    'code' => 'FIS',
                    'description' => 'Programa de Fisioterapia',
                    'institution_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

                // Universidad Simón Bolívar (USB) - ID 3
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería Ambiental',
                    'code' => 'IA',
                    'description' => 'Programa de Ingeniería Ambiental',
                    'institution_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Software',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Software',
                    'institution_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración en Salud Ocupacional',
                    'code' => 'ASO',
                    'description' => 'Programa de Administración en Salud Ocupacional',
                    'institution_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Comercio Internacional',
                    'code' => 'CI',
                    'description' => 'Programa de Comercio Internacional',
                    'institution_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Diseño Industrial',
                    'code' => 'DI',
                    'description' => 'Programa de Diseño Industrial',
                    'institution_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

                 // Universidad Nacional Abierta y a Distancia (UNAD) - ID 4
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Sistemas',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Sistemas',
                    'institution_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Zootecnia',
                    'code' => 'ZOO',
                    'description' => 'Programa de Zootecnia',
                    'institution_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Licenciatura en Educación Básica',
                    'code' => 'LEB',
                    'description' => 'Programa de Licenciatura en Educación Básica',
                    'institution_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                 // Servicio Nacional de Aprendizaje (SENA) - ID 5
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Tecnólogo en Análisis y Desarrollo de Sistemas de Información',
                    'code' => 'TADSI',
                    'description' => 'Programa de Tecnólogo en Análisis y Desarrollo de Sistemas de Información',
                    'institution_id' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Técnico en Cocina',
                    'code' => 'TC',
                    'description' => 'Programa de Técnico en Cocina',
                    'institution_id' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Técnico en Soldadura',
                    'code' => 'TS',
                    'description' => 'Programa de Técnico en Soldadura',
                    'institution_id' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Tecnólogo en Gestión Logística',
                    'code' => 'TGL',
                    'description' => 'Programa de Tecnólogo en Gestión Logística',
                    'institution_id' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Técnico en Diseño de Modas',
                    'code' => 'TDM',
                    'description' => 'Programa de Técnico en Diseño de Modas',
                    'institution_id' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                 // Corporación Universitaria Minuto de Dios (UNIMINUTO) - ID 6
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración en Salud',
                    'code' => 'AS',
                    'description' => 'Programa de Administración en Salud',
                    'institution_id' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Contaduría Pública',
                    'code' => 'CP',
                    'description' => 'Programa de Contaduría Pública',
                    'institution_id' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería Industrial',
                    'code' => 'II',
                    'description' => 'Programa de Ingeniería Industrial',
                    'institution_id' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Comunicación Social',
                    'code' => 'CS',
                    'description' => 'Programa de Comunicación Social',
                    'institution_id' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                // Corporación Universitaria Autónoma de Nariño (AUNAR) - ID 7
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Software',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Software',
                    'institution_id' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Comunicación Social',
                    'code' => 'CS',
                    'description' => 'Programa de Comunicación Social',
                    'institution_id' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                // Politécnico Grancolombiano (PGC) - ID 8
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 8,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Contaduría Pública',
                    'code' => 'CP',
                    'description' => 'Programa de Contaduría Pública',
                    'institution_id' => 8,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Software',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Software',
                    'institution_id' => 8,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Mercadeo',
                    'code' => 'MER',
                    'description' => 'Programa de Mercadeo',
                    'institution_id' => 8,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 8,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                 // Corporación Instituto de Administración y Finanzas (CIAF) - ID 9
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración Financiera',
                    'code' => 'AF',
                    'description' => 'Programa de Administración Financiera',
                    'institution_id' => 9,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Contabilidad y Finanzas',
                    'code' => 'CF',
                    'description' => 'Programa de Contabilidad y Finanzas',
                    'institution_id' => 9,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Gestión de Negocios Internacionales',
                    'code' => 'GNI',
                    'description' => 'Programa de Gestión de Negocios Internacionales',
                    'institution_id' => 9,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Marketing Digital',
                    'code' => 'MD',
                    'description' => 'Programa de Marketing Digital',
                    'institution_id' => 9,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Gestión de Recursos Humanos',
                    'code' => 'GRH',
                    'description' => 'Programa de Gestión de Recursos Humanos',
                    'institution_id' => 9,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                 // Corporación Universitaria Remington (Uniremington) - ID 10
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 10,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 10,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Sistemas',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Sistemas',
                    'institution_id' => 10,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 10,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Comunicación Social',
                    'code' => 'CS',
                    'description' => 'Programa de Comunicación Social',
                    'institution_id' => 10,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                // Universidad de Pamplona (Unipamplona) - ID 11
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Medicina',
                    'code' => 'MED',
                    'description' => 'Programa de Medicina',
                    'institution_id' => 11,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Enfermería',
                    'code' => 'ENF',
                    'description' => 'Programa de Enfermería',
                    'institution_id' => 11,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería Civil',
                    'code' => 'IC',
                    'description' => 'Programa de Ingeniería Civil',
                    'institution_id' => 11,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 11,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 11,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                // Universidad Cooperativa de Colombia (UCC) - ID 12
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Medicina',
                    'code' => 'MED',
                    'description' => 'Programa de Medicina',
                    'institution_id' => 12,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 12,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 12,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 12,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Sistemas',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Sistemas',
                    'institution_id' => 12,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                // Universidad de San Buenaventura (USB) - ID 13
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Filosofía',
                    'code' => 'FIL',
                    'description' => 'Programa de Filosofía',
                    'institution_id' => 13,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Teología',
                    'code' => 'TEO',
                    'description' => 'Programa de Teología',
                    'institution_id' => 13,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 13,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 13,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería Industrial',
                    'code' => 'II',
                    'description' => 'Programa de Ingeniería Industrial',
                    'institution_id' => 13,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                // Universidad Autónoma de Bucaramanga (UNAB) - ID 14
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Medicina',
                    'code' => 'MED',
                    'description' => 'Programa de Medicina',
                    'institution_id' => 14,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería Civil',
                    'code' => 'IC',
                    'description' => 'Programa de Ingeniería Civil',
                    'institution_id' => 14,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 14,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 14,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 14,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                // Universidad de Investigación y Desarrollo (UDI) - ID 15
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Software',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Software',
                    'institution_id' => 15,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 15,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 15,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 15,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Comunicación Social',
                    'code' => 'CS',
                    'description' => 'Programa de Comunicación Social',
                    'institution_id' => 15,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                // Universidad Católica de Manizales (IST) - ID 16
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Sistemas y Telecomunicaciones',
                    'code' => 'IST',
                    'institution_id' => 16,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 16,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 16,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 16,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Universidad EAN (UEAN) - ID 17
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración de Empresas',
                    'code' => 'AE',
                    'description' => 'Programa de Administración de Empresas',
                    'institution_id' => 17,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Sistemas',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Sistemas',
                    'institution_id' => 17,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Economía',
                    'code' => 'ECO',
                    'description' => 'Programa de Economía',
                    'institution_id' => 17,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Negocios Internacionales',
                    'code' => 'NI',
                    'description' => 'Programa de Negocios Internacionales',
                    'institution_id' => 17,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Corporación Universitaria Autónoma del Cauca (CUAC) - ID 18
                  [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería Agroindustrial',
                    'code' => 'IA',
                    'description' => 'Programa de Ingeniería Agroindustrial',
                    'institution_id' => 18,
                    'created_at' => now(),
                    'updated_at' => now(),
                  ],
                  [
                    'uuid' => Str::uuid(),
                    'name' => 'Ingeniería de Sistemas',
                    'code' => 'IS',
                    'description' => 'Programa de Ingeniería de Sistemas',
                    'institution_id' => 18,
                    'created_at' => now(),
                    'updated_at' => now(),
                  ],
                  [
                    'uuid' => Str::uuid(),
                    'name' => 'Derecho',
                    'code' => 'DER',
                    'description' => 'Programa de Derecho',
                    'institution_id' => 18,
                    'created_at' => now(),
                    'updated_at' => now(),
                  ],
                  [
                    'uuid' => Str::uuid(),
                    'name' => 'Psicología',
                    'code' => 'PSI',
                    'description' => 'Programa de Psicología',
                    'institution_id' => 18,
                    'created_at' => now(),
                    'updated_at' => now(),
                 ],
                 [
                    'uuid' => Str::uuid(),
                    'name' => 'Administración Pública',
                    'code' => 'AP',
                    'description' => 'Programa de Administración Pública',
                    'institution_id' => 18,
                    'created_at' => now(),
                    'updated_at' => now(),
                 ],
                 [
                    'uuid' => Str::uuid(),
                    'name' => 'Enfermería',
                    'code' => 'ENF',
                    'description' => 'Programa de Enfermería',
                    'institution_id' => 18,
                    'created_at' => now(),
                    'updated_at' => now(),
                 ],

                    // Fundación de Estudios Superiores Comfanorte (FESC) - ID 19
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Diseño Grafico',
                        'code' => 'DG',
                        'color' => '#FFBA1D',
                        'description' => 'Programa de Diseño Gráfico',
                        'institution_id' => 19,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Diseño y Administración de Negocios de Moda',
                        'code' => 'DANM',
                        'color' => '#8A3D84',
                        'description' => 'Programa de Diseño y Administración de Negocios de Moda',
                        'institution_id' => 19,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Administración Turística y Hotelera',
                        'code' => 'ATH',
                        'color' => '#13BD7F',
                        'description' => 'Programa de Administración Turística y Hotelera',
                        'institution_id' => 19,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Ingeniería del Software',
                        'code' => 'IS',
                        'color' => '#2F9ED3',
                        'description' => 'Programa de Ingeniería del Software',
                        'institution_id' => 19,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Administración de Negocios Internacionales',
                        'code' => 'ANI',
                        'color' => '#05939C',
                        'description' => 'Programa de Administración de Negocios Internacionales',
                        'institution_id' => 19,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Administración Financiera',
                        'code' => 'AF',
                        'color' => '#770E13',
                        'description' => 'Programa de Administración Financiera',
                        'institution_id' => 19,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Gestion Logistica Empresarial',
                        'code' => 'GLE',
                        'color' => '#B70331',
                        'description' => 'Administración Programa de Gestion Logistica Empresarial',
                        'institution_id' => 19,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Bienestar Universitario',
                        'code' => 'BU',
                        'color' => '#FFFFFF',
                        'description' => 'Bienestar Universitario',
                        'institution_id' => 19,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    // Escuela de Estudios Técnicos (EET) - ID 20
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Gestión Administrativa',
                        'code' => 'TGA',
                        'description' => 'Programa de Tecnología en Gestión Administrativa',
                        'institution_id' => 20,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Contabilidad Pública',
                        'code' => 'TCP',
                        'description' => 'Programa de Tecnología en Contabilidad Pública',
                        'institution_id' => 20,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Desarrollo de Software',
                        'code' => 'TDS',
                        'description' => 'Programa de Tecnología en Desarrollo de Software',
                        'institution_id' => 20,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Técnico Laboral en Electricidad Industrial',
                        'code' => 'TLEI',
                        'description' => 'Programa de Técnico Laboral en Electricidad Industrial',
                        'institution_id' => 20,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Técnico Laboral en Mecánica Automotriz',
                        'code' => 'TLMA',
                        'description' => 'Programa de Técnico Laboral en Mecánica Automotriz',
                        'institution_id' => 20,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Seguridad y Salud en el Trabajo',
                        'code' => 'TSS',
                        'description' => 'Programa de Tecnología en Seguridad y Salud en el Trabajo',
                        'institution_id' => 20,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                // Institución Universitaria ITSA (ITSA) - ID 21
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Gestión Empresarial',
                        'code' => 'TGE',
                        'description' => 'Programa de Tecnología en Gestión Empresarial',
                        'institution_id' => 21,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Desarrollo de Software',
                        'code' => 'TDS',
                        'description' => 'Programa de Tecnología en Desarrollo de Software',
                        'institution_id' => 21,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Técnico Profesional en Enfermería',
                        'code' => 'TPE',
                        'description' => 'Programa de Técnico Profesional en Enfermería',
                        'institution_id' => 21,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Seguridad y Salud en el Trabajo',
                        'code' => 'TSS',
                        'description' => 'Programa de Tecnología en Seguridad y Salud en el Trabajo',
                        'institution_id' => 21,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Administración de Empresas',
                        'code' => 'TAE',
                        'description' => 'Programa de Tecnología en Administración de Empresas',
                        'institution_id' => 21,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Enfermería Profesional',
                        'code' => 'TEP',
                        'description' => 'Programa de Técnico Profesional en Enfermería',
                        'institution_id' => 21,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Logística Internacional',
                        'code' => 'TLI',
                        'description' => 'Programa de Tecnología en Logística Internacional',
                        'institution_id' => 21,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    // Corporación Universitaria Rafael Núñez (CURN) - ID 22
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Ingeniería de Sistemas',
                        'code' => 'IS',
                        'description' => 'Programa de Ingeniería de Sistemas',
                        'institution_id' => 22,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Administración de Empresas',
                        'code' => 'TAE',
                        'description' => 'Programa de Tecnología en Administración de Empresas',
                        'institution_id' => 22,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Derecho',
                        'code' => 'DRE',
                        'description' => 'Programa de Derecho',
                        'institution_id' => 22,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Psicología',
                        'code' => 'PSI',
                        'description' => 'Programa de Psicología',
                        'institution_id' => 22,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Enfermería Profesional',
                        'code' => 'EP',
                        'description' => 'Programa de Enfermería Profesional',
                        'institution_id' => 22,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Gestión Pública',
                        'code' => 'TGP',
                        'description' => 'Programa de Tecnología en Gestión Pública',
                        'institution_id' => 22,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Contaduría Pública',
                        'code' => 'CP',
                        'description' => 'Programa de Contaduría Pública',
                        'institution_id' => 22,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Mercadeo y Publicidad',
                        'code' => 'MP',
                        'description' => 'Programa de Mercadeo y Publicidad',
                        'institution_id' => 22,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    // Institución Universitaria Digital de Antioquia (IUDA) - ID 23
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Desarrollo de Software',
                        'code' => 'TDS',
                        'description' => 'Programa de Tecnología en Desarrollo de Software',
                        'institution_id' => 23,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Técnico Laboral en Gestión Empresarial',
                        'code' => 'TLGE',
                        'description' => 'Programa de Técnico Laboral en Gestión Empresarial',
                        'institution_id' => 23,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Gestión Pública',
                        'code' => 'TGP',
                        'description' => 'Programa de Tecnología en Gestión Pública',
                        'institution_id' => 23,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Técnico Laboral en Contabilidad',
                        'code' => 'TLC',
                        'description' => 'Programa de Técnico Laboral en Contabilidad',
                        'institution_id' => 23,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Seguridad Informática',
                        'code' => 'TSI',
                        'description' => 'Programa de Tecnología en Seguridad Informática',
                        'institution_id' => 23,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Técnico Profesional en Redes de Datos',
                        'code' => 'TPRD',
                        'description' => 'Programa de Técnico Profesional en Redes de Datos',
                        'institution_id' => 23,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Comercio Exterior',
                        'code' => 'TCE',
                        'description' => 'Programa de Tecnología en Comercio Exterior',
                        'institution_id' => 23,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    // Universidad Libre (Unilibre) - ID 24
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Ingeniería de Sistemas',
                        'code' => 'IS',
                        'description' => 'Programa de Ingeniería de Sistemas',
                        'institution_id' => 24,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Derecho',
                        'code' => 'D',
                        'description' => 'Programa de Derecho',
                        'institution_id' => 24,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Administración de Empresas',
                        'code' => 'AE',
                        'description' => 'Programa de Administración de Empresas',
                        'institution_id' => 24,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Psicología',
                        'code' => 'P',
                        'description' => 'Programa de Psicología',
                        'institution_id' => 24,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Medicina',
                        'code' => 'M',
                        'description' => 'Programa de Medicina',
                        'institution_id' => 24,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Enfermería Profesional',
                        'code' => 'EP',
                        'description' => 'Programa de Enfermería Profesional',
                        'institution_id' => 24,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Contaduría Pública',
                        'code' => 'CP',
                        'description' => 'Programa de Contaduría Pública',
                        'institution_id' => 24,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'name' => 'Tecnología en Gestión Ambiental',
                        'code' => 'TGA',
                        'description' => 'Programa de Tecnología en Gestión Ambiental',
                        'institution_id' => 24,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
            ];

        foreach ($academic_programs as $academic_program) {
            AcademicProgram::create($academic_program);
        }
    }
}
