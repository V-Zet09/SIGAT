<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Informe;

class SindicoProcuradorController extends Controller
{
    public function index()
    {
        $totalActividades = Actividad::count();
        $actividadesPendientes = Actividad::where('estado', 'Pendiente')->count();
        $totalInformes = Informe::count();
        
        return view('dashboard-sindico-procurador', compact(
            'totalActividades',
            'actividadesPendientes',
            'totalInformes'
        ));
    }
}