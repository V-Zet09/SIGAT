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
        
        // ✅ CAMBIO: departamento → area
        $areaDirector = Auth::user()->area ?? null;

        // Estadísticas del área
        $actividadesArea = Actividad::where('tipo_area', $areaDirector)->count();
        
        $actividadesMes = Actividad::where('tipo_area', $areaDirector)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $misActividades = Actividad::where('creado_por_id', $userId)->count();
        
        $actividadesPendientes = Actividad::where('tipo_area', $areaDirector)
            ->where(function($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->count();
        
        $actividadesAprobadas = Actividad::where('tipo_area', $areaDirector)
            ->where('estado', 'Aprobada')
            ->count();

        // Listas de actividades
        $actividadesPendientesLista = Actividad::where('tipo_area', $areaDirector)
            ->where(function($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->latest()
            ->take(30)
            ->get();

        $actividadesRecientesArea = Actividad::where('tipo_area', $areaDirector)
            ->latest()
            ->take(10)
            ->get();
        
        $actividadesRechazadas = Actividad::where('tipo_area', $areaDirector)
            ->where('estado', 'Rechazada')
            ->latest()
            ->take(10)
            ->get();

        // Actividades por mes
        $actividadesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $nombreMes = $mes->translatedFormat('M Y');
            $count = Actividad::where('tipo_area', $areaDirector)
                ->whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            $actividadesPorMes[$nombreMes] = $count;
        }

        // Estado de actividades
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
        ]);
    }

    public function aprobar(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id);
        
        // ✅ CAMBIO: departamento → area
        if ($actividad->tipo_area !== Auth::user()->area) {
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
        
        // ✅ CAMBIO: departamento → area
        if ($actividad->tipo_area !== Auth::user()->area) {
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
