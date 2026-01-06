<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class DirectorDeAreaController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $user = Auth::user();

        $isAdmin = $user->hasRole('Administrador');
        $areaDirector = $user->area ?? null;

        if ($isAdmin) {
            $actividadesArea = Actividad::count();

            $actividadesMes = Actividad::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();

            $actividadesPendientes = Actividad::where(function ($query) {
                    $query->where('estado', 'Pendiente')
                          ->orWhereNull('estado');
                })
                ->count();

            $actividadesAprobadas = Actividad::where('estado', 'Aprobada')->count();
        } else {
            $actividadesArea = Actividad::where('tipo_area', $areaDirector)->count();

            $actividadesMes = Actividad::where('tipo_area', $areaDirector)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();

            $actividadesPendientes = Actividad::where('tipo_area', $areaDirector)
                ->where(function ($query) {
                    $query->where('estado', 'Pendiente')
                          ->orWhereNull('estado');
                })
                ->count();

            $actividadesAprobadas = Actividad::where('tipo_area', $areaDirector)
                ->where('estado', 'Aprobada')
                ->count();
        }

        $misActividades = Actividad::where('creado_por_id', $userId)->count();

        if ($isAdmin) {
            $actividadesPendientesLista = Actividad::with('creador')
                ->orderBy('tipo_area', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            $actividadesRecientesArea = Actividad::with('creador')
                ->orderBy('tipo_area', 'asc')
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            $actividadesRechazadas = Actividad::with('creador')
                ->where('estado', 'Rechazada')
                ->orderBy('tipo_area', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $actividadesPendientesLista = Actividad::where('tipo_area', $areaDirector)
                ->where(function ($query) {
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

        if ($isAdmin) {
            $estadoActividades = [
                'aprobadas' => Actividad::where('estado', 'Aprobada')->count(),
                'pendientes' => Actividad::where(function ($query) {
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
                    ->where(function ($query) {
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
            'isAdmin' => $isAdmin,
        ]);
    }

    public function aprobar(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id);
        $user = Auth::user();

        $esGlobal = $user->hasRole(['Administrador', 'Presidente Municipal', 'Síndico Procurador']);

        if (!$esGlobal && $actividad->tipo_area !== $user->area) {
            return redirect()->back()->with('error', 'No tienes permiso para aprobar esta actividad');
        }

        $actividad->update([
            'estado' => 'Aprobada',
            'aprobada_por' => $user->id,
            'fecha_aprobacion' => now(),
        ]);

        AuditLog::log(
            'aprobar',
            'Aprobó Actividad: ' . $actividad->titulo,
            'App\Models\Actividad',
            $actividad->id,
            ['estado' => 'Pendiente'],
            ['estado' => 'Aprobada']
        );

        return redirect()->back()->with('success', 'Actividad aprobada exitosamente');
    }

    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500',
        ]);

        $actividad = Actividad::findOrFail($id);
        $user = Auth::user();

        $esGlobal = $user->hasRole(['Administrador', 'Presidente Municipal', 'Síndico Procurador']);

        if (!$esGlobal && $actividad->tipo_area !== $user->area) {
            return redirect()->back()->with('error', 'No tienes permiso para rechazar esta actividad');
        }

        $actividad->update([
            'estado' => 'Rechazada',
            'rechazada_por' => $user->id,
            'motivo_rechazo' => $request->motivo_rechazo,
            'fecha_rechazo' => now(),
        ]);

        AuditLog::log(
            'rechazar',
            'Rechazó Actividad: ' . $actividad->titulo . ' - Motivo: ' . $request->motivo_rechazo,
            'App\Models\Actividad',
            $actividad->id,
            ['estado' => 'Pendiente'],
            ['estado' => 'Rechazada', 'motivo' => $request->motivo_rechazo]
        );

        return redirect()->back()->with('success', 'Actividad rechazada exitosamente');
    }
}
