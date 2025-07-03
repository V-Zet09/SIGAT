<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);

        // Crear roles
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);
        $viewer = Role::create(['name' => 'viewer']);

        // Asignar permisos a roles
        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['ver usuarios', 'editar usuarios']);
        $viewer->givePermissionTo(['ver usuarios']);
    }
}
