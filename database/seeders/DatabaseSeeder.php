<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,            // 1. Crear roles
            PermissionSeeder::class,      // 2. Crear permisos (si tienes este seeder)
            RolePermissionSeeder::class,  // 3. Asignar permisos a roles 
        ]);
    }
}