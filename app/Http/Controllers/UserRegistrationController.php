<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserRegistrationController extends Controller
{
    /**
     * Maneja el registro de nuevos usuarios.
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $user = User::create([
            'uuid'                => Str::uuid(),
            'first_name'          => $data['first_name'],
            'last_name'           => $data['last_name'],
            'email'               => $data['email'],
            'birthdate'           => $data['birthdate'],
            'gender_id'           => $data['gender_id'],
            'document_type_id'    => $data['document_type_id'],
            'document_number'     => $data['document_number'],
            'user_type_id'        => $data['user_type_id'],
            'academic_program_id' => $data['academic_program_id'] ?? null,
            'institution_id'      => $data['institution_id'] ?? null,
            'company_name'        => $data['company_name'] ?? null,
            'company_address'     => $data['company_address'] ?? null,
            'status'              => $data['status'] ?? true,
            'accepted_terms'      => $data['accepted_terms'],
            'password'            => Hash::make($data['password']),
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente.',
            'user'    => $user,
        ], 201);
    }

    /**
     * Valida y retorna los datos de la solicitud.
     */
    protected function validateData(Request $request): array
    {
        $rules = [
            'first_name'           => 'required|string|max:255',
            'last_name'            => 'required|string|max:255',
            'email'                => 'required|email|max:255|unique:users,email',
            'birthdate'            => 'required|date|before:today',

            'gender_id'            => 'required|exists:genders,id',
            'document_type_id'     => 'required|exists:document_types,id',
            'document_number'      => 'required|string|max:30|unique:users,document_number',
            'user_type_id'         => 'required|exists:user_types,id',

            'academic_program_id'  => 'nullable|exists:academic_programs,id',
            'institution_id'       => 'nullable|exists:institutions,id',

            'company_name'         => 'nullable|string|max:255',
            'company_address'      => 'nullable|string|max:500',

            'status'               => 'nullable|boolean',
            'accepted_terms'       => 'accepted',
            'password'             => 'required|string|min:6|max:255',
        ];

                $messages = [
            'first_name.required'           => 'El nombre es obligatorio.',
            'last_name.required'            => 'El apellido es obligatorio.',
            'email.required'                => 'El correo electrónico es obligatorio.',
            'email.email'                   => 'El formato del correo electrónico no es válido.',
            'email.unique'                  => 'El correo electrónico ya está registrado.',
            'birthdate.required'            => 'La fecha de nacimiento es obligatoria.',
            'birthdate.before'              => 'La fecha de nacimiento debe ser anterior a hoy.',
            'gender_id.required'           => 'El género es obligatorio.',
            'gender_id.exists'             => 'El género seleccionado no es válido.',
            'document_type_id.required'    => 'El tipo de documento es obligatorio.',
            'document_type_id.exists'      => 'El tipo de documento no es válido.',
            'document_number.required'     => 'El número de documento es obligatorio.',
            'document_number.unique'       => 'El número de documento ya está registrado.',
            'user_type_id.required'        => 'El tipo de usuario es obligatorio.',
            'user_type_id.exists'          => 'El tipo de usuario no es válido.',
            'accepted_terms.accepted'      => 'Debes aceptar los términos y condiciones.',
            'password.required'            => 'La contraseña es obligatoria.',
            'password.min'                 => 'La contraseña debe tener al menos 6 caracteres.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
