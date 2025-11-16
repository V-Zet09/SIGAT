<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Resetear caché de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==========================================
        // CREAR PERMISOS
        // ==========================================
        $permissions = [
            // Dashboards
            'acceder dashboard administrador',
            'acceder dashboard presidente',
            'acceder dashboard sindico',
            'acceder dashboard regidor',
            'acceder dashboard director',
            'acceder dashboard auxiliar',
            
            // Actividades
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'eliminar actividades',
            'aprobar actividades',
            'adjuntar evidencia',
            
            // Informes
            'visualizar informes',
            'generar informes',
            'editar informes',
            'eliminar informes',
            
            // Usuarios
            'gestionar usuarios',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ==========================================
        // CREAR ROLES Y ASIGNAR PERMISOS
        // ==========================================

        // 🔴 ADMINISTRADOR (TODOS los permisos)
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $adminRole->syncPermissions(Permission::all()); // Dar TODOS los permisos

        // 🔵 PRESIDENTE MUNICIPAL
        $presidenteRole = Role::firstOrCreate(['name' => 'Presidente Municipal']);
        $presidenteRole->syncPermissions([
            'acceder dashboard presidente',
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'aprobar actividades',
            'visualizar informes',
            'generar informes',
            'editar informes',
        ]);

        // 🟡 SÍNDICO PROCURADOR
        $sindicoRole = Role::firstOrCreate(['name' => 'Síndico Procurador']);
        $sindicoRole->syncPermissions([
            'acceder dashboard sindico',
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'aprobar actividades',
            'visualizar informes',
            'generar informes',
        ]);

        // 🟢 REGIDOR
        $regidorRole = Role::firstOrCreate(['name' => 'Regidor']);
        $regidorRole->syncPermissions([
            'acceder dashboard regidor',
            'ver actividades',
            'crear actividades',
            'visualizar informes',
        ]);

        // 🟣 DIRECTOR DE ÁREA
        $directorRole = Role::firstOrCreate(['name' => 'Director de Área']);
        $directorRole->syncPermissions([
            'acceder dashboard director',
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'adjuntar evidencia',
            'visualizar informes',
        ]);

        // 🟠 AUXILIAR DE ÁREA
        $auxiliarRole = Role::firstOrCreate(['name' => 'Auxiliar de Área']);
        $auxiliarRole->syncPermissions([
            'acceder dashboard auxiliar',
            'ver actividades',
            'crear actividades',
            'adjuntar evidencia',
            'visualizar informes',
        ]);

        // ==========================================
        // ASIGNAR ROL AL USUARIO ADMIN
        // ==========================================
        $admin = User::where('email', 'admin@themesbrand.com')->first();
        if ($admin) {
            $admin->syncRoles(['Administrador']);
        }

        $this->command->info('✅ Roles y permisos creados exitosamente!');
        $this->command->info('✅ El Administrador tiene acceso a TODOS los dashboards');
    }
}