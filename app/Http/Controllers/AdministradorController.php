<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Actividad;
use App\Models\Informe;
use App\Models\AuditLog; // ← AGREGADO
use Carbon\Carbon;

class AdministradorController extends Controller
{
    public function index()
    {
        // Obtener mes actual
        $mesActual = Carbon::now()->startOfMonth();
        $mesFinal = Carbon::now()->endOfMonth();
        
        // Obtener fechas con eventos del mes actual
        $fechasActividades = $this->getFechasActividades($mesActual, $mesFinal);
        $fechasUsuarios = $this->getFechasUsuarios($mesActual, $mesFinal);
        $fechasInformes = $this->getFechasInformes($mesActual, $mesFinal);
        
        // ✅ OBTENER LOGS (ÚLTIMOS 50 CON PAGINACIÓN)
        $logs = AuditLog::with('user')
            ->latest()
            ->paginate(50);
        
        return view('dashboard-administrador', [
            // Estadísticas generales
            'totalActividades' => Actividad::count(),
            'totalUsuarios' => User::count(),
            'totalInformes' => Informe::count(),
            
            // Datos recientes
            'actividadesRecientes' => Actividad::latest()->take(5)->get(),
            'usuariosRecientes' => User::latest()->take(5)->get(),
            
            // Estados
            'actividadesRevisadas' => Actividad::where('estado', 'Aprobada')->count(),
            'actividadesPendientes' => Actividad::where('estado', 'Pendiente')->orWhereNull('estado')->count(),
            'usuariosActivos' => User::count(), // Ajusta según tu lógica de usuarios activos
            
            // Fechas para calendario
            'fechasActividades' => $fechasActividades,
            'fechasUsuarios' => $fechasUsuarios,
            'fechasInformes' => $fechasInformes,
            
            // ✅ LOGS DE AUDITORÍA
            'logs' => $logs,
        ]);
    }

    /**
     * Obtener eventos del calendario para un mes específico
     */
    public function getCalendarioEventos(Request $request)
    {
        // Validar entrada
        $request->validate([
            'year' => 'nullable|integer|min:2020|max:2099',
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);
        
        // Crear fechas de inicio y fin del mes
        $mesActual = Carbon::create($year, $month, 1)->startOfMonth();
        $mesFinal = Carbon::create($year, $month, 1)->endOfMonth();
        
        return response()->json([
            'actividades' => $this->getFechasActividades($mesActual, $mesFinal),
            'usuarios' => $this->getFechasUsuarios($mesActual, $mesFinal),
            'informes' => $this->getFechasInformes($mesActual, $mesFinal),
        ]);
    }

    /**
     * Obtener fechas con actividades
     */
    private function getFechasActividades($inicio, $fin)
    {
        return Actividad::whereBetween('fecha', [$inicio, $fin])
            ->selectRaw('DATE(fecha) as fecha')
            ->groupBy('fecha')
            ->pluck('fecha')
            ->map(fn($fecha) => Carbon::parse($fecha)->format('Y-m-d'))
            ->toArray();
    }

    /**
     * Obtener fechas con usuarios creados
     */
    private function getFechasUsuarios($inicio, $fin)
    {
        return User::whereBetween('created_at', [$inicio, $fin])
            ->selectRaw('DATE(created_at) as fecha')
            ->groupBy('fecha')
            ->pluck('fecha')
            ->map(fn($fecha) => Carbon::parse($fecha)->format('Y-m-d'))
            ->toArray();
    }

    /**
     * Obtener fechas con informes generados
     */
    private function getFechasInformes($inicio, $fin)
    {
        return Informe::whereBetween('created_at', [$inicio, $fin])
            ->selectRaw('DATE(created_at) as fecha')
            ->groupBy('fecha')
            ->pluck('fecha')
            ->map(fn($fecha) => Carbon::parse($fecha)->format('Y-m-d'))
            ->toArray();
    }
}
