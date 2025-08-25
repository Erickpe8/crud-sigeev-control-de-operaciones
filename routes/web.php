<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\web\CentralPanelController;
use App\Http\Controllers\web\ProfileEditController;
use App\Http\Controllers\web\Dashboard\SuperAdminController;
use App\Http\Controllers\web\Dashboard\AdminController;
use App\Http\Controllers\web\Dashboard\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página de términos (pública)
Route::view('/terminosycondiciones', 'terminosycondiciones')->name('terminos');

/**
 * Invitados (no autenticados)
 */
Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect()->route('login'))->name('root');

    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
});

/**
 * Autenticados
 */
Route::middleware('auth')->group(function () {

    // Si alguien intenta ir a / o /home, lo enviamos al panel
    Route::get('/home', fn () => redirect()->route('panel'))->name('home');
    Route::get('/', fn () => redirect()->route('panel'))->withoutMiddleware('guest');

    // Panel central (nuevo)
    Route::get('/panel', [CentralPanelController::class, 'index'])->name('panel');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    /**
     * Rutas de Super Admin
     */
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/dashboard/superadmin', [SuperAdminController::class, 'index'])
            ->name('dashboards.superadmin');

        Route::put('/superadmin/usuarios/{user}', [SuperAdminController::class, 'update'])
            ->name('superadmin.usuarios.update');

        Route::delete('/superadmin/usuarios/{user}', [SuperAdminController::class, 'destroy'])
            ->name('superadmin.usuarios.destroy');

        Route::get('/superadmin/usuarios/{user}', [SuperAdminController::class, 'show'])
            ->name('superadmin.usuarios.show');
    });

    /**
     * Rutas de Admin
     */
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [AdminController::class, 'index'])
            ->name('dashboards.admin');

        Route::put('/usuarios/{user}', [AdminController::class, 'update'])
            ->name('usuarios.update');

        Route::delete('/usuarios/{user}', [AdminController::class, 'destroy'])
            ->name('usuarios.destroy');

        Route::get('/usuarios/{user}', [UserController::class, 'show'])
            ->name('usuarios.show');
    });

    /**
     * Rutas para editar mi propio perfil (Admin y SuperAdmin)
     */


    Route::middleware(['auth', 'role:admin|superadmin'])
        ->prefix('profile')
        ->name('profile.')
        ->group(function () {

            // Ruta para editar el perfil (recibiendo el usuario con binding)
            Route::get('edit/{user}', [ProfileEditController::class, 'edit'])
                ->name('edit');

            // Ruta para actualizar la información del perfil (recibiendo el usuario con binding)
            Route::put('update/{user}', [ProfileEditController::class, 'update'])
                ->name('update');

            // Ruta para cancelar la edición y redirigir al perfil
            Route::get('cancel', [ProfileEditController::class, 'cancelEdit'])
                ->name('cancel');
        });

    /**
     * Rutas de Usuario estándar
     */
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard/user', [UserController::class, 'index'])
            ->name('dashboards.user');
    });
});
