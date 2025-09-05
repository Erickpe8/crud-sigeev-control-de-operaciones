<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\AcademicProgram;
use App\Models\DocumentType;
use App\Models\Gender;
use App\Models\Institution;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class PanelCreateUserController extends Controller
{
    /**
     * Mostrar el formulario de creación de usuarios.
     */
    public function create()
    {
        $auth = auth()->user();

        $roles = $auth?->hasRole('superadmin')
            ? Role::query()->orderBy('name')->pluck('name')
            : collect();

        return view('auth.createusers', [
            'genders'           => Gender::all(),
            'documentTypes'     => DocumentType::all(),
            'userTypes'         => UserType::all(),
            'academicPrograms'  => AcademicProgram::all(),
            'institutions'      => Institution::all(),
            'roles'             => $roles,
        ]);
    }

    /**
     * Guardar el usuario creado por admin/superadmin.
     */
    public function store(Request $request)
    {
        // Normalización simple
        $request->merge([
            'email' => trim(mb_strtolower((string) $request->input('email'))),
        ]);

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
            'accepted_terms'      => true,
            // El cast 'hashed' en el modelo se encarga del hash
            'password'            => $data['password'],
        ]);

        // Rol inicial
        $auth = $request->user();
        $roleToAssign = 'user';
        if ($auth?->hasRole('superadmin') && !empty($data['role'])) {
            $roleToAssign = $data['role'];
        }
        $user->assignRole($roleToAssign);

        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'user'    => $user->load('roles'),
        ], 201);
    }

    /**
     * Validaciones del formulario.
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
            'password'             => 'required|string|min:8|confirmed',
            'password_confirmation'=> 'required|string|min:8',
            // Solo superadmin puede enviar role y debe existir
            'role'                 => 'nullable|string|exists:roles,name',
        ];

        $messages = [
            'email.unique'            => 'Este correo ya está registrado.',
            'document_number.unique'  => 'Este número de documento ya está en uso.',
            'birthdate.before'        => 'La fecha de nacimiento debe ser anterior a hoy.',
            'password.confirmed'      => 'La confirmación de contraseña no coincide.',
            'password.min'            => 'La contraseña debe tener al menos 8 caracteres.',
            'role.exists'             => 'El rol seleccionado no existe.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}