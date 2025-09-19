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
        // 1) Limpia caché de Spatie para evitar lecturas desactualizadas
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2) Asegura roles base con guard web
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin',      'guard_name' => 'web']);
        $userRole       = Role::firstOrCreate(['name' => 'user',       'guard_name' => 'web']);

        // 3) (Opcional) Si tienes un PermissionSeeder aparte, ejecútalo si no hay permisos aún
        if (Permission::count() === 0 && class_exists(\Database\Seeders\PermissionSeeder::class)) {
            $this->call(\Database\Seeders\PermissionSeeder::class);
        }

        // 4) Catálogo de permisos estándar (guard web)
        //    - Incluye CRUD básicos de tus catálogos
        //    - Unifica "events.index" (viejo) a "events.view" (nuevo)
        $permissionNames = [
            // Dashboard
            'dashboard.view',

            // Users
            'users.view', 'users.create', 'users.manage', 'users.delete',

            // Roles / Permissions
            'roles.manage', 'permissions.manage',

            // Documents
            'documents.view', 'documents.create', 'documents.edit', 'documents.delete',

            // Catálogos
            'document_types.view', 'document_types.create', 'document_types.edit', 'document_types.delete',
            'genders.view',         'genders.create',         'genders.edit',         'genders.delete',
            'user_types.view',      'user_types.create',      'user_types.edit',      'user_types.delete',
            'institutions.view',    'institutions.create',    'institutions.edit',    'institutions.delete',
            'academic_programs.view','academic_programs.create','academic_programs.edit','academic_programs.delete',

            // Events (nuevo nombre)
            'events.view',
        ];

        // Soporte para alias heredado: si tenías events.index, lo normalizamos a events.view
        // Creamos ambos para no romper migraciones antiguas; luego administrativamente usarás "events.view"
        $aliases = [
            'events.index' => 'events.view',
        ];

        // 5) Crear/asegurar permisos con guard web
        $created = [];
        foreach ($permissionNames as $p) {
            $created[$p] = Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        // Asegura/crea alias y opcionalmente los reasigna a su target (no borramos alias para no romper)
        foreach ($aliases as $legacy => $target) {
            $created[$legacy] = Permission::firstOrCreate(['name' => $legacy, 'guard_name' => 'web']);
            // Si quieres que admin tenga ambos, deja así; si prefieres solo el target, asigna solo $target más abajo
        }

        // 6) Armar paquetes por rol
        $adminPerms = [
            'dashboard.view',
            'users.view', 'users.create', 'users.manage', 'users.delete',
            'roles.manage', 'permissions.manage',
            'documents.view', 'documents.create', 'documents.edit', 'documents.delete',
            'document_types.view', 'document_types.create', 'document_types.edit', 'document_types.delete',
            'genders.view', 'genders.create', 'genders.edit', 'genders.delete',
            'user_types.view', 'user_types.create', 'user_types.edit', 'user_types.delete',
            'institutions.view', 'institutions.create', 'institutions.edit', 'institutions.delete',
            'academic_programs.view', 'academic_programs.create', 'academic_programs.edit', 'academic_programs.delete',
            // Events
            'events.view',
            // Si quieres compatibilidad con código viejo:
            'events.index',
        ];

        $userRead = [
            'dashboard.view',
            'documents.view',
            'document_types.view',
            'genders.view',
            'user_types.view',
            'institutions.view',
            'academic_programs.view',
            // Events
            'events.view',
            // Si tu app vieja chequea este permiso:
            'events.index',
        ];

        // 7) Asignación idempotente
        $adminRole->syncPermissions($adminPerms);
        $userRole->syncPermissions($userRead);

        // 8) Superadmin: todos los permisos existentes (actual y futuros)
        $superAdminRole->syncPermissions(Permission::all());

        // 9) Limpia caché nuevamente
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}