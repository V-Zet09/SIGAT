<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use App\Models\User;

class TestPermissions extends Command
{
    protected $signature = 'permissions:test {role?}';
    protected $description = 'Probar permisos de roles';

    public function handle()
    {
        $roleName = $this->argument('role');

        if ($roleName) {
            $this->testSingleRole($roleName);
        } else {
            $this->testAllRoles();
        }
    }

    private function testAllRoles()
    {
        $roles = Role::all();

        $this->info("\n🧪 TESTING DE PERMISOS - SISTEMA SIGAT\n");

        foreach ($roles as $role) {
            $this->testSingleRole($role->name);
        }

        $this->info("\n✅ Testing completado\n");
    }

    private function testSingleRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            $this->error("❌ El rol '{$roleName}' no existe");
            return;
        }

        $this->line("\n┌─ Testing rol: {$role->name}");
        $this->line("│  Total permisos: {$role->permissions->count()}");

        // Buscar un usuario con este rol o crear uno temporal
        $user = User::role($roleName)->first();

        if (!$user) {
            $this->warn("│  ⚠️  No hay usuarios con este rol");
            $this->line("└" . str_repeat("─", 60));
            return;
        }

        $this->line("│  Usuario de prueba: {$user->name}");

        // Probar cada permiso
        $passed = 0;
        $failed = 0;

        foreach ($role->permissions as $permission) {
            if ($user->can($permission->name)) {
                $this->line("│  ✅ {$permission->name}");
                $passed++;
            } else {
                $this->error("│  ❌ {$permission->name}");
                $failed++;
            }
        }

        $this->line("│");
        $this->line("│  Resultado: {$passed} ✅  {$failed} ❌");
        $this->line("└" . str_repeat("─", 60));
    }
}