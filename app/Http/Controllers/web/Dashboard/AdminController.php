<?php

namespace App\Http\Controllers\web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use App\Models\DocumentType;
use App\Models\UserType;
use App\Models\AcademicProgram;
use App\Models\Institution;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Listado para DataTable (cliente).
     * Sin paginación del backend. SIN authorize() aquí para no dar 403 en GET.
     */
    public function index(Request $request)
    {
        // Columnas deseadas (tomaremos solo las que existan)
        $desired = [
            'id','first_name','last_name','email','document_number','phone',
            'gender_id','document_type_id','user_type_id',
            'academic_program_id','institution_id','company_name','company_address','birthdate',
        ];
        $select = $this->selectExisting('users', $desired);

        // Si estás en debug y algo no existe, lo registramos (no rompemos)
        if (config('app.debug') && count($select) !== count($desired)) {
            $missing = array_values(array_diff($desired, $select));
            Log::warning('ADMIN.index: columnas faltantes en users', ['missing' => $missing]);
        }

        $users = User::query()
            ->with('roles') // ya lo usabas antes
            ->select($select ?: ['id','first_name','last_name','email']) // fallback mínimo
            ->orderBy('id', 'asc')
            ->limit(10000)
            ->get();

        // Lookups seguros (no rompen si faltan tablas/columnas)
        [$documentTypes, $userTypes] = $this->safeLookups();
        $genders          = $this->safeSelect('genders', ['id','name']);
        $academicPrograms = $this->safeSelect('academic_programs', ['id','name']);
        $institutions     = $this->safeSelect('institutions', ['id','name']);

        return view('dashboards.admin.admin', compact(
            'users','genders','documentTypes','userTypes','academicPrograms','institutions'
        ));
    }

    /**
     * Detalle para modal de edición (SIEMPRE JSON).
     */
    public function show(User $user)
    {
        $auth = auth()->user();

        // Política inline: nadie ve a un superadmin salvo él mismo o otro superadmin
        if ($user->hasRole('superadmin') && $auth->id !== $user->id && !$auth->hasRole('superadmin')) {
            abort(403, 'No autorizado a ver un superadmin.');
        }

        return response()->json([
            'user' => [
                'id'              => $user->id,
                'first_name'      => $user->first_name,
                'last_name'       => $user->last_name,
                'email'           => $user->email,
                'document_number' => $user->document_number,
                'phone'           => $user->phone,
                'user_type_id'    => $user->user_type_id,
                'gender_id'       => $user->gender_id ?? null,
                'document_type_id'=> $user->document_type_id ?? null,
                'academic_program_id' => $user->academic_program_id ?? null,
                'institution_id'  => $user->institution_id ?? null,
                'company_name'    => $user->company_name ?? null,
                'company_address' => $user->company_address ?? null,
                'birthdate'       => $user->birthdate ?? null,
            ],
            'roles'        => $user->getRoleNames(),
            'permissions'  => $user->getPermissionNames(),
        ]);
    }

    /**
     * Actualización con validación y reglas de rol inline (sin Policies).
     */
    public function update(Request $request, User $user)
    {
        $auth = $request->user();

        // Debe ser admin o superadmin
        if (!$auth || !$auth->hasAnyRole(['admin','superadmin'])) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No autorizado.'], 403)
                : abort(403, 'No autorizado.');
        }

        // Nadie edita a un superadmin salvo él mismo
        if ($user->hasRole('superadmin') && $auth->id !== $user->id) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
                : abort(403, 'No puedes editar al Super Admin.');
        }

        // Normalización
        $request->merge([
            'email'           => trim(mb_strtolower((string) $request->input('email'))),
            'document_number' => trim((string) $request->input('document_number')),
            'phone'           => preg_replace('/\s+/', '', trim((string) $request->input('phone', ''))) ?: null,
        ]);
        foreach (['gender_id','document_type_id','user_type_id','academic_program_id','institution_id'] as $k) {
            if ($request->has($k) && $request->input($k) === '') $request->merge([$k => null]);
        }

        // Validación
        $data = $request->validate([
            'first_name'          => ['required','string','max:100'],
            'last_name'           => ['required','string','max:100'],
            'email'               => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'phone'               => ['nullable','string','max:25','regex:/^[0-9+\-()]{7,25}$/'],
            'document_type_id'    => ['nullable','exists:document_types,id'],
            'document_number'     => ['nullable','string','max:50', Rule::unique('users','document_number')->ignore($user->id)],
            'gender_id'           => ['nullable','exists:genders,id'],
            'user_type_id'        => ['required','integer','exists:user_types,id'],
            'birthdate'           => ['nullable','date','before_or_equal:today'],
            'academic_program_id' => ['nullable','integer','exists:academic_programs,id'],
            'institution_id'      => ['nullable','integer','exists:institutions,id'],
            'company_name'        => ['nullable','string','max:255'],
            'company_address'     => ['nullable','string','max:255'],
            'status'              => ['nullable','boolean'],
            'accepted_terms'      => ['nullable','boolean'],
        ]);

        if (array_key_exists('birthdate', $data)) {
            $data['birthdate'] = $this->parseBirthdate($data['birthdate']);
        }
        foreach (['academic_program_id','institution_id','company_name','company_address','document_number'] as $k) {
            if (array_key_exists($k, $data) && ($data[$k] === '' || $data[$k] === null)) $data[$k] = null;
        }

        $debug = config('app.debug') && $request->boolean('debug');
        if ($debug) {
            Log::debug('ADMIN.update payload normalizado', ['payload' => $data, 'user_id' => $user->id]);
            DB::enableQueryLog();
        }

        try {
            $user->fill(collect($data)->except([
                'academic_program_id','institution_id','company_name','company_address','password'
            ])->toArray());

            // Solo forzamos secundarios si esas columnas existen en users
            $secondary = [];
            foreach (['academic_program_id','institution_id','company_name','company_address'] as $k) {
                if ($this->columnExists('users', $k)) {
                    $secondary[$k] = $data[$k] ?? null;
                }
            }
            if ($secondary) $user->forceFill($secondary);

            $dirtyBefore = $user->getDirty();
            $user->save();

            if ($debug) {
                Log::debug('ADMIN.update dirty', ['dirty' => $dirtyBefore]);
                Log::debug('ADMIN.update queries', ['queries' => DB::getQueryLog()]);
            }

            return response()->json([
                'message' => 'Usuario actualizado correctamente.',
                'user'    => $user->fresh('roles')
            ], 200);

        } catch (QueryException $e) {
            $msg = 'No se pudo actualizar: campo único duplicado.';
            if (str_contains($e->getMessage(), 'users_email_unique')) $msg = 'El correo ya está registrado.';
            elseif (str_contains($e->getMessage(), 'users_document_number_unique')) $msg = 'El número de documento ya está registrado.';

            Log::warning('Violación de unicidad al actualizar (ADMIN)', ['user_id' => $user->id, 'err' => $e->getMessage()]);
            return response()->json(['message' => $msg], 422);

        } catch (\Throwable $e) {
            Log::error('Error al actualizar usuario (ADMIN)', ['user_id' => $user->id, 'err' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno del servidor.'], 500);
        }
    }

    /**
     * Eliminación con reglas inline (sin Policies).
     */
    public function destroy(User $user)
    {
        $auth = auth()->user();

        if (!$auth || !$auth->hasAnyRole(['admin','superadmin'])) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        if ($auth->id === $user->id) {
            return response()->json(['message' => 'No puedes eliminar tu propio usuario.'], 422);
        }

        if ($user->hasRole('superadmin'))  {
            return response()->json(['message' => 'No puedes eliminar al Super Admin.'], 403);
        }

        try {
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado correctamente.'], 200);
        } catch (\Throwable $e) {
            Log::error('Error al eliminar usuario (ADMIN)', ['user_id' => $user->id, 'msg' => $e->getMessage()]);
            return response()->json(['message' => 'No se pudo eliminar el usuario.'], 500);
        }
    }

    /* ---------- Helpers seguros ---------- */

    /** Devuelve solo las columnas existentes de $candidates para $table */
    private function selectExisting(string $table, array $candidates): array
    {
        try {
            if (!Schema::hasTable($table)) return [];
            $existing = Schema::getColumnListing($table);
            return array_values(array_intersect($candidates, $existing));
        } catch (\Throwable $e) {
            Log::warning('selectExisting falló', ['table' => $table, 'err' => $e->getMessage()]);
            return [];
        }
    }

    /** ¿Existe la columna? */
    private function columnExists(string $table, string $col): bool
    {
        try {
            return Schema::hasTable($table) && Schema::hasColumn($table, $col);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /** Lookups seguros: no rompen si faltan tablas/columnas */
    private function safeLookups(): array
    {
        $documentTypes = collect();
        $userTypes     = collect();

        try {
            if (Schema::hasTable('document_types')) {
                $docCol = $this->pickNameColumnSafe('document_types', ['name','type','title','label','description','descripcion']);
                if ($docCol) $documentTypes = DocumentType::select('id', "$docCol as type")->get();
            }
        } catch (\Throwable $e) { Log::warning('safeLookups document_types', ['err' => $e->getMessage()]); }

        try {
            if (Schema::hasTable('user_types')) {
                $usrCol = $this->pickNameColumnSafe('user_types', ['name','type','title','label','description','descripcion']);
                if ($usrCol) $userTypes = UserType::select('id', "$usrCol as name")->get();
            }
        } catch (\Throwable $e) { Log::warning('safeLookups user_types', ['err' => $e->getMessage()]); }

        return [$documentTypes, $userTypes];
    }

    private function safeSelect(string $table, array $cols)
    {
        try {
            if (!Schema::hasTable($table)) return collect();
            $existing = Schema::getColumnListing($table);
            foreach ($cols as $c) if (!in_array($c, $existing, true)) return collect();

            return match ($table) {
                'genders'            => Gender::select($cols)->get(),
                'academic_programs'  => AcademicProgram::select($cols)->get(),
                'institutions'       => Institution::select($cols)->get(),
                default              => collect(),
            };
        } catch (\Throwable $e) {
            Log::warning('safeSelect falló', ['table' => $table, 'err' => $e->getMessage()]);
            return collect();
        }
    }

    private function pickNameColumnSafe(string $table, array $candidates): ?string
    {
        try {
            if (!Schema::hasTable($table)) return null;
            $existing = Schema::getColumnListing($table);
            foreach ($candidates as $col) if (in_array($col, $existing, true)) return $col;
        } catch (\Throwable $e) {
            Log::warning('pickNameColumnSafe falló', ['table' => $table, 'err' => $e->getMessage()]);
        }
        return null;
    }

    private function parseBirthdate($input): ?string
    {
        if (!$input) return null;
        if ($input instanceof \DateTimeInterface) return Carbon::instance($input)->format('Y-m-d');
        $str = (string) $input;
        foreach (['d/m/Y','Y-m-d','m/d/Y'] as $fmt) {
            try { return Carbon::createFromFormat($fmt, $str)->format('Y-m-d'); } catch (\Throwable $e) {}
        }
        try { return Carbon::parse($str)->format('Y-m-d'); } catch (\Throwable $e) { return null; }
    }
}