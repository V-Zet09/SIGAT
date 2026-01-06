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
        $totalActividades = Actividad::count();

        $actividadesMes = Actividad::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $actividadesPendientes = Actividad::where(function ($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->count();

        $actividadesAprobadas = Actividad::where('estado', 'Aprobada')->count();

        $actividadesRechazadas = Actividad::where('estado', 'Rechazada')->count();

        $totalInformes = Informe::count();

        $actividadesPendientesLista = Actividad::where(function ($query) {
                $query->where('estado', 'Pendiente')
                      ->orWhereNull('estado');
            })
            ->latest()
            ->take(10)
            ->get();

        $actividadesAprobadasLista = Actividad::where('estado', 'Aprobada')
            ->latest()
            ->take(10)
            ->get();

        $actividadesGestionLista = Actividad::with('creador')
            ->orderBy('tipo_area', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $aprobacionesPorArea = Actividad::where('estado', 'Aprobada')
            ->select('tipo_area', DB::raw('count(*) as total'))
            ->whereNotNull('tipo_area')
            ->groupBy('tipo_area')
            ->orderByDesc('total')
            ->take(10)
            ->pluck('total', 'tipo_area')
            ->toArray();

        if (empty($aprobacionesPorArea)) {
            $aprobacionesPorArea = [
                'Obras Públicas' => 0,
                'DIF' => 0,
                'Tránsito' => 0,
            ];
        }

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

            $pendientes = Actividad::where(function ($query) {
                    $query->where('estado', 'Pendiente')
                          ->orWhereNull('estado');
                })
                ->whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();

            $tendenciaRevisiones[$nombreMes] = [
                'aprobadas' => $aprobadas,
                'rechazadas' => $rechazadas,
                'pendientes' => $pendientes,
            ];
        }

        return view('dashboard-sindico-procurador', [
            'totalActividades' => $totalActividades,
            'actividadesMes' => $actividadesMes,
            'actividadesPendientes' => $actividadesPendientes,
            'actividadesAprobadas' => $actividadesAprobadas,
            'actividadesRechazadas' => $actividadesRechazadas,
            'totalInformes' => $totalInformes,

            'actividadesPendientesLista' => $actividadesPendientesLista,
            'actividadesAprobadasLista' => $actividadesAprobadasLista,

            'actividadesGestionLista' => $actividadesGestionLista,

            'aprobacionesPorArea' => $aprobacionesPorArea,
            'tendenciaRevisiones' => $tendenciaRevisiones,
        ]);
    }
}
