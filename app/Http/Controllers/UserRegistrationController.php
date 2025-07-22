<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'birthdate'  => 'required|date',
            'gender_id'  => 'required|exists:genders,id',
            'document_type_id' => 'required|exists:document_types,id',
            'document_number'  => 'required|string|unique:users,document_number',
            'user_type_id'     => 'required|exists:user_types,id',
            'academic_program_id' => 'nullable|exists:academic_programs,id',
            'institution_id'   => 'nullable|exists:institutions,id',
            'company_name'     => 'nullable|string|max:255',
            'company_address'  => 'nullable|string|max:255',
            'status'           => 'nullable|boolean',
            'accepted_terms'   => 'required|boolean',
            'password'         => 'nullable|string|min:6', // Puedes generar una por defecto si no se envía
        ]);

        // Si no viene una contraseña, asigna una por defecto
        $data['password'] = Hash::make($data['password'] ?? 'temporal123');

        $user = User::create($data);

        return response()->json([
            'message' => 'Usuario registrado exitosamente.',
            'user' => $user
        ], 201);
    }
}
