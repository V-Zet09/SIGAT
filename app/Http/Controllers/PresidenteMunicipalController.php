<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Informe;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PresidenteMunicipalController extends Controller
{
    public function index()
    {
        $totalActividades = Actividad::count();

        $actividadesMes = Actividad::whereMonth('fecha', Carbon::now()->month)
            ->whereYear('fecha', Carbon::now()->year)
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
            ->orderBy('fecha', 'desc')
            ->take(10)
            ->get();

        $actividadesAprobadasLista = Actividad::where('estado', 'Aprobada')
            ->orderBy('fecha', 'desc')
            ->take(10)
            ->get();

        $actividadesGestionLista = Actividad::with('creador')
            ->orderBy('tipo_area', 'asc')
            ->orderBy('fecha', 'desc')
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

        $tendenciaMensual = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $nombreMes = $mes->translatedFormat('M Y');

            $count = Actividad::whereYear('fecha', $mes->year)
                ->whereMonth('fecha', $mes->month)
                ->count();

            $tendenciaMensual[$nombreMes] = $count;
        }

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
            'Servicios Públicos',
        ];

        $limite = Carbon::now()->subDays(30);

        $areasConActividad = Actividad::whereDate('fecha', '>=', $limite)
            ->whereNotNull('tipo_area')
            ->pluck('tipo_area')
            ->unique()
            ->toArray();

        $areasSinActividad = collect($todasLasAreas)->diff($areasConActividad);

        return view('dashboard-presidente-municipal', [
            'totalActividades' => $totalActividades,
            'actividadesMes' => $actividadesMes,
            'actividadesPendientes' => $actividadesPendientes,
            'actividadesAprobadas' => $actividadesAprobadas,
            'actividadesRechazadas' => $actividadesRechazadas,
            'totalInformes' => $totalInformes,

            'actividadesPendientesLista' => $actividadesPendientesLista,
            'actividadesAprobadasLista' => $actividadesAprobadasLista,
            'actividadesGestionLista' => $actividadesGestionLista,

            'actividadesPorArea' => $actividadesPorArea,
            'tendenciaMensual' => $tendenciaMensual,

            'areasSinActividad' => $areasSinActividad,
        ]);
    }
}
