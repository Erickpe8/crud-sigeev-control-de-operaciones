<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador del panel central. Muestra al usuario los módulos
 * disponibles según sus permisos.
 */
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

        // Definición de módulos (permiso, título, descripción, ruta e ícono SVG)
        $modules = [
            [
                'key'         => 'dashboard',
                'title'       => 'Dashboard',
                'description' => 'Visión general del sistema y estadísticas clave.',
                'permission'  => 'dashboard.view',
                'route'       => 'dashboard.index',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18V3H3zm10 14H7v-2h6v2zm4-4H7v-2h10v2zm0-4H7V7h10v2z" /></svg>',
            ],
            [
                'key'         => 'users',
                'title'       => 'Usuarios',
                'description' => 'Gestiona usuarios, roles y permisos del sistema.',
                'permission'  => 'users.manage',
                'route'       => 'users.index',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 0-8 0 4 4 0 0 0 8 0Zm-6.75 8h5.5a3.75 3.75 0 0 1 3.75 3.75V20h-13v-1.25A3.75 3.75 0 0 1 9.25 15Z" /></svg>',
            ],
            [
                'key'         => 'roles',
                'title'       => 'Roles',
                'description' => 'Administra y asigna roles a los usuarios.',
                'permission'  => 'roles.manage',
                'route'       => 'roles.index',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.91 4.015a5 5 0 0 1 5.07.99l.02.018a5 5 0 0 1-.019 7.08l-6.388 6.388a3 3 0 0 1-4.243 0l-4.243-4.243a3 3 0 0 1 0-4.243l6.388-6.388a5 5 0 0 1 3.414-1.602Z" /></svg>',
            ],
            [
                'key'         => 'permissions',
                'title'       => 'Permisos',
                'description' => 'Crea y administra permisos del sistema.',
                'permission'  => 'permissions.manage',
                'route'       => 'permissions.index',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5.5 11.5h13M5.5 8h13M5.5 15h13M8 5.5v13" /></svg>',
            ],
            [
                'key'         => 'events',
                'title'       => 'Eventos',
                'description' => 'Administra los eventos y su programación.',
                'permission'  => 'events.index',
                'route'       => 'events.index',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15.75h7.5M5.25 9.75h13.5M9 2.25v4.5m6-4.5v4.5m-11.25 15V7.5a2.25 2.25 0 0 1 2.25-2.25h12a2.25 2.25 0 0 1 2.25 2.25v12.75a2.25 2.25 0 0 1-2.25 2.25h-12a2.25 2.25 0 0 1-2.25-2.25Z" /></svg>',
            ],
            [
                'key'         => 'speakers',
                'title'       => 'Speakers',
                'description' => 'Gestiona ponentes y su información de contacto.',
                'permission'  => 'speakers.index',
                'route'       => 'speakers.index',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 12a6 6 0 1 0-12 0 6 6 0 0 0 12 0Zm4.5 0A10.5 10.5 0 1 1 1.5 12a10.5 10.5 0 0 1 21 0Z" /></svg>',
            ],
        ];

        // Filtra los módulos según los permisos del usuario autenticado
        $availableModules = array_filter($modules, function (array $module) use ($user) {
            return empty($module['permission']) || $user->can($module['permission']);
        });

        return view('panel.index', [
            'modules' => $availableModules,
            'user'    => $user,
        ]);
    }
}
