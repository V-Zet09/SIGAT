<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPresidentController extends Controller
{
    public function index()
{
    dd("¡Estoy entrando al controlador!");

    // Simulación de datos que vendrían de la base de datos
    $totalActividades = 120;
    $actividadesSemana = 14;
    $aprobadas = 89;
    $revision = 31;
    $departamentosSinActividad = 3;

    $actividadesPorMes = [
        'Enero' => 10,
        'Febrero' => 12,
        'Marzo' => 15,
        'Abril' => 20,
        'Mayo' => 18,
        'Junio' => 25,
        'Julio' => 20
    ];

    return view('dashboard_presidente', compact( 
        'totalActividades',
        'actividadesSemana',
        'aprobadas',
        'revision',
        'departamentosSinActividad',
        'actividadesPorMes'
    ));
}

}
