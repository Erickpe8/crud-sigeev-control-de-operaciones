<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia la caché de permisos/roles para evitar lecturas desactualizadas
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Asegura que existan los roles con el guard correcto
        $adminRole      = Role::firstOrCreate(['name' => 'admin',      'guard_name' => 'web']);
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $userRole       = Role::firstOrCreate(['name' => 'user',       'guard_name' => 'web']);

        // Si aún no corriste PermissionSeeder, lo ejecuta
        if (Permission::count() === 0) {
            $this->call(PermissionSeeder::class);
        }

        // ---------- Permisos base ----------
        $adminPerms = [
            // Dashboard
            'dashboard.view',

            // Users
            'users.view', 'users.create', 'users.manage', 'users.delete',

            // Roles / Permissions
            'roles.manage', 'permissions.manage',

            // Documents
            'documents.view', 'documents.create', 'documents.edit', 'documents.delete',

            // Catalogs
            'document_types.view', 'document_types.create', 'document_types.edit', 'document_types.delete',
            'genders.view', 'genders.create', 'genders.edit', 'genders.delete',
            'user_types.view', 'user_types.create', 'user_types.edit', 'user_types.delete',
            'institutions.view', 'institutions.create', 'institutions.edit', 'institutions.delete',
            'academic_programs.view', 'academic_programs.create', 'academic_programs.edit', 'academic_programs.delete',
        ];

        // Opcionales: agrega si existen para no romper si no están en PermissionSeeder
        $optional = ['events.view'];
        foreach ($optional as $opt) {
            if (Permission::where('name', $opt)->exists()) {
                $adminPerms[] = $opt;
            }
        }
        $adminPerms = array_values(array_unique($adminPerms));

        // Asigna permisos al rol admin
        $adminRole->givePermissionTo($adminPerms);

        // Superadmin: todos los permisos existentes
        $superAdminRole->givePermissionTo(Permission::all());

        // User: solo lectura básica (y events.view si existe)
        $userRead = [
            'dashboard.view',
            'documents.view',
            'document_types.view',
            'genders.view',
            'user_types.view',
            'institutions.view',
            'academic_programs.view',
        ];
        if (Permission::where('name', 'events.view')->exists()) {
            $userRead[] = 'events.view';
        }
        $userRead = array_values(array_unique($userRead));
        $userRole->givePermissionTo($userRead);

        // Limpia nuevamente la caché
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}