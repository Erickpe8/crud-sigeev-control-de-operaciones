<?php

namespace App\Http\Controllers\web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema; // <— para detectar columnas
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use App\Models\DocumentType;
use App\Models\UserType;
use App\Models\AcademicProgram;
use App\Models\Institution;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

/**
 * Controlador principal de administración de usuarios (SUPERADMIN)
 */
class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 50);
        $perPage = $perPage > 0 && $perPage <= 200 ? $perPage : 50;

        $users = $query->paginate($perPage)->withQueryString();

        // Columnas “name-like” detectadas en runtime para evitar errores 1054
        $docTypeCol  = $this->pickNameColumn('document_types', ['name','type','title','label','description','descripcion']);
        $userTypeCol = $this->pickNameColumn('user_types',     ['name','type','title','label','description','descripcion']);

        $genders          = Gender::select('id','name')->get();
        $documentTypes    = $docTypeCol  ? DocumentType::select('id', "$docTypeCol as type")->get() : collect();
        $userTypes        = $userTypeCol ? UserType::select('id', "$userTypeCol as name")->get()     : collect();
        $academicPrograms = AcademicProgram::select('id','name')->get();
        $institutions     = Institution::select('id','name')->get();
        $roles            = Role::select('name')->get();

        // ⚠️ Retorna la vista de SUPERADMIN
        return view('dashboards.superadmin.superadmin', compact(
            'users',
            'genders',
            'documentTypes',
            'userTypes',
            'academicPrograms',
            'institutions',
            'roles'
        ));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['email']          = mb_strtolower($data['email']);
        $data['status']         = array_key_exists('status', $data) ? (bool) $data['status'] : true;
        $data['accepted_terms'] = (bool) ($data['accepted_terms'] ?? false);

        if (!empty($data['birthdate'])) {
            $data['birthdate'] = $this->parseBirthdate($data['birthdate']);
        }

        if (empty($data['username'])) {
            $data['username'] = $this->makeUsername($data['first_name'] ?? '', $data['last_name'] ?? '');
        }

        try {
            $user = DB::transaction(function () use ($data) {
                $user = new User();
                $user->fill(collect($data)->except(['password'])->toArray());
                $user->password = Hash::make($data['password']);
                $user->save();

                $defaultRole   = 'user';
                $roleToAssign  = $defaultRole;

                if (!empty($data['role']) && Role::where('name', $data['role'])->exists()) {
                    if (auth()->user()?->hasRole('superadmin')) {
                        $roleToAssign = $data['role'];
                    }
                }

                $user->syncRoles([$roleToAssign]);

                return $user->load('roles');
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Usuario creado correctamente.',
                    'user'    => $user,
                ], 201);
            }

            // 🔁 Redirige a la ruta del panel de SUPERADMIN
            return redirect()->route('dashboards.superadmin')->with('success', 'Usuario creado correctamente.');
        } catch (\Throwable $e) {
            Log::error('Error al crear usuario: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Error interno del servidor.'], 500);
            }

            return back()->withErrors(['general' => 'Error al crear usuario.'])->withInput();
        }
    }

    public function edit(User $user)
    {
        if ($user->hasRole('superadmin') && !auth()->user()?->hasRole('superadmin')) {
            abort(403, 'Solo superadmin puede editar a un superadmin.');
        }

        $docTypeCol  = $this->pickNameColumn('document_types', ['name','type','title','label','description','descripcion']);
        $userTypeCol = $this->pickNameColumn('user_types',     ['name','type','title','label','description','descripcion']);

        $genders          = Gender::select('id','name')->get();
        $documentTypes    = $docTypeCol  ? DocumentType::select('id', "$docTypeCol as type")->get() : collect();
        $userTypes        = $userTypeCol ? UserType::select('id', "$userTypeCol as name")->get()     : collect();
        $academicPrograms = AcademicProgram::select('id','name')->get();
        $institutions     = Institution::select('id','name')->get();
        $roles            = Role::select('name')->get();

        // Si tu vista de edición es otra, actualiza el path aquí
        return view('admin.users.edit', compact(
            'user',
            'genders',
            'documentTypes',
            'userTypes',
            'academicPrograms',
            'institutions',
            'roles'
        ));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if ($user->hasRole('superadmin') && !auth()->user()?->hasRole('superadmin')) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No autorizado para editar a un superadmin.'], 403)
                : abort(403, 'No autorizado para editar a un superadmin.');
        }

        $data = $request->validated();

        if (isset($data['email'])) {
            $data['email'] = mb_strtolower($data['email']);
        }
        if (array_key_exists('birthdate', $data)) {
            $data['birthdate'] = $data['birthdate'] ? $this->parseBirthdate($data['birthdate']) : null;
        }

        try {
            $user = DB::transaction(function () use ($user, $data) {
                $user->fill(collect($data)->except(['password', 'role'])->toArray());

                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }

                $user->save();

                if (!empty($data['role'])) {
                    $newRole = $data['role'];

                    if ($user->id === auth()->id() && $user->hasRole('superadmin') && $newRole !== 'superadmin') {
                        throw new \RuntimeException('No puedes degradar tu propio rol de superadmin.');
                    }

                    if (!auth()->user()?->hasRole('superadmin')) {
                        throw new \RuntimeException('No autorizado para modificar roles.');
                    }

                    $user->syncRoles([$newRole]);
                }

                return $user->load('roles');
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Usuario actualizado correctamente.',
                    'user'    => $user,
                ]);
            }

            // 🔁 Redirige al panel de SUPERADMIN
            return redirect()->route('dashboards.superadmin')->with('success', 'Usuario actualizado correctamente.');
        } catch (\RuntimeException $ex) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $ex->getMessage()], 422);
            }
            return back()->withErrors(['role' => $ex->getMessage()]);
        } catch (\Throwable $e) {
            Log::error('Error al actualizar usuario: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Error interno del servidor.'], 500);
            }

            return back()->withErrors(['general' => 'Error al actualizar usuario.']);
        }
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->hasRole('superadmin')) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No puedes eliminar a un superadmin.'], 403)
                : abort(403, 'No puedes eliminar a un superadmin.');
        }
        if ($user->id === auth()->id()) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No puedes eliminar tu propia cuenta.'], 403)
                : abort(403, 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Usuario eliminado correctamente.']);
        }

        // 🔁 Redirige al panel de SUPERADMIN
        return back()->with('success', 'Usuario eliminado correctamente.');
    }

    /** Detecta una columna “de nombre” en la tabla para aliasarla */
    private function pickNameColumn(string $table, array $candidates = ['name','type','title','label','description','descripcion']): ?string
    {
        foreach ($candidates as $col) {
            if (Schema::hasColumn($table, $col)) {
                return $col;
            }
        }
        return null;
    }

    private function parseBirthdate(string $input): ?string
    {
        $candidatos = ['d/m/Y', 'Y-m-d', 'm/d/Y'];
        foreach ($candidatos as $fmt) {
            try {
                return Carbon::createFromFormat($fmt, $input)->format('Y-m-d');
            } catch (\Throwable $e) {}
        }
        try {
            return Carbon::parse($input)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function makeUsername(string $firstName, string $lastName): string
    {
        $firstName = trim(mb_strtolower($firstName));
        $lastName  = trim(mb_strtolower($lastName));
        $first     = $firstName ? explode(' ', $firstName)[0] : 'user';
        $last      = $lastName ? explode(' ', $lastName)[0] : mt_rand(1000, 9999);

        $base = preg_replace('/[^a-z0-9]/', '', $first.$last[0].$last);
        return $base ?: 'user'.mt_rand(1000, 9999);
    }
}

/**
 * Form Request: StoreUserRequest
 */
class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'          => 'required|string|max:100',
            'last_name'           => 'required|string|max:100',
            'email'               => 'required|email:rfc,dns|unique:users,email',
            'password'            => 'required|string|min:8|confirmed',
            'gender_id'           => 'nullable|exists:genders,id',
            'document_type_id'    => 'nullable|exists:document_types,id',
            'user_type_id'        => 'nullable|exists:user_types,id',
            'academic_program_id' => 'nullable|exists:academic_programs,id',
            'institution_id'      => 'nullable|exists:institutions,id',
            'document_number'     => 'nullable|string|max:50',
            'company_name'        => 'nullable|string|max:255',
            'company_address'     => 'nullable|string|max:255',
            'birthdate'           => 'nullable|string',
            'status'              => 'nullable|boolean',
            'accepted_terms'      => 'nullable|boolean',
            'username'            => 'nullable|string|max:60|unique:users,username',
            'role'                => ['nullable', Rule::in(Role::pluck('name')->all())],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'El correo ya está registrado.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ];
    }
}

/**
 * Form Request: UpdateUserRequest
 */
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? null;

        return [
            'first_name'          => 'required|string|max:100',
            'last_name'           => 'required|string|max:100',
            'email'               => [
                'required', 'email:rfc,dns',
                Rule::unique('users','email')->ignore($userId),
            ],
            'password'            => 'nullable|string|min:8|confirmed',
            'gender_id'           => 'nullable|exists:genders,id',
            'document_type_id'    => 'nullable|exists:document_types,id',
            'user_type_id'        => 'nullable|exists:user_types,id',
            'academic_program_id' => 'nullable|exists:academic_programs,id',
            'institution_id'      => 'nullable|exists:institutions,id',
            'document_number'     => 'nullable|string|max:50',
            'company_name'        => 'nullable|string|max:255',
            'company_address'     => 'nullable|string|max:255',
            'birthdate'           => 'nullable|string',
            'status'              => 'nullable|boolean',
            'accepted_terms'      => 'nullable|boolean',
            'username'            => [
                'nullable','string','max:60',
                Rule::unique('users','username')->ignore($userId),
            ],
            'role'                => ['nullable', Rule::in(Role::pluck('name')->all())],
        ];
    }
}
