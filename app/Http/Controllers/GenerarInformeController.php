<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenerarInformeController extends Controller
{
    // Muestra el formulario para generar el informe
    public function index()
    {
        return view('dashboard-generar-informe');
    }

    // Procesa y guarda el informe
    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'titulo' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
            // Agrega más campos según tu formulario
        ]);

        // Aquí puedes guardar la información en la base de datos
        // Por ejemplo:
        // Informe::create($request->all());

        return redirect()->back()->with('success', 'Informe generado correctamente.');
    }
}
