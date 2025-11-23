<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void  
    {
        // Resetear caché de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear roles 
        $roles = [
            'Administrador',
            'Presidente Municipal',
            'Síndico Procurador',
            'Regidor',
            'Director de Área',
            'Auxiliar de Área',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Crear permisos 
        $permissions = [
            // Actividades
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'eliminar actividades',
            'aprobar actividades',
            'adjuntar evidencia',
            
            // Informes
            'generar informes',
            'editar informes',
            'eliminar informes',
            'visualizar informes',
            
            // Usuarios
            'gestionar usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            
            // Dashboard
            'ver dashboard administrador',
            'ver dashboard presidente',
            'ver dashboard auxiliar',
            'ver dashboard director',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Asignar permisos a roles
        $admin = Role::findByName('Administrador');
        $admin->givePermissionTo(Permission::all());

        $presidente = Role::findByName('Presidente Municipal');
        $presidente->givePermissionTo([
            'ver actividades',
            'visualizar informes',
            'generar informes',
            'ver dashboard presidente',
        ]);

        $sindico = Role::findByName('Síndico Procurador');
        $sindico->givePermissionTo([
            'ver actividades',
            'visualizar informes',
            'generar informes',
        ]);

        $regidor = Role::findByName('Regidor');
        $regidor->givePermissionTo([
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'eliminar actividades',
            'adjuntar evidencia',
        ]);

        $director = Role::findByName('Director de Área');
        $director->givePermissionTo([
            'ver actividades',
            'aprobar actividades',
            'adjuntar evidencia',
            'ver dashboard director',
        ]);

        $auxiliar = Role::findByName('Auxiliar de Área');
        $auxiliar->givePermissionTo([
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'adjuntar evidencia',
            'ver dashboard auxiliar',
        ]);

        echo "✅ Roles y permisos creados exitosamente\n";
    }
}