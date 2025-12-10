<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Informe;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PresidenteMunicipalController extends Controller
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
        
        // Actividades pendientes (estado Pendiente o null)
        $actividadesPendientes = Actividad::where(function($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->count();
        
        // Actividades aprobadas
        $actividadesAprobadas = Actividad::where('estado', 'Aprobada')->count();
        
        // Actividades rechazadas
        $actividadesRechazadas = Actividad::where('estado', 'Rechazada')->count();
        
        // Total de informes generados
        $totalInformes = Informe::count();

        // ============================================
        // LISTAS DE ACTIVIDADES
        // ============================================
        
        // Actividades pendientes de aprobación (últimas 10)
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

        // ✅ LISTA COMPLETA PARA GESTIÓN (PRESIDENTE VE TODAS)
        $actividadesGestionLista = Actividad::with('creador')
            ->orderBy('tipo_area', 'asc')      // Primero por área
            ->orderBy('created_at', 'desc')    // Luego por fecha
            ->get(); // Sin límite, trae todas las actividades

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

        // Si no hay datos, poner valores por defecto
        if (empty($actividadesPorArea)) {
            $actividadesPorArea = [
                'Obras Públicas' => 0,
                'DIF' => 0,
                'Tránsito' => 0,
            ];
        }

        // ============================================
        // TENDENCIA MENSUAL (ÚLTIMOS 6 MESES)
        // ============================================
        $tendenciaMensual = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $nombreMes = $mes->translatedFormat('M Y'); // Ene 2025, Feb 2025, etc.
            $count = Actividad::whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            $tendenciaMensual[$nombreMes] = $count;
        }

        // ============================================
        // ÁREAS SIN ACTIVIDAD (ÚLTIMOS 30 DÍAS)
        // ============================================
        
        // Lista de todas las áreas que deberían tener actividades
        $todasLasAreas = [
            'Obras Públicas', 
            'DIF', 
            'Tránsito', 
            'Agua Potable', 
            'Alumbrado Público', 
            'Informática', 
            'Eventos Especiales', 
            'Seguridad Pública',
            'Desarrollo Social',
            'Servicios Públicos'
        ];
        
        // Obtener áreas que SÍ han tenido actividad en los últimos 30 días
        $areasConActividad = Actividad::where('created_at', '>=', Carbon::now()->subDays(30))
            ->whereNotNull('tipo_area')
            ->pluck('tipo_area')
            ->unique()
            ->toArray();
        
        // Calcular qué áreas NO han tenido actividad
        $areasSinActividad = collect($todasLasAreas)->diff($areasConActividad);

        // ============================================
        // RETORNAR VISTA CON TODOS LOS DATOS
        // ============================================
        return view('dashboard-presidente-municipal', [
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
            
            // ✅ LISTA DE ACTIVIDADES PARA GESTIÓN
            'actividadesGestionLista' => $actividadesGestionLista,
            
            // Datos para gráficas
            'actividadesPorArea' => $actividadesPorArea,
            'tendenciaMensual' => $tendenciaMensual,
            
            // Áreas sin actividad
            'areasSinActividad' => $areasSinActividad,
        ]);
    }
}
