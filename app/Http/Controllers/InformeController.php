<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InformeController extends Controller
{
    // Mostrar formulario para crear informe
    public function create()
    {
        return view('generar-informe'); // Usando tu vista existente
    }

    // Guardar el informe completo
    public function store(Request $request)
    {
        // Validación de campos requeridos
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'periodo' => 'required|string|max:100',
            'portada' => 'required|image|max:2048',
            'comuna' => 'nullable|image|max:2048',
            'introduccion' => 'required|string',
            'actividades' => 'required|string',
            'conclusion' => 'required|string',
            'actividades_imagen' => 'nullable|image|max:2048'
        ]);

        // Procesar imágenes
        $portadaPath = $this->guardarImagen($request->file('portada'), 'portadas');
        $comunaPath = $request->hasFile('comuna') ? $this->guardarImagen($request->file('comuna'), 'comunas') : null;
        $actividadesPath = $request->hasFile('actividades_imagen') ? $this->guardarImagen($request->file('actividades_imagen'), 'actividades') : null;

        // Crear el informe en la base de datos
        $informe = Informe::create([
            'user_id' => auth()->id(),
            'titulo' => $request->titulo,
            'periodo' => $request->periodo,
            'portada_path' => $portadaPath,
            'comuna_path' => $comunaPath,
            'introduccion' => $request->introduccion,
            'actividades' => $request->actividades,
            'conclusion' => $request->conclusion,
            'actividades_imagen_path' => $actividadesPath,
            'slug' => Str::slug($request->titulo . '-' . time())
        ]);

        return redirect()->route('informes.show', $informe->slug)
            ->with('success', 'Informe generado exitosamente');
    }

    // Mostrar un informe específico
    public function show($slug)
    {
        $informe = Informe::where('slug', $slug)->firstOrFail();
        return view('informes.show', compact('informe'));
    }

    // Guardar imagen en storage (método privado reutilizable)
    private function guardarImagen($imagen, $folder)
    {
        $nombreArchivo = 'informe_' . time() . '_' . Str::random(10) . '.' . $imagen->getClientOriginalExtension();
        return $imagen->storeAs($folder, $nombreArchivo, 'public');
    }
}