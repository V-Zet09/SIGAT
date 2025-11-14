<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Actividad;
use App\Models\Informe;

class AdministradorController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $totalActividades = Actividad::count();
        $totalInformes = Informe::count();
        $actividadesPendientes = Actividad::where('estado', 'Pendiente')->count();
        
        return view('dashboard-administrador', compact(
            'totalUsuarios',
            'totalActividades', 
            'totalInformes',
            'actividadesPendientes'
        ));
    }
}