<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CentralPanelController extends Controller
{
    /**
     * Panel central (admin/superadmin).
     * Muestra tarjetas solo de módulos que NO son "sidebar_only".
     * El sidebar se construye con todos los módulos visibles (incluye el panel principal).
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Seguridad básica: solo admin/superadmin
        if (!$user || !$user->hasAnyRole(['admin', 'superadmin'])) {
            return redirect()->route('home')->with('error', 'No tienes acceso a este panel.');
        }

        // Catálogo -> visibles según rol/permisos
        $catalog  = $this->modulesCatalog();
        $visible  = array_values(array_filter($catalog, fn ($m) => $this->canSee($m, $user)));

        // Sidebar: todos los visibles (incluye el panel principal)
        $sidebarItems = self::toSidebarItems($visible);

        // Tarjetas: visibles que NO son "solo sidebar"
        $cardModules = array_values(array_filter($visible, fn ($m) => empty($m['sidebar_only'])));

        return view('panel.index', [
            'user'         => $user,
            'brand'        => 'Panel Central',
            'title'        => 'Panel Central',
            'modules'      => $cardModules,   // <- solo tarjetas que no son sidebar_only
            'sidebarItems' => $sidebarItems,  // <- incluye el panel principal
        ]);
    }

    /**
     * Catálogo de módulos.
     * - 'sidebar_only' => true  => solo aparece en el sidebar (no en tarjetas).
     * - 'roles' / 'permission' => controlan visibilidad (Spatie).
     */
    private function modulesCatalog(): array
    {
        return [
            // === SOLO SIDEBAR: Panel principal ===
            [
                'key'         => 'panel_main',
                'title'       => 'Panel principal',
                'description' => 'Resumen general y tarjetas del sistema.',
                'permission'  => null,
                'roles'       => ['admin', 'superadmin'],
                'route'       => 'panel',
                'icon'        => '<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21"><path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/></svg>',
                'active'      => ['panel', 'panel.*'],
                'sidebar_only'=> true, // <- clave para no mostrarlo como tarjeta
            ],

            // === SUPERADMIN ===
            [
                'key'         => 'dashboard_super',
                'title'       => 'Gestiona Usuarios',
                'description' => 'Gestiona, crea, edita y elimina usuarios del sistema.',
                'permission'  => 'dashboard.view',
                'roles'       => ['superadmin'],
                'route'       => 'dashboards.superadmin',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 640 512"><path fill="#E10600" d="M224 0a128 128 0 1 1 0 256a128 128 0 1 1 0-256m-45.7 304h91.4c11.8 0 23.4 1.2 34.5 3.3c-2.1 18.5 7.4 35.6 21.8 44.8c-16.6 10.6-26.7 31.6-20 53.3c4 12.9 9.4 25.5 16.4 37.6s15.2 23.1 24.4 33c15.7 16.9 39.6 18.4 57.2 8.7v.9c0 9.2 2.7 18.5 7.9 26.3l-382.2.1C13.3 512 0 498.7 0 482.3C0 383.8 79.8 304 178.3 304M436 218.2c0-7 4.5-13.3 11.3-14.8c10.5-2.4 21.5-3.7 32.7-3.7s22.2 1.3 32.7 3.7c6.8 1.5 11.3 7.8 11.3 14.8v30.6c7.9 3.4 15.4 7.7 22.3 12.8l24.9-14.3c6.1-3.5 13.7-2.7 18.5 2.4c7.6 8.1 14.3 17.2 20.1 27.2s10.3 20.4 13.5 31c2.1 6.7-1.1 13.7-7.2 17.2l-25 14.4c.4 4 .7 8.1.7 12.3s-.2 8.2-.7 12.3l25 14.4c6.1 3.5 9.2 10.5 7.2 17.2c-3.3 10.6-7.8 21-13.5 31s-12.5 19.1-20.1 27.2c-4.8 5.1-12.5 5.9-18.5 2.4L546.3 442c-6.9 5.1-14.3 9.4-22.3 12.8v30.6c0 7-4.5 13.3-11.3 14.8c-10.5 2.4-21.5 3.7-32.7 3.7s-22.2-1.3-32.7-3.7c-6.8-1.5-11.3-7.8-11.3-14.8v-30.5c-8-3.4-15.6-7.7-22.5-12.9l-24.7 14.3c-6.1 3.5-13.7 2.7-18.5-2.4c-7.6-8.1-14.3-17.2-20.1-27.2s-10.3-20.4-13.5-31c-2.1-6.7 1.1-13.7 7.2-17.2l24.8-14.3c-.4-4.1-.7-8.2-.7-12.4s.2-8.3.7-12.4L343.8 325c-6.1-3.5-9.2-10.5-7.2-17.2c3.3-10.6 7.7-21 13.5-31s12.5-19.1 20.1-27.2c4.8-5.1 12.4-5.9 18.5-2.4l24.8 14.3c6.9-5.1 14.5-9.4 22.5-12.9v-30.5zm92.1 133.5a48.1 48.1 0 1 0-96.1 0a48.1 48.1 0 1 0 96.1 0" stroke-width="13" stroke="#E10600"/></svg>',
                'active'      => ['dashboards.superadmin', 'superadmin.*'],
            ],
            [
                'key'         => 'create_users_super',
                'title'       => 'Crear Nuevos Usuarios',
                'description' => 'Formulario para crear nuevos usuarios en el sistema.',
                'permission'  => 'users.create',
                'roles'       => ['superadmin'],
                'route'       => 'panel.usuarios.crear',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path fill="#E10600" d="M9 14c1.381 0 2.631-.56 3.536-1.465C13.44 11.631 14 10.381 14 9s-.56-2.631-1.464-3.535C11.631 4.56 10.381 4 9 4s-2.631.56-3.536 1.465C4.56 6.369 4 7.619 4 9s.56 2.631 1.464 3.535A5 5 0 0 0 9 14m0 7c3.518 0 6-1 6-2c0-2-2.354-4-6-4c-3.75 0-6 2-6 4c0 1 2.25 2 6 2m12-9h-2v-2a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2" stroke-width="0.5" stroke="#E10600"/></svg>',
                'active'      => ['panel.usuarios.crear'],
            ],

            // === ADMIN ===
            [
                'key'         => 'dashboard_admin',
                'title'       => 'Gestiona Usuarios',
                'description' => 'Gestiona, crea, edita y elimina usuarios del sistema.',
                'permission'  => 'dashboard.view',
                'roles'       => ['admin'],
                'route'       => 'dashboards.admin',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 640 512"><path fill="#E10600" d="M224 0a128 128 0 1 1 0 256a128 128 0 1 1 0-256m-45.7 304h91.4"/></svg>',
                'active'      => ['dashboards.admin', 'admin.*'],
            ],
            [
                'key'         => 'create_users_admin',
                'title'       => 'Crear Nuevos Usuarios',
                'description' => 'Formulario para crear nuevos usuarios en el sistema.',
                'permission'  => 'users.create',
                'roles'       => ['admin'],
                'route'       => 'panel.usuarios.crear',
                'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path fill="#E10600" d="M9 14c1.381 0 2.631-.56 3.536-1.465C13.44 11.631 14 10.381 14 9s-.56-2.631-1.464-3.535C11.631 4.56 10.381 4 9 4s-2.631.56-3.536 1.465C4.56 6.369 4 7.619 4 9s.56 2.631 1.464 3.535A5 5 0 0 0 9 14m0 7c3.518 0 6-1 6-2c0-2-2.354-4-6-4c-3.75 0-6 2-6 4c0 1 2.25 2 6 2m12-9h-2v-2a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2" stroke-width="0.5" stroke="#E10600"/></svg>',
                'active'      => ['panel.usuarios.crear'],
            ],
        ];
    }

    /** Reglas de visibilidad (roles + permisos) */
    private function canSee(array $module, $user): bool
    {
        $rolesOk = empty($module['roles']) || $user->hasAnyRole($module['roles']);
        $permOk  = empty($module['permission']) || $user->can($module['permission']) || $user->hasPermissionTo($module['permission']);
        return $rolesOk && $permOk;
    }

    /** Mapea módulos visibles al formato del componente <x-sidebar> */
    public static function toSidebarItems(array $modules): array
    {
        return array_map(function ($m) {
            $route  = $m['route'] ?? null;
            $label  = $m['title'] ?? ($m['key'] ?? 'Item');
            $icon   = $m['icon']  ?? null;
            $active = $m['active'] ?? ($route ? [$route, $route . '.*'] : []);
            return [
                'route'  => $route,
                'label'  => $label,
                'icon'   => $icon,
                'active' => (array) $active,
            ];
        }, $modules);
    }

    /**
     * Fallback estático para el layout: construye el sidebar desde el catálogo,
     * aplicando las mismas reglas de visibilidad.
     */
    public static function sidebarItems($user): array
    {
        if (!$user) return [];
        /** @var self $self */
        $self    = app(self::class);
        $catalog = $self->modulesCatalog();
        $visible = array_values(array_filter($catalog, fn ($m) => $self->canSee($m, $user)));
        return self::toSidebarItems($visible);
    }
}