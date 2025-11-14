<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Informe;

class RegidorController extends Controller
{
    public function index()
    {
        $totalActividades = Actividad::count();
        $misActividades = Actividad::where('creado_por_id', auth()->id())->count();
        $totalInformes = Informe::count();
        
        return view('dashboard-regidor', compact(
            'totalActividades',
            'misActividades',
            'totalInformes'
        ));
    }
}