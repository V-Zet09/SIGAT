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

        if ($user->hasRole('Administrador')) {
            $misActividades = Actividad::count();
            $actividadesArea = Actividad::count();

            $actividadesPendientes = Actividad::where(function ($query) {
                    $query->where('estado', 'Pendiente')
                          ->orWhereNull('estado');
                })->count();

            $misActividadesAprobadas = Actividad::where('estado', 'Aprobada')->count();

            $actividadesMes = Actividad::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();

            $misActividadesLista = Actividad::latest()
                ->take(50)
                ->get();

            $actividadesRecientesArea = Actividad::latest()
                ->take(20)
                ->get();

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
            $misActividades = Actividad::where('creado_por_id', $userId)->count();

            $actividadesArea = Actividad::where('tipo_area', $areaAuxiliar)->count();

            $actividadesPendientes = Actividad::where('creado_por_id', $userId)
                ->where(function ($query) {
                    $query->where('estado', 'Pendiente')
                          ->orWhereNull('estado');
                })
                ->count();

            $misActividadesAprobadas = Actividad::where('creado_por_id', $userId)
                ->where('estado', 'Aprobada')
                ->count();

            $actividadesMes = Actividad::where('creado_por_id', $userId)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();

            $misActividadesLista = Actividad::where('creado_por_id', $userId)
                ->latest()
                ->take(20)
                ->get();

            $actividadesRecientesArea = Actividad::where('tipo_area', $areaAuxiliar)
                ->latest()
                ->take(15)
                ->get();

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
