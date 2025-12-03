<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Informe;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SindicoProcuradorController extends Controller
{
    public function index()
    {
        // ============================================
        // ESTADÍSTICAS GENERALES
        // ============================================
        $totalActividades = Actividad::count();
        
        // Actividades del mes actual
        $actividadesMes = Actividad::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Actividades pendientes de revisión legal
        $actividadesPendientes = Actividad::where(function($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->count();
        
        // Actividades aprobadas
        $actividadesAprobadas = Actividad::where('estado', 'Aprobada')->count();
        
        // Actividades rechazadas (con observaciones legales)
        $actividadesRechazadas = Actividad::where('estado', 'Rechazada')->count();
        
        // Total de informes generados
        $totalInformes = Informe::count();

        // ============================================
        // LISTAS DE ACTIVIDADES
        // ============================================
        
        // Actividades pendientes de revisión legal (últimas 10)
        $actividadesPendientesLista = Actividad::where(function($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->latest()
            ->take(10)
            ->get();

        // Actividades aprobadas recientes (últimas 10)
        $actividadesAprobadasLista = Actividad::where('estado', 'Aprobada')
            ->latest()
            ->take(10)
            ->get();

        // ============================================
        // APROBACIONES POR ÁREA (PARA GRÁFICA)
        // ============================================
        $aprobacionesPorArea = Actividad::where('estado', 'Aprobada')
            ->select('tipo_area', DB::raw('count(*) as total'))
            ->whereNotNull('tipo_area')
            ->groupBy('tipo_area')
            ->orderByDesc('total')
            ->take(10)
            ->pluck('total', 'tipo_area')
            ->toArray();

        // Si no hay datos, poner valores por defecto
        if (empty($aprobacionesPorArea)) {
            $aprobacionesPorArea = [
                'Obras Públicas' => 0,
                'DIF' => 0,
                'Tránsito' => 0,
            ];
        }

        // ============================================
        // TENDENCIA DE REVISIONES (ÚLTIMOS 6 MESES)
        // ============================================
        $tendenciaRevisiones = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $nombreMes = $mes->translatedFormat('M Y');
            
            $aprobadas = Actividad::where('estado', 'Aprobada')
                ->whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            
            $rechazadas = Actividad::where('estado', 'Rechazada')
                ->whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            
            $pendientes = Actividad::where(function($query) {
                    $query->where('estado', 'Pendiente')->orWhereNull('estado');
                })
                ->whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            
            $tendenciaRevisiones[$nombreMes] = [
                'aprobadas' => $aprobadas,
                'rechazadas' => $rechazadas,
                'pendientes' => $pendientes
            ];
        }

        // ============================================
        // RETORNAR VISTA CON TODOS LOS DATOS
        // ============================================
        return view('dashboard-sindico-procurador', [
            // Estadísticas principales
            'totalActividades' => $totalActividades,
            'actividadesMes' => $actividadesMes,
            'actividadesPendientes' => $actividadesPendientes,
            'actividadesAprobadas' => $actividadesAprobadas,
            'actividadesRechazadas' => $actividadesRechazadas,
            'totalInformes' => $totalInformes,
            
            // Listas de actividades
            'actividadesPendientesLista' => $actividadesPendientesLista,
            'actividadesAprobadasLista' => $actividadesAprobadasLista,
            
            // Datos para gráficas
            'aprobacionesPorArea' => $aprobacionesPorArea,
            'tendenciaRevisiones' => $tendenciaRevisiones,
        ]);
    }
}
