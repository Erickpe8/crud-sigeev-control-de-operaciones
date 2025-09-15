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
            // Superadmin: solo se edita a sí mismo
            if ($user->hasRole('superadmin') && $user->id !== $request->user()->id) {
                return $request->expectsJson()
                    ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
                    : abort(403, 'No puedes editar al Super Admin.');
            }

            // Validación con formatos correctos
            $validated = $request->validate([
                'first_name'          => 'sometimes|string|max:100',
                'last_name'           => 'sometimes|string|max:100',
                'email'               => ['sometimes','email','max:255', Rule::unique('users','email')->ignore($user->id)],
                'birthdate'           => 'sometimes|date_format:Y-m-d',
                'document_number'     => 'sometimes|nullable|string|max:50',
                'gender_id'           => 'sometimes|nullable|exists:genders,id',
                'document_type_id'    => 'sometimes|nullable|exists:document_types,id',
                'user_type_id'        => 'sometimes|nullable|exists:user_types,id',
                'role'                => 'sometimes|nullable|exists:roles,name',
                'academic_program_id' => 'sometimes|nullable|exists:academic_programs,id',
                'institution_id'      => 'sometimes|nullable|exists:institutions,id',
                'company_name'        => 'sometimes|nullable|string|max:255',
                'company_address'     => 'sometimes|nullable|string|max:255',
                'phone'               => 'sometimes|nullable|string|max:20',
                'password'            => 'sometimes|nullable|confirmed|min:8',
                'photo'               => 'sometimes|file|mimes:jpg,jpeg,png,webp|max:2048',
                'remove_photo'        => 'sometimes|boolean',
            ]);

            // Normaliza fecha a Y-m-d si viene como string
            if ($request->filled('birthdate')) {
                try {
                    $validated['birthdate'] = Carbon::parse($request->birthdate)->format('Y-m-d');
                } catch (\Exception $e) {
                    // ignorar si no se puede convertir, la validación ya falla
                }
            }

            // Manejo de foto: preparamos rutas
            $newRelativePath = null;
            $oldRelativePath = $user->profile_photo; // ej: avatars/user_2.jpg

            // Eliminar foto actual
            if ($request->boolean('remove_photo')) {
                $newRelativePath = null;
            }

            // Si viene una nueva foto procesarla
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

            // Extraer role para roles Spatie
            $roleName = Arr::pull($validated, 'role', null);

            // Campos permitidos para fill
            $allowed = [
                'first_name','last_name','email','phone','birthdate',
                'gender_id','document_type_id','document_number',
                'user_type_id','institution_id','academic_program_id',
                'company_name','company_address','profile_photo','password',
            ];

            DB::beginTransaction();

            // Ajustar valor de foto a guardar
            if ($request->has('remove_photo')) {
                $validated['profile_photo'] = null;
            }
            if ($newRelativePath !== null) {
                $validated['profile_photo'] = $newRelativePath;
            }

            // Asignar solo campos permitidos y solo si han cambiado
            $fillData = Arr::only($validated, $allowed);
            // Llenar datos
            $user->fill($fillData);

            // Relaciones opcionales: asegurar null cuando vienen vacías
            if ($request->has('academic_program_id')) {
                $user->academic_program_id = $request->input('academic_program_id') ?: null;
            }
            if ($request->has('institution_id')) {
                $user->institution_id = $request->input('institution_id') ?: null;
            }

            // Guardar solo si hay cambios (dirty)
            if ($user->isDirty()) {
                $user->save();
            }

            // Sincronizar roles si viene alguno
            if ($request->has('role')) {
                $roleName ? $user->syncRoles([$roleName]) : $user->syncRoles([]);
            }

            DB::commit();

            // Limpiar archivos antiguos si hay una nueva foto
            if ($newRelativePath && $oldRelativePath && $oldRelativePath !== $newRelativePath) {
                $oldPath = storage_path('app/public/' . $oldRelativePath);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            // Eliminar la foto si se solicitó quitarla
            if ($request->boolean('remove_photo') && $oldRelativePath) {
                $oldPath = storage_path('app/public/' . $oldRelativePath);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $freshUser = $user->fresh();
            // Devuelve una respuesta JSON coherente con Axios
            return $request->expectsJson()
                ? response()->json([
                    'ok'      => true,
                    'message' => 'Perfil actualizado correctamente.',
                    'user'    => $freshUser->only([
                        'id', 'first_name', 'last_name', 'email', 'profile_photo', 'user_type_id',
                        'document_number', 'gender_id', 'document_type_id', 'institution_id',
                        'academic_program_id', 'company_name', 'company_address', 'phone', 'birthdate',
                    ]),
                ], 200)
                : redirect()->route('profile.edit', $user->id)->with('success', 'Perfil actualizado correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Respuesta para errores de validación
            return $request->expectsJson()
                ? response()->json([
                    'errors' => $e->errors(),
                ], 422)
                : back()->withErrors($e->errors())->withInput();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('profile.update 500', [
                'user_id' => $user->id ?? null,
                'error'   => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return $request->expectsJson()
                ? response()->json([
                    'ok'      => false,
                    'message' => 'Ocurrió un error inesperado.',
                    'exception' => config('app.debug') ? get_class($e) : null,
                    'error'     => config('app.debug') ? $e->getMessage() : null,
                ], 500)
                : back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
    }
}
