<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Illuminate\Support\Facades\Storage;

class ActividadController extends Controller
{
    public function create()
    {
        return view('dashboard-actividades');
    }

    public function store(Request $request)
    {
        $validated = $this->validarActividad($request);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('actividades', 'public');
        }

        Actividad::create($validated);

        return redirect()->route('actividades.registradas')->with('success', 'Actividad registrada correctamente.');
    }

    public function showRegistradas(Request $request)
    {
        $query = Actividad::query();

        if ($request->filled('buscar')) {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('tipo_area')) {
            $query->whereRaw('LOWER(tipo_area) = ?', [strtolower(trim($request->tipo_area))]);
        }

        $actividades = $query->latest()->paginate(10);

        return view('dashboard-actividades-registradas', compact('actividades'));
    }

    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('edit', compact('actividad'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validarActividad($request);
        $actividad = Actividad::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($actividad->foto) {
                Storage::disk('public')->delete($actividad->foto);
            }
            $validated['foto'] = $request->file('foto')->store('actividades', 'public');
        }

        $actividad->update($validated);

        return redirect()->route('actividades.registradas')->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy($id)
    {
        $actividad = Actividad::findOrFail($id);

        if ($actividad->foto) {
            Storage::disk('public')->delete($actividad->foto);
        }

        $actividad->delete();

        return redirect()->route('actividades.registradas')->with('success', 'Actividad eliminada correctamente.');
    }

    public function show($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('show', compact('actividad'));
    }

    /**
     * Validación centralizada para store y update
     */
    private function validarActividad(Request $request)
    {
        return $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'tipo_area' => 'required|string|max:255',
            'tipo_actividad' => 'nullable|string|max:255',
            'resumen' => 'nullable|string',
            'contenido' => 'nullable|string',
            'presupuesto' => 'nullable|numeric',
            'tipo_presupuesto' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'fase' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);
    }

    /**
     * API de conteo previo para el informe
     * GET /api/actividades/contar?start=YYYY-MM-DD&end=YYYY-MM-DD&areas=a,b,c
     */
    public function count(Request $r)
    {

        $r->validate([
            'start' => ['required', 'date', 'date_format:Y-m-d'],
            'end'   => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:start'],
            'areas' => ['nullable', 'string'],
        ]); // [web:340]


        $areas = array_values(array_filter(explode(',', (string) $r->query('areas'))));


        $q = Actividad::query()->whereBetween('fecha', [$r->query('start'), $r->query('end')]); 


        if ($areas) {

            $q->whereIn('tipo_area', $areas);

        }

        return response()->json(['count' => $q->count()]);
    }
}
