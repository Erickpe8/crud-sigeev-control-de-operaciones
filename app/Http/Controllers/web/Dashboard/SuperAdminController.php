<?php

namespace App\Http\Controllers\web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema; // para detectar columnas
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
 * Versión: paginación y búsqueda SOLO en el plugin (cliente)
 */
class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->select([
                'id','first_name','last_name','email',
                'document_number','phone','gender_id',
                'document_type_id','user_type_id','birthdate'
            ])
            ->orderByDesc('id')
            ->limit(10000)
            ->get();

        // Columnas “name-like” detectadas para aliasar
        $docTypeCol  = $this->pickNameColumn('document_types', ['name','type','title','label','description','descripcion']);
        $userTypeCol = $this->pickNameColumn('user_types',     ['name','type','title','label','description','descripcion']);

        $genders          = Gender::select('id','name')->get();
        $documentTypes    = $docTypeCol  ? DocumentType::select('id', "$docTypeCol as type")->get() : collect();
        $userTypes        = $userTypeCol ? UserType::select('id', "$userTypeCol as name")->get()     : collect();
        $academicPrograms = AcademicProgram::select('id','name')->get();
        $institutions     = Institution::select('id','name')->get();
        $roles            = Role::select('name')->get();

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

        // normalizaciones
        $data['email']          = mb_strtolower(trim($data['email']));
        $data['status']         = array_key_exists('status', $data) ? (bool) $data['status'] : true;
        $data['accepted_terms'] = (bool) ($data['accepted_terms'] ?? false);

        // normaliza phone (si viene)
        if (array_key_exists('phone', $data) && $data['phone'] !== null) {
            $phone = trim($data['phone']);
            $phone = preg_replace('/\s+/', ' ', $phone); // colapsa espacios
            $data['phone'] = $phone;
        }

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

        // Actualiza la vista si tu path de edición es otro
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
        $auth = auth()->user();

        // Guardrails de autorización
        if ($user->hasRole('superadmin') && !$auth?->hasRole('superadmin')) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No autorizado para editar a un superadmin.'], 403)
                : abort(403, 'No autorizado para editar a un superadmin.');
        }

        // Normalización inicial
        $phoneSanitized = null;
        if ($request->filled('phone')) {
            $phoneSanitized = preg_replace('/\s+/', ' ', trim((string) $request->input('phone')));
        }

        $request->merge([
            'email'           => trim(mb_strtolower((string) $request->input('email'))),
            'document_number' => trim((string) $request->input('document_number')),
            'phone'           => $phoneSanitized,
        ]);

        // Revalidación condicional
        $userId = $user->id;

        $rules = [
            'first_name'          => 'required|string|max:100',
            'last_name'           => 'required|string|max:100',
            'gender_id'           => 'nullable|exists:genders,id',
            'document_type_id'    => 'nullable|exists:document_types,id',
            'user_type_id'        => 'nullable|exists:user_types,id',
            'academic_program_id' => 'nullable|exists:academic_programs,id',
            'institution_id'      => 'nullable|exists:institutions,id',
            'company_name'        => 'nullable|string|max:255',
            'company_address'     => 'nullable|string|max:255',
            'birthdate'           => 'nullable|string',
            'status'              => 'nullable|boolean',
            'accepted_terms'      => 'nullable|boolean',
            'role'                => 'nullable|string|exists:roles,name',
            'phone'               => ['nullable','string','max:25','regex:/^[0-9+\-\s()]{7,25}$/'],
        ];

        if ($request->email !== $user->email) {
            $rules['email'] = [
                'required', 'email',
                Rule::unique('users', 'email')->ignore($userId),
            ];
        } else {
            $rules['email'] = ['required', 'email'];
        }

        if ($request->document_number !== $user->document_number) {
            $rules['document_number'] = [
                'nullable', 'string', 'max:50',
                Rule::unique('users', 'document_number')->ignore($userId),
            ];
        }

        $data = $request->validate($rules);

        // Normalización final
        if (array_key_exists('birthdate', $data)) {
            $data['birthdate'] = $data['birthdate'] ? $this->parseBirthdate($data['birthdate']) : null;
        }

        try {
            $updated = DB::transaction(function () use ($user, $data, $auth) {

                $fillable = collect($data)->except(['password', 'role'])->toArray();
                $user->fill($fillable);

                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }

                if ($user->isDirty()) {
                    $user->save();
                }

                // Cambio de rol (forzado/manual)
                if (array_key_exists('role', $data) && $data['role'] !== null && $data['role'] !== '') {
                    $newRole = $data['role'];

                    if (!$auth?->hasRole('superadmin')) {
                        throw new \RuntimeException('No autorizado para modificar roles.');
                    }

                    if ($auth->id === $user->id && $user->hasRole('superadmin') && $newRole !== 'superadmin') {
                        throw new \RuntimeException('No puedes degradar tu propio rol de superadmin.');
                    }

                    $roleModel = Role::where('name', $newRole)->first();
                    if (!$roleModel) {
                        throw new \RuntimeException('El rol especificado no existe.');
                    }

                    DB::table('model_has_roles')
                        ->where('model_id', $user->id)
                        ->where('model_type', User::class)
                        ->delete();

                    DB::table('model_has_roles')->insert([
                        'role_id'    => $roleModel->id,
                        'model_type' => User::class,
                        'model_id'   => $user->id,
                    ]);

                    \Log::info("✅ Rol forzado actualizado para el usuario {$user->id} a: {$newRole}");
                }

                return $user->load('roles');
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Usuario actualizado correctamente.',
                    'user'    => $updated,
                ], 200);
            }

            return redirect()
                ->route('dashboards.superadmin')
                ->with('success', 'Usuario actualizado correctamente.');

        } catch (\RuntimeException $ex) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $ex->getMessage()], 422);
            }
            return back()->withErrors(['role' => $ex->getMessage()]);
        } catch (\Illuminate\Database\QueryException $ex) {
            $msg = 'No se pudo actualizar el usuario. Verifica que el correo/usuario no estén repetidos.';
            if ($request->expectsJson()) {
                return response()->json(['message' => $msg], 422);
            }
            return back()->withErrors(['general' => $msg])->withInput();
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
        $auth = $request->user();

        if ($user->id === $auth->id) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No puedes eliminar tu propia cuenta.'], 403)
                : abort(403, 'No puedes eliminar tu propia cuenta.');
        }

        if ($user->hasRole('superadmin')) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No puedes eliminar a un superadmin.'], 403)
                : abort(403, 'No puedes eliminar a un superadmin.');
        }

        try {
            DB::transaction(function () use ($user) {
                // Revocar tokens (Sanctum si aplica)
                if (method_exists($user, 'tokens')) {
                    $user->tokens()->delete();
                } else {
                    // Fallback si no hay relación definida
                    // \Laravel\Sanctum\PersonalAccessToken::where(...) si usas Sanctum y quieres limpiar
                }

                // Limpiar permisos/roles (Spatie)
                if (method_exists($user, 'roles')) {
                    $user->syncRoles([]);
                }
                if (method_exists($user, 'permissions')) {
                    $user->syncPermissions([]);
                }

                $user->delete();
            });

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Usuario eliminado correctamente.'], 200);
            }
            return back()->with('success', 'Usuario eliminado correctamente.');

        } catch (\Throwable $e) {
            Log::error('Error al eliminar usuario', [
                'user_id' => $user->id,
                'by'      => $auth?->id,
                'error'   => $e->getMessage(),
            ]);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'No se pudo eliminar el usuario.'], 500);
            }
            return back()->withErrors(['error' => 'No se pudo eliminar el usuario.']);
        }
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
            'email'               => 'required|email|unique:users,email',
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
            'phone'               => ['nullable','string','max:25','regex:/^[0-9+\-\s()]{7,25}$/'],
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
            'email'               => ['required','email', Rule::unique('users','email')->ignore($userId)],
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
            'username'            => ['nullable','string','max:60', Rule::unique('users','username')->ignore($userId)],
            'role'                => ['nullable', Rule::in(Role::pluck('name')->all())],
            'phone'               => ['nullable','string','max:25','regex:/^[0-9+\-\s()]{7,25}$/'],
        ];
    }
}
