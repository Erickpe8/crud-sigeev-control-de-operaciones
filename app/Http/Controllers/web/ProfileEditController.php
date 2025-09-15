<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use App\Models\DocumentType;
use App\Models\UserType;
use App\Models\AcademicProgram;
use App\Models\Institution;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ProfileEditController extends Controller
{
    public function edit(User $user)
    {
        $genders          = Gender::all();
        $documentTypes    = DocumentType::all();
        $userTypes        = UserType::all();
        $roles            = Role::all();
        $academicPrograms = AcademicProgram::all();
        $institutions     = Institution::all();

        return view('auth.profile-edit', compact(
            'user', 'genders', 'documentTypes', 'userTypes', 'roles', 'academicPrograms', 'institutions'
        ));
    }

    public function update(Request $request, User $user)
    {
        try {
            // Superadmin: sólo se edita a sí mismo
            if ($user->hasRole('superadmin') && $user->id !== $request->user()->id) {
                return $request->expectsJson()
                    ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
                    : abort(403, 'No puedes editar al Super Admin.');
            }

            // Validación
            $validated = $request->validate([
                'first_name'          => 'sometimes|string|max:100',
                'last_name'           => 'sometimes|string|max:100',
                'email'               => ['sometimes','email','max:255', Rule::unique('users','email')->ignore($user->id)],
                'birthdate'           => 'sometimes|date_format:Y-m-d|before_or_equal:today',
                'document_number'     => 'sometimes|string|max:50', // <-- no nullable
                'gender_id'           => 'sometimes|nullable|exists:genders,id',
                'document_type_id'    => 'sometimes|nullable|exists:document_types,id',
                'user_type_id'        => 'sometimes|nullable|exists:user_types,id',
                'role'                => 'sometimes|nullable|exists:roles,name',
                'academic_program_id' => 'sometimes|nullable|exists:academic_programs,id',
                'institution_id'      => 'sometimes|nullable|exists:institutions,id',
                'company_name'        => 'sometimes|nullable|string|max:255',
                'company_address'     => 'sometimes|nullable|string|max:255',
                'phone'               => 'sometimes|nullable|string|max:20',
                'password'            => [
                    'sometimes','nullable','confirmed','string','min:10','max:100',
                    'regex:/^(?=.*[a-z])(?=.*[!@#\?]).+$/',
                ],
                'photo'               => 'sometimes|file|mimes:jpg,jpeg,png,webp|max:2048',
                'remove_photo'        => 'sometimes|boolean',
            ]);

            // Normaliza birthdate si vino como string compatible
            if ($request->filled('birthdate')) {
                try { $validated['birthdate'] = Carbon::parse($request->birthdate)->format('Y-m-d'); } catch (\Exception $e) { /* ignore */ }
            }

            // Evitar sobrescribir NO NULOS con vacío/null
            $nonNullable = ['first_name','last_name','email','document_number'];
            foreach ($nonNullable as $k) {
                if (array_key_exists($k, $validated)) {
                    if (is_null($validated[$k]) || (is_string($validated[$k]) && trim($validated[$k]) === '')) {
                        unset($validated[$k]);
                    }
                }
            }

            // Manejo de foto
            $newRelativePath = null;
            $oldRelativePath = $user->profile_photo; // p.ej. avatars/user_2.jpg

            if ($request->boolean('remove_photo')) {
                $newRelativePath = null;
            }

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $image = Image::read($file->getPathname())->cover(300, 300);
                $ext      = $file->extension();
                $filename = "user_{$user->id}.{$ext}";
                $dir      = storage_path('app/public/avatars');
                File::ensureDirectoryExists($dir);
                $image->save($dir . DIRECTORY_SEPARATOR . $filename);
                $newRelativePath = "avatars/{$filename}";
            }

            // Extraer role
            $roleName = Arr::pull($validated, 'role', null);

            // Campos permitidos
            $allowed = [
                'first_name','last_name','email','phone','birthdate',
                'gender_id','document_type_id','document_number',
                'user_type_id','institution_id','academic_program_id',
                'company_name','company_address','profile_photo','password',
            ];

            DB::beginTransaction();

            // Foto a guardar
            if ($request->has('remove_photo')) { $validated['profile_photo'] = null; }
            if ($newRelativePath !== null)    { $validated['profile_photo'] = $newRelativePath; }

            $fillData = Arr::only($validated, $allowed);
            $user->fill($fillData);

            // Relaciones opcionales: null si viene vacío
            if ($request->has('academic_program_id')) {
                $user->academic_program_id = $request->input('academic_program_id') ?: null;
            }
            if ($request->has('institution_id')) {
                $user->institution_id = $request->input('institution_id') ?: null;
            }

            if ($user->isDirty()) { $user->save(); }

            if ($request->has('role')) { $roleName ? $user->syncRoles([$roleName]) : $user->syncRoles([]); }

            DB::commit();

            // Limpieza de archivos
            if ($newRelativePath && $oldRelativePath && $oldRelativePath !== $newRelativePath) {
                $oldPath = storage_path('app/public/' . $oldRelativePath);
                if (File::exists($oldPath)) { File::delete($oldPath); }
            }
            if ($request->boolean('remove_photo') && $oldRelativePath) {
                $oldPath = storage_path('app/public/' . $oldRelativePath);
                if (File::exists($oldPath)) { File::delete($oldPath); }
            }

            $freshUser = $user->fresh();
            return $request->expectsJson()
                ? response()->json([
                    'ok'      => true,
                    'message' => 'Perfil actualizado correctamente.',
                    'user'    => $freshUser->only([
                        'id','first_name','last_name','email','profile_photo','user_type_id',
                        'document_number','gender_id','document_type_id','institution_id',
                        'academic_program_id','company_name','company_address','phone','birthdate',
                    ]),
                ], 200)
                : redirect()->route('profile.edit', $user->id)->with('success', 'Perfil actualizado correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $request->expectsJson()
                ? response()->json(['errors' => $e->errors()], 422)
                : back()->withErrors($e->errors())->withInput();

        } catch (\Throwable $e) {
            DB::rollBack();
            $errorId = (string) Str::uuid();
            Log::error('profile.update 500', [
                'user_id'  => $user->id ?? null,
                'error_id' => $errorId,
                'error'    => $e->getMessage(),
                'file'     => $e->getFile(),
                'line'     => $e->getLine(),
            ]);

            return $request->expectsJson()
                ? response()->json([
                    'ok'        => false,
                    'message'   => 'Ocurrió un error inesperado.',
                    'code'      => 500,
                    'error_id'  => $errorId,
                    'exception' => config('app.debug') ? get_class($e) : null,
                    'error'     => config('app.debug') ? $e->getMessage() : null,
                ], 500)
                : back()->with('error', 'Ocurrió un error inesperado. ID:' . $errorId)->withInput();
        }
    }
}
