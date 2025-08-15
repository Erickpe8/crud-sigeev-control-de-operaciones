<?php

use App\Http\Controllers\Api\Auth\PanelCreateUserController;
use App\Http\Controllers\UserRegistrationController;
use Illuminate\Support\Facades\Route;

// Registro público (general)
Route::post('/registrar', [UserRegistrationController::class, 'store']);


// Rutas para admin y superadmin: crear usuarios desde panel
Route::middleware(['auth', 'role:admin|superadmin'])->group(function () {
    Route::get('/panel/usuarios/crear', [PanelCreateUserController::class, 'create'])
        ->name('panel.usuarios.crear');

    Route::post('/panel/usuarios', [PanelCreateUserController::class, 'store'])
        ->name('panel.usuarios.store');
});
