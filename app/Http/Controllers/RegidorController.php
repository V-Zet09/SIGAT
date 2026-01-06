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

        $totalActividades = Actividad::count();

        $misActividades = Actividad::where('creado_por_id', $userId)->count();

        $actividadesAprobadas = Actividad::where('estado', 'Aprobada')->count();

        $totalInformes = Informe::count();

        $misActividadesAprobadas = Actividad::where('creado_por_id', $userId)
            ->where('estado', 'Aprobada')
            ->count();

        $misActividadesPendientes = Actividad::where('creado_por_id', $userId)
            ->where(function ($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->count();

        $misActividadesLista = Actividad::where('creado_por_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        $actividadesRecientes = Actividad::latest()
            ->take(10)
            ->get();

        $actividadesPorArea = Actividad::select('tipo_area', DB::raw('count(*) as total'))
            ->whereNotNull('tipo_area')
            ->groupBy('tipo_area')
            ->orderByDesc('total')
            ->take(10)
            ->pluck('total', 'tipo_area')
            ->toArray();

        if (empty($actividadesPorArea)) {
            $actividadesPorArea = [
                'Obras Públicas' => 0,
                'DIF' => 0,
                'Tránsito' => 0,
            ];
        }

        $tendenciaActividades = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $nombreMes = $mes->translatedFormat('M Y');

            $count = Actividad::whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();

            $tendenciaActividades[$nombreMes] = $count;
        }

        return view('dashboard-regidor', [
            'totalActividades' => $totalActividades,
            'misActividades' => $misActividades,
            'actividadesAprobadas' => $actividadesAprobadas,
            'totalInformes' => $totalInformes,

            'misActividadesAprobadas' => $misActividadesAprobadas,
            'misActividadesPendientes' => $misActividadesPendientes,

            'misActividadesLista' => $misActividadesLista,
            'actividadesRecientes' => $actividadesRecientes,

            'actividadesPorArea' => $actividadesPorArea,
            'tendenciaActividades' => $tendenciaActividades,
        ]);
    }
}
