<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Maneja el intento de login del usuario.
     */
    public function login(Request $request)
    {
        // Validamos el request con reglas claras
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Seguridad extra: evita session fixation

            $user = Auth::user();

            // Redirección dinámica según el rol
            if ($user->hasRole('super admin')) {
                return redirect()->route('dashboards.superadmin');
            } elseif ($user->hasRole('admin')) {
                return redirect()->route('dashboards.admin');
            } else {
                return redirect()->route('dashboards.user');
            }
        }

        // Si falla la autenticación
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ])->withInput(); // Mantiene el campo email escrito
    }

    /**
     * Cierra la sesión del usuario y destruye la sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();      // Invalida la sesión
        $request->session()->regenerateToken(); // Regenera el token CSRF

        return redirect('/login')->with('status', 'Sesión cerrada correctamente.');
    }
}
