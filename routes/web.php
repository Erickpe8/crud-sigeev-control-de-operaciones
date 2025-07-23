<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\SuperAdminController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas web para la aplicación.
| Estas rutas están asignadas al grupo de middleware "web".
|
*/

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de vistas de autenticación
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Ruta de términos y condiciones
Route::get('/terminosycondiciones', function () {
    return view('terminosycondiciones');
})->name('terminos');

// Acción de login
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

// Rutas protegidas por roles (Spatie)
Route::middleware('auth')->group(function () {
    Route::middleware('role:super admin')->get('/dashboard/superadmin', [SuperAdminController::class, 'index'])->name('dashboards.superadmin');
    Route::middleware('role:admin')->get('/dashboard/admin', [AdminController::class, 'index'])->name('dashboards.admin');
    Route::middleware('role:user')->get('/dashboard/user', [UserController::class, 'index'])->name('dashboards.user');
});

