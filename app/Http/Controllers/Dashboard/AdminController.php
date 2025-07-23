<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Obtiene todos los usuarios con sus roles relacionados
        $users = User::with('roles')->get();

        // Retorna la vista y le pasa los usuarios
        return view('dashboards.admin.admin', compact('users'));
    }

        public function edit(User $user)
    {
        // Validación para no permitir edición de super admin
        if ($user->hasRole('super admin')) {
            abort(403, 'No puedes editar al Super Admin.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->hasRole('super admin')) {
            abort(403);
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('first_name', 'last_name', 'email'));

        return redirect()->route('dashboards.admin')->with('success', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('super admin')) {
            abort(403);
        }

        $user->delete();

        return back()->with('success', 'Usuario eliminado');
    }

}
