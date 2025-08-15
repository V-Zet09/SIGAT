<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;

class ActividadController extends Controller
{
    /**
     * Muestra el formulario para crear una nueva actividad.
     */
    public function create()
    {
        return view('dashboard-actividades');
    }

    /**
     * Guarda una nueva actividad en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'tipo_actividad' => 'nullable|string|max:255',
            'resumen' => 'nullable|string',
            'contenido' => 'nullable|string',
            'presupuesto' => 'nullable|numeric',
            'tipo_presupuesto' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'fase' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('actividades', 'public');
        }

        Actividad::create($validated);

        return redirect()->route('actividades.registradas')->with('success', 'Actividad registrada correctamente.');
    }

    /**
     * Muestra las actividades ya registradas con filtros.
     */
    public function showRegistradas(Request $request)
    {
        $query = Actividad::query();

        if ($request->filled('buscar')) {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        $actividades = $query->latest()->paginate(10);

        return view('dashboard-actividades-registradas', compact('actividades'));
    }

    /**
     * Muestra el formulario para editar una actividad.
     */
    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('edit', compact('actividad'));
    }

    /**
     * Actualiza una actividad existente.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'tipo_actividad' => 'nullable|string|max:255',
            'resumen' => 'nullable|string',
            'contenido' => 'nullable|string',
            'presupuesto' => 'nullable|numeric',
            'tipo_presupuesto' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'fase' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $actividad = Actividad::findOrFail($id);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('actividades', 'public');
        }

        $actividad->update($validated);

        return redirect()->route('actividades.registradas')->with('success', 'Actividad actualizada correctamente.');
    }

    /**
     * Elimina una actividad.
     */
    public function destroy($id)
    {
        $actividad = Actividad::findOrFail($id);
        $actividad->delete();

        return redirect()->route('actividades.registradas')->with('success', 'Actividad eliminada correctamente.');
    }

    /**
     * Muestra los detalles de una actividad específica.
     */
    public function show($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('show', compact('actividad'));
    }
}
