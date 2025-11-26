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
    return view('dashboard-administrador', [
        'totalActividades' => Actividad::count(),
        'totalUsuarios' => User::count(),
        'totalInformes' => Informe::count(),
        'actividadesRecientes' => Actividad::latest()->paginate(5),
        'usuariosRecientes' => User::latest()->paginate(5),
        'actividadesRevisadas' => Actividad::where('estado', 'revisada')->count(),
        'actividadesPendientes' => Actividad::where('estado', 'pendiente')->count(),
        'usuariosActivos' => User::where('activo', 1)->count(),
    ]);
}

}