<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear los permisos necesarios
        Permission::create(['name' => 'dashboard.view']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.manage']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'roles.manage']);
        Permission::create(['name' => 'permissions.manage']);
        Permission::create(['name' => 'events.index']);
    }
}
