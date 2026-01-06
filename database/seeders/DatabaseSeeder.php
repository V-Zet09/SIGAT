<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,            // 1. Crear roles
            RolePermissionSeeder::class,  // 3. Asignar permisos a roles 
        ]);
    }
}