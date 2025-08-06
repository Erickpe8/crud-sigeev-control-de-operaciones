<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Gender;
use App\Models\DocumentType;
use App\Models\UserType;
use App\Models\AcademicProgram;
use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        // Seleccionamos un tipo de usuario aleatorio
        $userType = UserType::inRandomOrder()->first();

        // Datos base
        $data = [
            'uuid' => Str::uuid(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('Password123'),
            'birthdate' => $this->faker->date('Y-m-d', '-18 years'),
            'gender_id' => Gender::inRandomOrder()->first()?->id,
            'document_type_id' => DocumentType::inRandomOrder()->first()?->id,
            'user_type_id' => $userType->id,
            'document_number' => $this->faker->numerify('10########'),
            'accepted_terms' => true,
            'status' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Si es estudiante
        if ($userType->id === 4) {
            $data['academic_program_id'] = AcademicProgram::inRandomOrder()->first()?->id;
            $data['institution_id'] = Institution::inRandomOrder()->first()?->id;
        }

        // Si es empresa (2) o externo (3)
        if (in_array($userType->id, [2, 3])) {
            $data['company_name'] = $this->faker->company();
            $data['company_address'] = $this->faker->address();
        }

        return $data;
    }
}
