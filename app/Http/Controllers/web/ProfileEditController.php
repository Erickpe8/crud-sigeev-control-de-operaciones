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

class ProfileEditController extends Controller
{
    public function edit($id)
    {
        // Obtener el usuario a editar
        $user = User::findOrFail($id);

        // Obtener las colecciones necesarias
        $genders = Gender::all();
        $documentTypes = DocumentType::all();
        $userTypes = UserType::all();
        $roles = Role::all();
        $academicPrograms = AcademicProgram::all();
        $institutions = Institution::all();

        return view('auth.profile-edit', compact(
            'user', 'genders', 'documentTypes', 'userTypes', 'roles', 'academicPrograms', 'institutions'
        ));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validación de los campos
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'birthdate' => 'nullable|date',
            'document_number' => 'nullable|string|max:50',
            'gender_id' => 'nullable|exists:genders,id',
            'document_type_id' => 'nullable|exists:document_types,id',
            'user_type_id' => 'nullable|exists:user_types,id',
            'role' => 'required|exists:roles,name',
            'academic_program_id' => 'nullable|exists:academic_programs,id',
            'institution_id' => 'nullable|exists:institutions,id',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20', // Campo teléfono
        ]);

        // Verificar si el usuario tiene el rol de superadmin
        if ($user->hasRole('superadmin')) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
                : abort(403, 'No puedes editar al Super Admin.');
        }

        // Rellenar los campos básicos del usuario
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'document_number' => $request->document_number,
            'gender_id' => $request->gender_id,
            'document_type_id' => $request->document_type_id,
            'user_type_id' => $request->user_type_id,
            'phone' => $request->phone, // Actualizar teléfono
        ]);

        // Actualizar el rol del usuario (usando Spatie)
        $user->syncRoles($request->role);

        // Actualizar campos adicionales dinámicos según el tipo de usuario
        if ($request->has('academic_program_id')) {
            $user->academicProgram()->associate($request->academic_program_id);
        }

        if ($request->has('institution_id')) {
            $user->institution()->associate($request->institution_id);
        }

        if ($request->has('company_name')) {
            $user->company_name = $request->company_name;
        }

        if ($request->has('company_address')) {
            $user->company_address = $request->company_address;
        }

        // Convertir la fecha si es necesario
        if ($request->birthdate && $request->birthdate !== $user->birthdate) {
            $user->birthdate = Carbon::parse($request->birthdate)->format('Y-m-d');
        }

        // Guardar cambios en el usuario
        $user->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('profile.edit', $user)->with('success', 'Perfil actualizado exitosamente');
    }

    public function cancelEdit()
    {
        // Redirigir a la vista de perfil si se cancela la edición
        return redirect()->route('profile.edit', auth()->user()->id);
    }
}
