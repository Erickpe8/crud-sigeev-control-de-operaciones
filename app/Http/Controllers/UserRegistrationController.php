<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserRegistrationController extends Controller
{
    /**
     * Registra un nuevo usuario en el sistema después de validar los datos requeridos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Definición de reglas de validación
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
            'password'             => 'nullable|string|min:6|max:255',
        ];

        // Mensajes personalizados de validación
        $messages = [
            'first_name.required'           => 'El nombre es obligatorio.',
            'last_name.required'            => 'El apellido es obligatorio.',
            'email.required'                => 'El correo electrónico es obligatorio.',
            'email.email'                   => 'El formato del correo electrónico no es válido.',
            'email.unique'                  => 'El correo electrónico ya está registrado.',
            'birthdate.required'            => 'La fecha de nacimiento es obligatoria.',
            'birthdate.date'                => 'La fecha de nacimiento no es válida.',
            'birthdate.before'              => 'La fecha de nacimiento debe ser anterior a hoy.',

            'gender_id.required'            => 'El género es obligatorio.',
            'gender_id.exists'              => 'El género seleccionado no es válido.',
            'document_type_id.required'     => 'El tipo de documento es obligatorio.',
            'document_type_id.exists'       => 'El tipo de documento no es válido.',
            'document_number.required'      => 'El número de documento es obligatorio.',
            'document_number.unique'        => 'El número de documento ya está registrado.',
            'user_type_id.required'         => 'El tipo de usuario es obligatorio.',
            'user_type_id.exists'           => 'El tipo de usuario no es válido.',

            'accepted_terms.accepted'       => 'Debes aceptar los términos y condiciones.',
            'password.min'                  => 'La contraseña debe tener al menos 6 caracteres.',
        ];

        // Validación manual usando Validator para mejor manejo de errores
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Datos validados
        $data = $validator->validated();

        // UUID único para el usuario
        $data['uuid'] = Str::uuid();

        // Asignar contraseña encriptada (o usar una por defecto)
        $data['password'] = Hash::make($data['password'] ?? 'temporal123');

        // Crear el usuario
        $user = User::create($data);

        return response()->json([
            'message' => 'Usuario registrado exitosamente.',
            'user' => $user,
        ], 201);
    }
}
