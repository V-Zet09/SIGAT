<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;

class RegidorController extends Controller
{
    public function index()
    {
        // Total de actividades
        $totalActividades = Actividad::count();

        // Actividades creadas esta semana
        $actividadesSemana = Actividad::whereBetween('created_at', [
            now()->startOfWeek(), now()->endOfWeek()
        ])->count();

        // Departamentos sin actividad (ajusta según tu lógica)
        $departamentosSinActividad = 0;

        // Actividades por día (últimos 7 días, ejemplo básico)
        $actividadesPorDia = Actividad::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as fecha, COUNT(*) as total')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
            
        // Definir variables para evitar error
        $aprobadas = 0;
        $revision = 0;

        return view('dashboard-regidor', compact(
            'totalActividades',
            'actividadesSemana',
            'aprobadas',
            'revision',
            'departamentosSinActividad',
            'actividadesPorDia'
        ));
    }
}