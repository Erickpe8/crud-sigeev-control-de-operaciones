<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CentralPanelController extends Controller
{
    /**
     * Muestra el panel central.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Verificamos si el usuario tiene rol 'admin' o 'superadmin'
        if (!($user->hasRole('admin') || $user->hasRole('superadmin'))) {
            return redirect()->route('home')->with('error', 'No tienes acceso a este panel.');
        }

        // Definición de módulos (solo Dashboard y Crear Nuevos Usuarios)
        $modules = [
            [
                'key'         => 'dashboard',
                'title'       => 'Dashboard',
                'description' => 'Visión general del sistema y estadísticas clave.',
                'permission'  => 'dashboard.view',
                'roles'       => ['superadmin'],
                'route'       => 'dashboards.superadmin',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18V3H3zm10 14H7v-2h6v2zm4-4H7v-2h10v2zm0-4H7V7h10v2z" /></svg>',
            ],
            [
                'key'         => 'create_users',
                'title'       => 'Crear Nuevos Usuarios',
                'description' => 'Formulario para crear nuevos usuarios en el sistema.',
                'permission'  => 'users.create',
                'roles'       => ['superadmin'],
                'route'       => 'panel.usuarios.crear',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" /></svg>',
            ],
            [
                'key'         => 'create_users',
                'title'       => 'Crear Nuevos Usuarios',
                'description' => 'Formulario para crear nuevos usuarios en el sistema.',
                'permission'  => 'users.create',
                'roles'       => ['admin'],
                'route'       => 'panel.usuarios.crear',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" /></svg>',
            ],
        ];

        // Filtra los módulos según los permisos y roles del usuario autenticado
        $availableModules = array_filter($modules, function (array $module) use ($user) {
            return empty($module['roles']) || in_array($user->getRoleNames()->first(), $module['roles']);
        });

        return view('panel.index', [
            'modules' => $availableModules,
            'user'    => $user,
        ]);
    }
}
