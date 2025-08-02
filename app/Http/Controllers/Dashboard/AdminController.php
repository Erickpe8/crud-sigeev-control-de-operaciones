<?php

namespace App\Http\Controllers\Dashboard;

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

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $genders = Gender::all();
        $documentTypes = DocumentType::all();
        $userTypes = UserType::all();
        $academicPrograms = AcademicProgram::all();
        $institutions = Institution::all();

        return view('dashboards.admin.admin', compact(
            'users',
            'genders',
            'documentTypes',
            'userTypes',
            'academicPrograms',
            'institutions'
        ));
    }

    public function edit(User $user)
    {
        if ($user->hasRole('super admin')) {
            abort(403, 'No puedes editar al Super Admin.');
        }

        $genders = Gender::all();
        $documentTypes = DocumentType::all();
        $userTypes = UserType::all();
        $academicPrograms = AcademicProgram::all();
        $institutions = Institution::all();

        return view('admin.users.edit', compact(
            'user',
            'genders',
            'documentTypes',
            'userTypes',
            'academicPrograms',
            'institutions'
        ));
    }

public function update(Request $request, User $user)
{
    if ($user->hasRole('super admin')) {
        return $request->expectsJson()
            ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
            : abort(403, 'No puedes editar al Super Admin.');
    }

    try {
        // Validar campos
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'gender_id' => 'nullable|exists:genders,id',
            'document_type_id' => 'nullable|exists:document_types,id',
            'user_type_id' => 'nullable|exists:user_types,id',
            'academic_program_id' => 'nullable|exists:academic_programs,id',
            'institution_id' => 'nullable|exists:institutions,id',
            'document_number' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'status' => 'nullable|boolean',
            'accepted_terms' => 'nullable|boolean',
        ]);

        // Asignación en bloque segura (sin password)
        $user->fill(collect($validatedData)->except(['password'])->toArray());

        // Defaults para campos opcionales si vienen vacíos
        $user->academic_program_id = $validatedData['academic_program_id'] ?? null;
        $user->institution_id = $validatedData['institution_id'] ?? null;
        $user->document_number = $validatedData['document_number'] ?? null;
        $user->company_name = $validatedData['company_name'] ?? null;
        $user->company_address = $validatedData['company_address'] ?? null;
        $user->birthdate = $validatedData['birthdate'] ?? null;
        $user->status = $validatedData['status'] ?? true;
        $user->accepted_terms = $validatedData['accepted_terms'] ?? false;

        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Usuario actualizado correctamente.',
                'user' => $user,
            ]);
        }

        return redirect()->route('dashboards.admin')->with('success', 'Usuario actualizado correctamente.');

    } catch (\Exception $e) {
        Log::error('Error al actualizar usuario: ' . $e->getMessage());

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Error interno del servidor.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return redirect()->back()->withErrors(['general' => 'Error al actualizar usuario.']);
    }
}


    public function destroy(User $user)
    {
        if ($user->hasRole('super admin')) {
            abort(403, 'No puedes eliminar al Super Admin.');
        }

        $user->delete();

        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}
