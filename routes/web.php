<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Rutas de autenticación

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Ruta de terminos y condiciones
Route::get('/terminosycondiciones', function () {
    return view('terminosycondiciones');
})->name('terminos');


//Spatie Permission Routes //Rutas creadas para trabajar más adelante con los roles y permisos de los usuarios
Route::middleware(['auth', 'role:super admin'])->group(function () {
    Route::get('/dashboard/superadmin', [SuperAdminController::class, 'index']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'index']);
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard/user', [UserController::class, 'index']);
});

