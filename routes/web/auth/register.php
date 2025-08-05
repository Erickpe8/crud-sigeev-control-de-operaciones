<?php

use App\Http\Controllers\Api\Auth\AdminCreateUserController;
use App\Http\Controllers\UserRegistrationController;
use Illuminate\Support\Facades\Route;

// Registro público (general)
Route::post('/registrar', [UserRegistrationController::class, 'store']);

// Rutas para admin: crear usuarios desde panel
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/usuarios/crear', [AdminCreateUserController::class, 'create'])->name('admin.usuarios.crear');
    Route::post('/admin/usuarios', [AdminCreateUserController::class, 'store'])->name('admin.usuarios.store');
});
