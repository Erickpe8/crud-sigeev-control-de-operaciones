<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // =========================================
            // Dashboard
            // =========================================
            'dashboard.view',

            // =========================================
            // Users
            // =========================================
            'users.view',
            'users.create',
            'users.manage',
            'users.delete',

            // =========================================
            // Roles & Permissions
            // =========================================
            'roles.manage',
            'permissions.manage',

            // =========================================
            // Documents
            // =========================================
            'documents.view',
            'documents.create',
            'documents.edit',
            'documents.delete',

            // =========================================
            // Document Types
            // =========================================
            'document_types.view',
            'document_types.create',
            'document_types.edit',
            'document_types.delete',

            // =========================================
            // Genders
            // =========================================
            'genders.view',
            'genders.create',
            'genders.edit',
            'genders.delete',

            // =========================================
            // User Types
            // =========================================
            'user_types.view',
            'user_types.create',
            'user_types.edit',
            'user_types.delete',

            // =========================================
            // Institutions
            // =========================================
            'institutions.view',
            'institutions.create',
            'institutions.edit',
            'institutions.delete',

            // =========================================
            // Academic Programs
            // =========================================
            'academic_programs.view',
            'academic_programs.create',
            'academic_programs.edit',
            'academic_programs.delete',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate([
                'name'       => $p,
                'guard_name' => 'web',
            ]);
        }

        $this->command?->info('Permisos creados o actualizados exitosamente!');
    }
}
