<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear los roles (si no están creados aún)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);

        // Crear los permisos (si no están creados aún)
        $dashboardView = Permission::firstOrCreate(['name' => 'dashboard.view']);
        $usersCreate = Permission::firstOrCreate(['name' => 'users.create']);
        $usersManage = Permission::firstOrCreate(['name' => 'users.manage']);
        $usersDelete = Permission::firstOrCreate(['name' => 'users.delete']);
        $rolesManage = Permission::firstOrCreate(['name' => 'roles.manage']);
        $permissionsManage = Permission::firstOrCreate(['name' => 'permissions.manage']);
        $eventsIndex = Permission::firstOrCreate(['name' => 'events.index']);

        // Asignar permisos al rol admin
        $adminRole->givePermissionTo([
            $dashboardView,
            $usersManage,
            $usersCreate,
            $usersDelete,
            $eventsIndex
        ]);

        // Asignar permisos al rol superadmin (tiene más permisos que el admin)
        $superAdminRole->givePermissionTo([
            $dashboardView,
            $usersManage,
            $usersCreate,
            $usersDelete,
            $rolesManage,
            $permissionsManage,
            $eventsIndex
        ]);
    }
}
