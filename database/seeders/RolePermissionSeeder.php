<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // ADMINISTRADOR - Todos los permisos
        // ============================================
        $admin = Role::findByName('Administrador');
        $admin->syncPermissions(Permission::all());

        // ============================================
        // PRESIDENTE MUNICIPAL
        // ============================================
        $presidente = Role::findByName('Presidente Municipal');
        $presidente->syncPermissions([
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'aprobar actividades',
            'adjuntar evidencia',
            'generar informes',
            'editar informes',
            'visualizar informes',
            'ver dashboard presidente',
        ]);

        // ============================================
        // SÍNDICO PROCURADOR
        // ============================================
        $sindico = Role::findByName('Síndico Procurador');
        $sindico->syncPermissions([
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'aprobar actividades',
            'adjuntar evidencia',
            'visualizar informes',
        ]);

        // ============================================
        // REGIDOR
        // ============================================
        $regidor = Role::findByName('Regidor');
        $regidor->syncPermissions([
            'ver actividades',
            'visualizar informes',
        ]);

        // ============================================
        // DIRECTOR DE ÁREA
        // ============================================
        $director = Role::findByName('Director de Área');
        $director->syncPermissions([
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'eliminar actividades',
            'adjuntar evidencia',
            'generar informes',
            'visualizar informes',
            'ver dashboard director',
        ]);

        // ============================================
        // AUXILIAR DE ÁREA
        // ============================================
        $auxiliar = Role::findByName('Auxiliar de Área');
        $auxiliar->syncPermissions([
            'ver actividades',
            'adjuntar evidencia',
            'visualizar informes',
            'ver dashboard auxiliar',
        ]);

        $this->command->info('✅ Permisos asignados correctamente a todos los roles');
    }
}