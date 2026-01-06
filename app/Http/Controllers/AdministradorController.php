<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Actividad;
use App\Models\Informe;
use App\Models\AuditLog;
use Carbon\Carbon;

class AdministradorController extends Controller
{
    public function index()
    {
        $mesActual = Carbon::now()->startOfMonth();
        $mesFinal = Carbon::now()->endOfMonth();

        $fechasActividades = $this->getFechasActividades($mesActual, $mesFinal);
        $fechasUsuarios = $this->getFechasUsuarios($mesActual, $mesFinal);
        $fechasInformes = $this->getFechasInformes($mesActual, $mesFinal);

        $logs = AuditLog::with('user')
            ->latest()
            ->paginate(50);

        $actividadesPendientesLista = Actividad::with('creador')
            ->orderBy('tipo_area', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard-administrador', [
            'totalActividades' => Actividad::count(),
            'totalUsuarios' => User::count(),
            'totalInformes' => Informe::count(),

            'actividadesRecientes' => Actividad::latest()->take(5)->get(),
            'usuariosRecientes' => User::latest()->take(5)->get(),

            'actividadesRevisadas' => Actividad::where('estado', 'Aprobada')->count(),
            'actividadesPendientes' => Actividad::where('estado', 'Pendiente')
                ->orWhereNull('estado')
                ->count(),

            'usuariosActivos' => User::active(5)->count(),

            'fechasActividades' => $fechasActividades,
            'fechasUsuarios' => $fechasUsuarios,
            'fechasInformes' => $fechasInformes,

            'logs' => $logs,
            'actividadesPendientesLista' => $actividadesPendientesLista,
        ]);
    }

    public function getCalendarioEventos(Request $request)
    {
        $request->validate([
            'year' => 'nullable|integer|min:2020|max:2099',
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $mesActual = Carbon::create($year, $month, 1)->startOfMonth();
        $mesFinal = Carbon::create($year, $month, 1)->endOfMonth();

        return response()->json([
            'actividades' => $this->getFechasActividades($mesActual, $mesFinal),
            'usuarios' => $this->getFechasUsuarios($mesActual, $mesFinal),
            'informes' => $this->getFechasInformes($mesActual, $mesFinal),
        ]);
    }

    private function getFechasActividades($inicio, $fin)
    {
        return Actividad::whereBetween('fecha', [$inicio, $fin])
            ->selectRaw('DATE(fecha) as fecha')
            ->groupBy('fecha')
            ->pluck('fecha')
            ->map(fn ($fecha) => Carbon::parse($fecha)->format('Y-m-d'))
            ->toArray();
    }

    private function getFechasUsuarios($inicio, $fin)
    {
        return User::whereBetween('created_at', [$inicio, $fin])
            ->selectRaw('DATE(created_at) as fecha')
            ->groupBy('fecha')
            ->pluck('fecha')
            ->map(fn ($fecha) => Carbon::parse($fecha)->format('Y-m-d'))
            ->toArray();
    }

    private function getFechasInformes($inicio, $fin)
    {
        return Informe::whereBetween('created_at', [$inicio, $fin])
            ->selectRaw('DATE(created_at) as fecha')
            ->groupBy('fecha')
            ->pluck('fecha')
            ->map(fn ($fecha) => Carbon::parse($fecha)->format('Y-m-d'))
            ->toArray();
    }
}
