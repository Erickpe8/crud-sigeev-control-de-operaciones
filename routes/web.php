<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\web\CentralPanelController;
use App\Http\Controllers\web\ProfileEditController;
use App\Http\Controllers\web\Dashboard\SuperAdminController;
use App\Http\Controllers\web\Dashboard\AdminController;
use App\Http\Controllers\web\Dashboard\UserController;
use App\Http\Controllers\Catalogs\GenderController;
use App\Http\Controllers\web\Dashboard\DocumentTypeController;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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

    // Panel central
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

        Route::get('/usuarios/{user}', [AdminController::class, 'show'])
            ->name('usuarios.show');
    });

    /**
     * Rutas para editar mi propio perfil (Admin y SuperAdmin)
     */
    Route::middleware(['web', 'auth', 'role:admin|superadmin'])
        ->prefix('profile')
        ->name('profile.')
        ->group(function () {
            // Editar perfil
            Route::get('edit/{user}', [ProfileEditController::class, 'edit'])
                ->name('edit');

            // Actualizar perfil
            Route::match(['POST', 'PUT'], 'update/{user}', [ProfileEditController::class, 'update'])
                ->name('update');

            // Actualizar contraseña
            Route::match(['POST', 'PUT'], 'update-password/{user}', [ProfileEditController::class, 'updatePassword'])
                ->name('update-password');

            // Cancelar edición
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

    /**
    * Rutas de los administradores y superadministradores para gestionar tipos de documento
    */

    Route::middleware(['auth'])->group(function () {
    // Vista (ya la tienes)
    Route::get('/panel/document-types', [DocumentTypeController::class, 'index'])
    ->name('panel.document-types.index')
    ->middleware(['role:admin|superadmin', 'permission:tipos_documento.ver']);

    // Listado JSON que usa el DataTable (ya lo sugerimos antes)
    Route::get('/panel/document-types/list', [DocumentTypeController::class, 'list'])
    ->name('dashboard.document-types.list')
    ->middleware(['role:admin|superadmin', 'permission:tipos_documento.ver']);

    // STORE que pide tu Blade por nombre: dashboard.document-types.store
    Route::post('/dashboard/document-types', [DocumentTypeController::class, 'store'])
    ->name('dashboard.document-types.store')
    ->middleware(['role:admin|superadmin', 'permission:tipos_documento.crear']);

    //UPDATE: tu Blade hace axios.put a /dashboard/document-types/{id}
    Route::put('/dashboard/document-types/{id}', [DocumentTypeController::class, 'update'])
    ->name('dashboard.document-types.update')
    ->middleware(['role:admin|superadmin', 'permission:tipos_documento.editar']);

    // (opcional) DELETE si tu UI lo invoca
    Route::delete('/dashboard/document-types/{id}', [DocumentTypeController::class, 'destroy'])
    ->name('dashboard.document-types.destroy')
    ->middleware(['role:admin|superadmin', 'permission:tipos_documento.eliminar']);
    });
});