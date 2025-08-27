<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Maneja el intento de login del usuario.
     */
    public function login(Request $request)
    {
        // Validación de credenciales
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if (Auth::attempt($credentials)) {
                // Seguridad extra: evita session fixation
                $request->session()->regenerate();

                // Redirigir siempre al panel central
                return redirect()->route('panel');
            }
        } catch (\RuntimeException $e) {
            // Ej.: "This password does not use the Bcrypt algorithm."
            Log::warning('auth.login.hash_mismatch', [
                'email' => $request->input('email'),
                'msg'   => $e->getMessage(),
            ]);

            return back()->withErrors([
                'password' => 'La contraseña almacenada no es válida para el algoritmo actual. Restablécela para continuar.',
            ])->withInput();
        } catch (\Throwable $e) {
            // Cualquier otro error inesperado → evita 500 y muestra mensaje claro
            Log::error('auth.login.unexpected', [
                'email' => $request->input('email'),
                'msg'   => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);

            return back()->withErrors([
                'email' => 'Ocurrió un error al validar tus credenciales. Intenta de nuevo o restablece tu contraseña.',
            ])->withInput();
        }

        // Si falla la autenticación (credenciales inválidas)
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ])->withInput();
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Sesión cerrada correctamente.');
    }
}
