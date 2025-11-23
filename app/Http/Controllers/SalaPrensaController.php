<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaPrensaController extends Controller
{
    public function index()
    {
        // Obtener actividades ordenadas por fecha (más reciente primero)
        // La primera será la principal, las demás secundarias
        $actividades = Actividad::orderBy('fecha', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        
        return view('sala-prensa', compact('actividades'));
    }

}
