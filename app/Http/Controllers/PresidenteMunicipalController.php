<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Informe;

class PresidenteMunicipalController extends Controller
{
    public function index()
    {
        $totalActividades = Actividad::count();
        $actividadesAprobadas = Actividad::where('estado', 'Aprobada')->count();
        $actividadesPendientes = Actividad::where('estado', 'Pendiente')->count();
        $totalInformes = Informe::count();
        
        return view('dashboard-presidente-municipal', compact(
            'totalActividades',
            'actividadesAprobadas',
            'actividadesPendientes',
            'totalInformes'
        ));
    }
}