<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Informe;

class DirectorDeAreaController extends Controller
{
    public function index()
    {
        $totalActividades = Actividad::count();
        $misActividades = Actividad::where('creado_por_id', auth()->id())->count();
        $actividadesPendientes = Actividad::where('estado', 'Pendiente')->count();
        $totalInformes = Informe::count();
        
        return view('dashboard-director-de-area', compact(
            'totalActividades',
            'misActividades',
            'actividadesPendientes',
            'totalInformes'
        ));
    }
}