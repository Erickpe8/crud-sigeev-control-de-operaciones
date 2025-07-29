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
            abort(403, 'No puedes editar al Super Admin.');
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(
            'first_name',
            'last_name',
            'email',
            'gender_id',
            'document_type_id',
            'user_type_id',
            'academic_program_id',
            'institution_id'
        ));

        return redirect()->route('dashboards.admin')->with('success', 'Usuario actualizado correctamente.');
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
