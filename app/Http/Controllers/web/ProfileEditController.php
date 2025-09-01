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
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;

class ProfileEditController extends Controller
{
    /**
     * Mostrar formulario de edición de perfil
     */
    public function edit(User $user) // ← route model binding
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

    /**
     * Actualizar perfil de usuario
     * - Superadmin solo se edita a sí mismo
     * - Password opcional (confirmed)
     * - Foto Intervention 300x300 guardada en storage/app/public/avatars/user_{id}.ext
     */
    public function update(Request $request, User $user)
    {
        try {
            // 0) Política Superadmin
            if ($user->hasRole('superadmin') && $user->id !== $request->user()->id) {
                return $request->expectsJson()
                    ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
                    : abort(403, 'No puedes editar al Super Admin.');
            }

            // 1) Validación
            $validated = $request->validate([
                'first_name'           => 'sometimes|string|max:100',
                'last_name'            => 'sometimes|string|max:100',
                'email'                => ['sometimes','email','max:255', Rule::unique('users','email')->ignore($user->id)],
                'birthdate'            => 'sometimes|date_format:d/m/Y',
                'document_number'      => 'sometimes|nullable|string|max:50',
                'gender_id'            => 'sometimes|nullable|exists:genders,id',
                'document_type_id'     => 'sometimes|nullable|exists:document_types,id',
                'user_type_id'         => 'sometimes|nullable|exists:user_types,id',
                'role'                 => 'sometimes|nullable|exists:roles,name', // NO es columna en users
                'academic_program_id'  => 'sometimes|nullable|exists:academic_programs,id',
                'institution_id'       => 'sometimes|nullable|exists:institutions,id',
                'company_name'         => 'sometimes|nullable|string|max:255',
                'company_address'      => 'sometimes|nullable|string|max:255',
                'phone'                => 'sometimes|nullable|string|max:20',
                'password'             => 'sometimes|string|min:8|confirmed',
                'photo'                => 'sometimes|file|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            // 2) Normalizar fecha si llegó
            if ($request->filled('birthdate')) {
                $validated['birthdate'] = Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('Y-m-d');
            }

            // 3) Foto (opcional) con compatibilidad Intervention v2/v3
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $img  = Image::read($file->getRealPath());
                if (method_exists($img, 'orient')) {
                    $img->orient();
                } elseif (method_exists($img, 'orientate')) {
                    $img->orientate();
                }
                $img->cover(300, 300);

                $ext      = $file->extension();
                $filename = "user_{$user->id}.{$ext}";
                $path     = "avatars/{$filename}"; // ruta relativa (sin 'storage/')

                $img->save(storage_path("app/public/{$path}"));
                $validated['photo_url'] = $path;
            }

            // 4) Quitar 'role' del fill para no intentar guardarlo en users
            $roleName = Arr::pull($validated, 'role', null);

            // 5) Whitelist para fill (evita MassAssignment/columna inexistente)
            $allowed = [
                'first_name','last_name','email','phone','birthdate',
                'gender_id','document_type_id','document_number',
                'user_type_id','institution_id','academic_program_id',
                'company_name','company_address',
                'photo_url','password', // cast 'hashed' en el modelo la encripta
            ];
            $user->fill(Arr::only($validated, $allowed));

            // 6) Relaciones opcionales a null si vienen vacías
            if ($request->has('academic_program_id')) {
                $user->academic_program_id = $request->input('academic_program_id') ?: null;
            }
            if ($request->has('institution_id')) {
                $user->institution_id = $request->input('institution_id') ?: null;
            }

            $user->save();

            // 7) Aplicar rol si llegó (Spatie)
            if ($request->has('role')) {
                $roleName ? $user->syncRoles([$roleName]) : $user->syncRoles([]);
            }

            return $request->expectsJson()
                ? response()->json([
                    'success' => true,
                    'message' => 'Perfil actualizado exitosamente',
                    'user'    => $user->fresh(),
                ], 200)
                : redirect()->route('profile.edit', $user->id)->with('success', 'Perfil actualizado exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // 422: validaciones para tu UX en frontend
            return $request->expectsJson()
                ? response()->json(['success' => false, 'errors' => $e->errors()], 422)
                : back()->withErrors($e->errors())->withInput();

        } catch (\Throwable $e) {
            // 500: log útil para depurar
            Log::error('profile.update 500', [
                'user_id' => $user->id ?? null,
                'error'   => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return $request->expectsJson()
                ? response()->json([
                    'success'   => false,
                    'message'   => 'Error inesperado en el servidor',
                    'exception' => config('app.debug') ? get_class($e) : null,
                    'error'     => config('app.debug') ? $e->getMessage() : null,
                ], 500)
                : back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
    }
}
