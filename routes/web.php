<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\web\Dashboard\SuperAdminController;
use App\Http\Controllers\web\Dashboard\AdminController;
use App\Http\Controllers\web\Dashboard\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::view('/', 'welcome');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/terminosycondiciones', 'terminosycondiciones')->name('terminos');

// Autenticación
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

// Cierre de sesión
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Super Admin
    Route::middleware('role:super admin')->group(function () {
        Route::get('/dashboard/superadmin', [SuperAdminController::class, 'index'])
            ->name('dashboards.superadmin');

    // Ruta para actualizar usuarios (EDITAR)
    Route::put('/superadmin/usuarios/{user}', [SuperAdminController::class, 'update'])
        ->name('superadmin.usuarios.update');

    // Ruta para eliminar usuarios (ELIMINAR)
    Route::delete('/superadmin/usuarios/{user}', [SuperAdminController::class, 'destroy'])
        ->name('superadmin.usuarios.destroy');

    // Ruta para mostrar un usuario específico (GET)
    Route::get('/superadmin/usuarios/{user}', [SuperAdminController::class, 'show'])
        ->name('superadmin.usuarios.show');
    });


    // Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [AdminController::class, 'index'])
            ->name('dashboards.admin');

        // Ruta para actualizar usuarios (EDITAR)
        Route::put('/usuarios/{user}', [AdminController::class, 'update'])
            ->name('usuarios.update');

        // Ruta para eliminar usuarios (ELIMINAR)
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])
            ->name('usuarios.destroy');

        // Ruta para mostrar un usuario específico (GET)
        Route::get('/usuarios/{user}', [UserController::class, 'show'])
            ->name('usuarios.show');
    });

    // Usuario estándar
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard/user', [UserController::class, 'index'])
            ->name('dashboards.user');
    });
});
