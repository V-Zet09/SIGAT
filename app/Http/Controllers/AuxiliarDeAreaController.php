<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Informe;

class AuxiliarDeAreaController extends Controller
{
    public function index()
    {
        $misActividades = Actividad::where('creado_por_id', auth()->id())->count();
        $actividadesCompletadas = Actividad::where('creado_por_id', auth()->id())
                                            ->where('estado', 'Completada')
                                            ->count();
        $totalInformes = Informe::count();
        
        return view('dashboard-auxiliar-area', compact(
            'misActividades',
            'actividadesCompletadas',
            'totalInformes'
        ));
    }
}