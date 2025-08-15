<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Si quieres usar factories, puedes descomentarlo:
        // \App\Models\User::factory(10)->create();

        // Aquí registras tu seeder personalizado
        $this->call([
            ActividadSeeder::class,
        ]);
    }
}
