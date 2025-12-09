<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuxiliarDeAreaController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $userId = $user->id;
    $areaAuxiliar = $user->departamento ?? null;

    // ============================================
    // SI ES ADMINISTRADOR: VER TODO EL SISTEMA
    // ============================================
    if ($user->hasRole('Administrador')) {

        // Estadísticas globales
        $misActividades = Actividad::count(); // total actividades
        $actividadesArea = Actividad::count(); // puedes cambiar a otro concepto si quieres
        $actividadesPendientes = Actividad::where(function($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })->count();

        $misActividadesAprobadas = Actividad::where('estado', 'Aprobada')->count();

        $actividadesMes = Actividad::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Listas
        $misActividadesLista = Actividad::latest()
            ->take(50) // puedes subir este límite
            ->get();

        $actividadesRecientesArea = Actividad::latest()
            ->take(20)
            ->get();

        // Gráfica: global últimos 6 meses
        $misActividadesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $nombreMes = $mes->translatedFormat('M Y');
            $count = Actividad::whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            $misActividadesPorMes[$nombreMes] = $count;
        }

    } else {

        // ============================================
        // COMPORTAMIENTO NORMAL DE AUXILIAR
        // ============================================

        // Mis actividades (creadas por mí)
        $misActividades = Actividad::where('creado_por_id', $userId)->count();
        
        // Total de actividades del área
        $actividadesArea = Actividad::where('tipo_area', $areaAuxiliar)->count();
        
        // Mis actividades pendientes
        $actividadesPendientes = Actividad::where('creado_por_id', $userId)
            ->where(function($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->count();
        
        // Mis actividades aprobadas
        $misActividadesAprobadas = Actividad::where('creado_por_id', $userId)
            ->where('estado', 'Aprobada')
            ->count();
        
        // Actividades del mes actual (mis actividades)
        $actividadesMes = Actividad::where('creado_por_id', $userId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Mis últimas actividades (últimas 20 para edición)
        $misActividadesLista = Actividad::where('creado_por_id', $userId)
            ->latest()
            ->take(20)
            ->get();

        // Actividades recientes del área (últimas 15 - solo consulta)
        $actividadesRecientesArea = Actividad::where('tipo_area', $areaAuxiliar)
            ->latest()
            ->take(15)
            ->get();

        // Mis actividades por mes (últimos 6 meses)
        $misActividadesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $nombreMes = $mes->translatedFormat('M Y');
            $count = Actividad::where('creado_por_id', $userId)
                ->whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            $misActividadesPorMes[$nombreMes] = $count;
        }
    }

    // ============================================
    // RETORNAR VISTA CON TODOS LOS DATOS
    // ============================================
    return view('dashboard-auxiliar-de-area', [
        'misActividades' => $misActividades,
        'actividadesArea' => $actividadesArea,
        'actividadesPendientes' => $actividadesPendientes,
        'misActividadesAprobadas' => $misActividadesAprobadas,
        'actividadesMes' => $actividadesMes,
        'misActividadesLista' => $misActividadesLista,
        'actividadesRecientesArea' => $actividadesRecientesArea,
        'misActividadesPorMes' => $misActividadesPorMes,
    ]);
}

}
