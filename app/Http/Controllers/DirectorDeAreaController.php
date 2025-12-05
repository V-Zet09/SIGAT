<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DirectorDeAreaController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $user = Auth::user();
        
        // ✅ Verificar si el usuario es admin (Spatie Permission)
        $isAdmin = $user->hasRole('Administrador');
        
        $areaDirector = $user->area ?? null;

        // ===================================
        // ESTADÍSTICAS
        // ===================================
        if ($isAdmin) {
            // Admin ve TODAS las actividades del sistema
            $actividadesArea = Actividad::count();
            
            $actividadesMes = Actividad::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
            
            $actividadesPendientes = Actividad::where(function($query) {
                    $query->where('estado', 'Pendiente')
                          ->orWhereNull('estado');
                })
                ->count();
            
            $actividadesAprobadas = Actividad::where('estado', 'Aprobada')
                ->count();
        } else {
            // Director normal ve solo su área
            $actividadesArea = Actividad::where('tipo_area', $areaDirector)->count();
            
            $actividadesMes = Actividad::where('tipo_area', $areaDirector)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
            
            $actividadesPendientes = Actividad::where('tipo_area', $areaDirector)
                ->where(function($query) {
                    $query->where('estado', 'Pendiente')
                          ->orWhereNull('estado');
                })
                ->count();
            
            $actividadesAprobadas = Actividad::where('tipo_area', $areaDirector)
                ->where('estado', 'Aprobada')
                ->count();
        }
        
        // Mis actividades creadas (siempre personal)
        $misActividades = Actividad::where('creado_por_id', $userId)->count();

        // ===================================
// LISTAS DE ACTIVIDADES
// ===================================
if ($isAdmin) {
    // ✅ Admin ve TODAS las actividades del sistema (las 62)
    $actividadesPendientesLista = Actividad::with('creador')
        ->orderBy('tipo_area', 'asc')      // Primero por área
        ->orderBy('created_at', 'desc')    // Luego por fecha
        ->get(); // ← SIN LÍMITE, trae todas

    $actividadesRecientesArea = Actividad::with('creador')
        ->orderBy('tipo_area', 'asc')
        ->orderBy('created_at', 'desc')
        ->limit(50) // Aumentar el límite
        ->get();
    
    $actividadesRechazadas = Actividad::with('creador')
        ->where('estado', 'Rechazada')
        ->orderBy('tipo_area', 'asc')
        ->orderBy('created_at', 'desc')
        ->get(); // Sin límite
} else {
    // Director normal ve solo su área (filtrado por estado pendiente)
    $actividadesPendientesLista = Actividad::where('tipo_area', $areaDirector)
        ->where(function($query) {
            $query->where('estado', 'Pendiente')
                  ->orWhereNull('estado');
        })
        ->with('creador')
        ->latest()
        ->take(30)
        ->get();

    $actividadesRecientesArea = Actividad::where('tipo_area', $areaDirector)
        ->with('creador')
        ->latest()
        ->take(10)
        ->get();
    
    $actividadesRechazadas = Actividad::where('tipo_area', $areaDirector)
        ->where('estado', 'Rechazada')
        ->with('creador')
        ->latest()
        ->take(10)
        ->get();
}


        // ===================================
        // ACTIVIDADES POR MES (últimos 6 meses)
        // ===================================
        $actividadesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $nombreMes = $mes->translatedFormat('M Y');
            
            if ($isAdmin) {
                $count = Actividad::whereYear('created_at', $mes->year)
                    ->whereMonth('created_at', $mes->month)
                    ->count();
            } else {
                $count = Actividad::where('tipo_area', $areaDirector)
                    ->whereYear('created_at', $mes->year)
                    ->whereMonth('created_at', $mes->month)
                    ->count();
            }
            
            $actividadesPorMes[$nombreMes] = $count;
        }

        // ===================================
        // ESTADO DE ACTIVIDADES
        // ===================================
        if ($isAdmin) {
            $estadoActividades = [
                'aprobadas' => Actividad::where('estado', 'Aprobada')->count(),
                'pendientes' => Actividad::where(function($query) {
                        $query->where('estado', 'Pendiente')
                              ->orWhereNull('estado');
                    })->count(),
                'rechazadas' => Actividad::where('estado', 'Rechazada')->count(),
            ];
        } else {
            $estadoActividades = [
                'aprobadas' => Actividad::where('tipo_area', $areaDirector)
                    ->where('estado', 'Aprobada')
                    ->count(),
                'pendientes' => Actividad::where('tipo_area', $areaDirector)
                    ->where(function($query) {
                        $query->where('estado', 'Pendiente')
                              ->orWhereNull('estado');
                    })
                    ->count(),
                'rechazadas' => Actividad::where('tipo_area', $areaDirector)
                    ->where('estado', 'Rechazada')
                    ->count(),
            ];
        }

        return view('dashboard-director-de-area', [
            'actividadesArea' => $actividadesArea,
            'actividadesMes' => $actividadesMes,
            'misActividades' => $misActividades,
            'actividadesPendientes' => $actividadesPendientes,
            'actividadesAprobadas' => $actividadesAprobadas,
            'actividadesPendientesLista' => $actividadesPendientesLista,
            'actividadesRecientesArea' => $actividadesRecientesArea,
            'actividadesRechazadas' => $actividadesRechazadas,
            'actividadesPorMes' => $actividadesPorMes,
            'estadoActividades' => $estadoActividades,
            'isAdmin' => $isAdmin, // Para usar en la vista si lo necesitas
        ]);
    }

    public function aprobar(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id);
        $user = Auth::user();
        
        // ✅ Admin puede aprobar cualquier actividad
        if (!$user->hasRole('admin') && $actividad->tipo_area !== $user->area) {
            return redirect()->back()->with('error', 'No tienes permiso para aprobar esta actividad');
        }
        
        $actividad->update([
            'estado' => 'Aprobada',
            'aprobada_por' => Auth::id(),
            'fecha_aprobacion' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Actividad aprobada exitosamente');
    }

    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500'
        ]);
        
        $actividad = Actividad::findOrFail($id);
        $user = Auth::user();
        
        // ✅ Admin puede rechazar cualquier actividad
        if (!$user->hasRole('admin') && $actividad->tipo_area !== $user->area) {
            return redirect()->back()->with('error', 'No tienes permiso para rechazar esta actividad');
        }
        
        $actividad->update([
            'estado' => 'Rechazada',
            'rechazada_por' => Auth::id(),
            'motivo_rechazo' => $request->motivo_rechazo,
            'fecha_rechazo' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Actividad rechazada exitosamente');
    }
}
