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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProfileEditController extends Controller
{
    /**
     * Mostrar formulario de edición de perfil
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $genders          = Gender::all();
        $documentTypes    = DocumentType::all();
        $userTypes        = UserType::all();
        $roles            = Role::all();
        $academicPrograms = AcademicProgram::all();
        $institutions     = Institution::all();

        return view('auth.profile-edit', compact(
            'user','genders','documentTypes','userTypes','roles','academicPrograms','institutions'
        ));
    }

    /**
     * Actualizar perfil de usuario
     * - Permite que el Super Admin se edite a sí mismo
     * - Bloquea que otros editen a un Super Admin
     * - Soporta password opcional con confirmed
     */
    public function update(Request $request, User $user)
    {
        try {
            // ❗ Bloquear edición de Super Admin por terceros, permitir auto-edición
            if ($user->hasRole('superadmin') && $user->id !== $request->user()->id) {
                return $request->expectsJson()
                    ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
                    : abort(403, 'No puedes editar al Super Admin.');
            }

            // ✅ Validación (password opcional con confirmación)
            $validated = $request->validate([
                'first_name'           => 'sometimes|string|max:100',
                'last_name'            => 'sometimes|string|max:100',
                'email'                => [
                    'sometimes',
                    'email',
                    'max:255',
                    Rule::unique('users','email')->ignore($user->id),
                ],
                'birthdate'            => 'sometimes|date_format:d/m/Y',
                'document_number'      => 'sometimes|nullable|string|max:50',
                'gender_id'            => 'sometimes|nullable|exists:genders,id',
                'document_type_id'     => 'sometimes|nullable|exists:document_types,id',
                'user_type_id'         => 'sometimes|nullable|exists:user_types,id',
                'role'                 => 'sometimes|nullable|exists:roles,name',
                'academic_program_id'  => 'sometimes|nullable|exists:academic_programs,id',
                'institution_id'       => 'sometimes|nullable|exists:institutions,id',
                'company_name'         => 'sometimes|nullable|string|max:255',
                'company_address'      => 'sometimes|nullable|string|max:255',
                'phone'                => 'sometimes|nullable|string|max:20',
                // 🔐 Clave: password opcional + confirmed
                'password'             => 'sometimes|string|min:8|confirmed',

                // Opcional: foto (si la envías desde el form)
                'photo'                => 'sometimes|file|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            // Formateo de fecha si vino
            if ($request->filled('birthdate')) {
                $validated['birthdate'] = Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('Y-m-d');
            }

            // Manejo opcional de foto (si se envía)
            if ($request->hasFile('photo')) {
                // Guarda en storage/app/public/avatars
                $path = $request->file('photo')->store('avatars', 'public');
                $validated['photo_url'] = $path;
            }

            // Asignación segura (incluye password si vino; cast 'hashed' encripta automáticamente)
            $user->fill($validated);

            // Nulos controlados para relaciones opcionales cuando vengan vacías
            if ($request->has('academic_program_id')) {
                $user->academic_program_id = $request->input('academic_program_id') ?: null;
            }
            if ($request->has('institution_id')) {
                $user->institution_id = $request->input('institution_id') ?: null;
            }

            $user->save();

            // Rol opcional
            if ($request->has('role')) {
                $roleName = $request->input('role');
                $user->syncRoles($roleName ? [$roleName] : []);
            }

            return $request->expectsJson()
                ? response()->json(['success' => true, 'message' => 'Perfil actualizado exitosamente'])
                : redirect()->route('profile.edit', $user->id)->with('success', 'Perfil actualizado exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'errors' => $e->errors()], 422)
                : back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('profile.update 500', [
                'error' => $e->getMessage(),
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