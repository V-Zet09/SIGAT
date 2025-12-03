<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Informe;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RegidorController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ============================================
        // ESTADÍSTICAS GENERALES
        // ============================================
        $totalActividades = Actividad::count();
        
        // Mis actividades (registradas por el regidor) - USANDO creado_por_id
        $misActividades = Actividad::where('creado_por_id', $userId)->count();
        
        // Actividades aprobadas en total
        $actividadesAprobadas = Actividad::where('estado', 'Aprobada')->count();
        
        // Total de informes
        $totalInformes = Informe::count();

        // ============================================
        // MIS ESTADÍSTICAS PERSONALES
        // ============================================
        
        // Mis actividades aprobadas - USANDO creado_por_id
        $misActividadesAprobadas = Actividad::where('creado_por_id', $userId)
            ->where('estado', 'Aprobada')
            ->count();
        
        // Mis actividades pendientes - USANDO creado_por_id
        $misActividadesPendientes = Actividad::where('creado_por_id', $userId)
            ->where(function($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->count();

        // ============================================
        // LISTAS DE ACTIVIDADES
        // ============================================
        
        // Mis últimas actividades (últimas 10) - USANDO creado_por_id
        $misActividadesLista = Actividad::where('creado_por_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        // Actividades recientes del municipio (últimas 10)
        $actividadesRecientes = Actividad::latest()
            ->take(10)
            ->get();

        // ============================================
        // ACTIVIDADES POR ÁREA (PARA GRÁFICA)
        // ============================================
        $actividadesPorArea = Actividad::select('tipo_area', DB::raw('count(*) as total'))
            ->whereNotNull('tipo_area')
            ->groupBy('tipo_area')
            ->orderByDesc('total')
            ->take(10)
            ->pluck('total', 'tipo_area')
            ->toArray();

        // Si no hay datos, valores por defecto
        if (empty($actividadesPorArea)) {
            $actividadesPorArea = [
                'Obras Públicas' => 0,
                'DIF' => 0,
                'Tránsito' => 0,
            ];
        }

        // ============================================
        // TENDENCIA DE ACTIVIDADES (ÚLTIMOS 6 MESES)
        // ============================================
        $tendenciaActividades = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $nombreMes = $mes->translatedFormat('M Y');
            $count = Actividad::whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            $tendenciaActividades[$nombreMes] = $count;
        }

        // ============================================
        // RETORNAR VISTA CON TODOS LOS DATOS
        // ============================================
        return view('dashboard-regidor', [
            // Estadísticas generales
            'totalActividades' => $totalActividades,
            'misActividades' => $misActividades,
            'actividadesAprobadas' => $actividadesAprobadas,
            'totalInformes' => $totalInformes,
            
            // Mis estadísticas
            'misActividadesAprobadas' => $misActividadesAprobadas,
            'misActividadesPendientes' => $misActividadesPendientes,
            
            // Listas de actividades
            'misActividadesLista' => $misActividadesLista,
            'actividadesRecientes' => $actividadesRecientes,
            
            // Datos para gráficas
            'actividadesPorArea' => $actividadesPorArea,
            'tendenciaActividades' => $tendenciaActividades,
        ]);
    }
}
