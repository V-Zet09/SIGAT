<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actividad;

class ActividadSeeder extends Seeder
{
    public function run(): void
    {
        Actividad::create([
            'titulo' => 'Rehabilitación de caminos rurales',
            'autor' => 'Dirección de Obras Públicas',
            'fecha' => '2025-08-01',
            'resumen' => 'Mejoramiento de caminos en comunidades alejadas.',
            'contenido' => 'Se utilizaron recursos municipales para rehabilitar caminos rurales.',
            'presupuesto' => 1000000,
            'tipo_presupuesto' => 'Municipal',
            'foto' => 'actividades/camino.jpg',
        ]);
    }
}
