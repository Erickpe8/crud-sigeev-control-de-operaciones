<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\SuperAdminController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\UserController;

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
        // Puedes añadir más rutas para super admin aquí
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
