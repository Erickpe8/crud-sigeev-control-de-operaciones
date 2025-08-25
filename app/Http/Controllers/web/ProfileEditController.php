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

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Bloquear edición al superadmin (verifica el nombre exacto del rol)
            if ($user->hasRole('superadmin')) {
                return $request->expectsJson()
                    ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
                    : abort(403, 'No puedes editar al Super Admin.');
            }

            Log::info('profile.update IN', ['id' => $id, 'payload' => $request->all()]);

            // Validación: si no envías un campo, se ignora por completo (no valida ni se actualiza)
            $validated = $request->validate([
                'first_name'           => 'sometimes|string|max:100',
                'last_name'            => 'sometimes|string|max:100',
                'email'                => ['sometimes','email','max:255', Rule::unique('users','email')->ignore($user->id)],
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
            ]);

            // Convertir fecha solo si vino
            if ($request->filled('birthdate')) {
                $validated['birthdate'] = Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('Y-m-d');
            }

            // Actualizar solo lo validado
            $user->fill($validated);

            // Asociaciones condicionales (si el campo vino en la request)
            if ($request->has('academic_program_id')) {
                $user->academicProgram()->associate($request->input('academic_program_id') ?: null);
            }
            if ($request->has('institution_id')) {
                $user->institution()->associate($request->input('institution_id') ?: null);
            }

            $user->save();

            // Rol: solo si vino el campo; si viene vacío => limpia roles
            if ($request->has('role')) {
                $roleName = $request->input('role');
                if ($roleName) {
                    $user->syncRoles([$roleName]);
                } else {
                    $user->syncRoles([]);
                }
            }

            Log::info('profile.update OK', ['id' => $id]);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Perfil actualizado exitosamente']);
            }
            return redirect()->route('profile.edit', $user->id)->with('success', 'Perfil actualizado exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('profile.update 422', ['id' => $id, 'errors' => $e->errors()]);
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('profile.update 500', [
                'id'   => $id,
                'msg'  => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success'  => false,
                    'message'  => 'Error inesperado en el servidor',
                    'exception'=> config('app.debug') ? get_class($e) : null,
                    'error'    => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }
            return back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
    }

    public function cancelEdit()
    {
        return redirect()->route('profile.edit', auth()->id());
    }
}
