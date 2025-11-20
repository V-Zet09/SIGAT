<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class ActividadController extends Controller
{
    public function create()
    {
        return view('dashboard-actividades');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'tipo_area' => 'nullable|string|max:255',
            'resumen' => 'nullable|string',
            'presupuesto' => 'nullable|numeric',
            'tipo_presupuesto' => 'nullable|string',
            'contenido' => 'nullable|string',
            'foto' => 'array|max:5',
            'foto.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $rutasFotos = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $archivo) {
                $rutasFotos[] = $archivo->store('actividades', 'public');
            }
        }

        $validated['fotos'] = json_encode($rutasFotos);
        $validated['creado_por_id'] = Auth::id();

        $actividad = Actividad::create($validated);

        if (!empty($validated['responsable_id'])) {
            NotificationHelper::send(
                $validated['responsable_id'],
                'actividad',
                'Nueva actividad asignada',
                'Se te ha asignado la actividad: ' . $actividad->titulo,
                [
                    'link' => route('actividades.registradas'),
                    'icon' => 'ri-calendar-check-line',
                    'color' => 'blue',
                    'data' => ['actividad_id' => $actividad->id]
                ]
            );
        }

        NotificationHelper::sendToRole(
            'Administrador',
            'actividad',
            'Nueva actividad creada',
            Auth::user()->name . ' ha creado la actividad: ' . $actividad->titulo,
            [
                'link' => route('actividades.registradas'),
                'icon' => 'ri-calendar-check-line',
                'color' => 'green',
                'data' => ['actividad_id' => $actividad->id]
            ]
        );

        return redirect()->route('actividades.registradas')
            ->with('success', 'Actividad registrada correctamente.');
    }

    public function showRegistradas(Request $request)
    {
        $query = Actividad::query();

        if ($request->filled('filtro_anio')) {
            $query->whereYear('fecha', $request->filtro_anio);
        }

        if ($request->filled('filtro_mes')) {
            $query->whereMonth('fecha', $request->filtro_mes);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'like', '%' . $buscar . '%')
                    ->orWhere('autor', 'like', '%' . $buscar . '%')
                    ->orWhere('tipo_area', 'like', '%' . $buscar . '%')
                    ->orWhere('contenido', 'like', '%' . $buscar . '%')
                    ->orWhere('resumen', 'like', '%' . $buscar . '%');

                if (preg_match('/(\d{2})[\/\-](\d{2})[\/\-](\d{4})/', $buscar, $matches)) {
                    $fechaBuscada = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
                    $q->orWhere('fecha', $fechaBuscada);
                }

                if (preg_match('/^\d{4}$/', $buscar)) {
                    $q->orWhereYear('fecha', $buscar);
                }

                $meses = [
                    'enero' => 1, 'febrero' => 2, 'marzo' => 3, 'abril' => 4,
                    'mayo' => 5, 'junio' => 6, 'julio' => 7, 'agosto' => 8,
                    'septiembre' => 9, 'octubre' => 10, 'noviembre' => 11, 'diciembre' => 12
                ];

                $buscarLower = strtolower($buscar);
                foreach ($meses as $nombreMes => $numeroMes) {
                    if (strpos($buscarLower, $nombreMes) !== false) {
                        $q->orWhereMonth('fecha', $numeroMes);
                        break;
                    }
                }
            });
        }

        $actividades = $query->orderBy('fecha', 'desc')->paginate(10);

        return view('dashboard-actividades-registradas', compact('actividades'));
    }

    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);

        $fotos = $actividad->fotos
            ? (is_array($actividad->fotos) ? $actividad->fotos : json_decode($actividad->fotos, true))
            : [];
        if (!empty($actividad->foto) && !in_array($actividad->foto, $fotos)) {
            array_unshift($fotos, $actividad->foto);
        }
        $actividad->fotos = $fotos;

        return view('edit', compact('actividad'));
    }

    public function update(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'tipo_area' => 'required|string|max:255',
            'resumen' => 'nullable|string',
            'contenido' => 'nullable|string',
            'presupuesto' => 'nullable|numeric',
            'tipo_presupuesto' => 'nullable|string|max:255',
            'foto' => 'array|max:5',
            'foto.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $fotosActuales = $actividad->fotos
            ? (is_array($actividad->fotos) ? $actividad->fotos : json_decode($actividad->fotos, true))
            : [];
        if (!empty($actividad->foto) && !in_array($actividad->foto, $fotosActuales)) {
            array_unshift($fotosActuales, $actividad->foto);
        }

        if ($request->has('cambiar_foto')) {
            foreach ($request->file('cambiar_foto', []) as $index => $fotoNueva) {
                if ($fotoNueva && isset($fotosActuales[$index])) {
                    Storage::disk('public')->delete($fotosActuales[$index]);
                    $fotosActuales[$index] = $fotoNueva->store('actividades', 'public');
                }
            }
        }

        if ($request->hasFile('cambiar_foto_legacy')) {
            $fotoNueva = $request->file('cambiar_foto_legacy');
            Storage::disk('public')->delete($actividad->foto);
            $rutaNueva = $fotoNueva->store('actividades', 'public');
            $actividad->foto = $rutaNueva;
        }

        if ($request->hasFile('foto')) {
            $nuevas = [];
            foreach ($request->file('foto') as $file) {
                if ($file->isValid()) {
                    $nuevas[] = $file->store('actividades', 'public');
                }
            }
            $fotosActuales = array_merge($fotosActuales, $nuevas);
            $fotosActuales = array_slice($fotosActuales, 0, 5);
        }

        $validated['fotos'] = json_encode($fotosActuales);
        $validated['foto'] = $actividad->foto ?? null;

        $actividad->update($validated);

        return redirect()->route('actividades.registradas')
            ->with('success', 'Actividad actualizada correctamente.');
    }

    public function eliminarFoto($id, $foto)
    {
        $actividad = Actividad::findOrFail($id);
        $fotos = $actividad->fotos
            ? (is_array($actividad->fotos) ? $actividad->fotos : json_decode($actividad->fotos, true))
            : [];
        if (!empty($actividad->foto) && !in_array($actividad->foto, $fotos)) {
            array_unshift($fotos, $actividad->foto);
        }

        $fotoDecodificada = urldecode($foto);
        $index = array_search($fotoDecodificada, $fotos);

        if ($index !== false) {
            Storage::disk('public')->delete($fotos[$index]);
            array_splice($fotos, $index, 1);

            $actividad->fotos = json_encode($fotos);
            if ($actividad->foto === $fotoDecodificada) {
                $actividad->foto = null;
            }
            $actividad->save();
        }

        return redirect()->back()->with('success', 'Foto eliminada correctamente.');
    }

    public function destroy($id)
    {
        $actividad = Actividad::findOrFail($id);
        $tituloActividad = $actividad->titulo;
        $responsableId = $actividad->responsable_id;
        $creadoPorId = $actividad->creado_por_id;

        if ($actividad->foto) {
            Storage::disk('public')->delete($actividad->foto);
        }

        $actividad->delete();

        if ($responsableId && $responsableId !== Auth::id()) {
            NotificationHelper::send(
                $responsableId,
                'actividad',
                'Actividad eliminada',
                'La actividad "' . $tituloActividad . '" ha sido eliminada del sistema por ' . Auth::user()->name,
                [
                    'icon' => 'ri-delete-bin-line',
                    'color' => 'red'
                ]
            );
        }

        if ($creadoPorId && $creadoPorId !== Auth::id()) {
            NotificationHelper::send(
                $creadoPorId,
                'actividad',
                'Tu actividad fue eliminada',
                'Tu actividad "' . $tituloActividad . '" ha sido eliminada del sistema por ' . Auth::user()->name,
                [
                    'icon' => 'ri-delete-bin-line',
                    'color' => 'red'
                ]
            );
        }

        return redirect()->route('actividades.registradas')
            ->with('success', 'Actividad eliminada correctamente.');
    }

    public function show($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('show', compact('actividad'));
    }

    public function aprobar($id)
    {
        $actividad = Actividad::findOrFail($id);

        $actividad->update([
            'estado' => 'Aprobada',
            'aprobada_por' => Auth::id(),
            'fecha_aprobacion' => now()
        ]);

        if ($actividad->creado_por_id) {
            NotificationHelper::send(
                $actividad->creado_por_id,
                'actividad',
                '✓ Actividad aprobada',
                Auth::user()->name . ' ha aprobado tu actividad: ' . $actividad->titulo,
                [
                    'link' => route('actividades.registradas'),
                    'icon' => 'ri-check-double-line',
                    'color' => 'green',
                    'data' => ['actividad_id' => $actividad->id]
                ]
            );
        }

        if ($actividad->responsable_id && $actividad->responsable_id !== $actividad->creado_por_id) {
            NotificationHelper::send(
                $actividad->responsable_id,
                'actividad',
                '✓ Actividad aprobada',
                'La actividad "' . $actividad->titulo . '" ha sido aprobada',
                [
                    'link' => route('actividades.registradas'),
                    'icon' => 'ri-check-double-line',
                    'color' => 'green',
                    'data' => ['actividad_id' => $actividad->id]
                ]
            );
        }

        return redirect()->back()
            ->with('success', 'Actividad aprobada correctamente.');
    }

    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|max:500'
        ]);

        $actividad = Actividad::findOrFail($id);

        $actividad->update([
            'estado' => 'Rechazada',
            'rechazada_por' => Auth::id(),
            'motivo_rechazo' => $request->motivo,
            'fecha_rechazo' => now()
        ]);

        if ($actividad->creado_por_id) {
            NotificationHelper::send(
                $actividad->creado_por_id,
                'actividad',
                '✗ Actividad rechazada',
                Auth::user()->name . ' ha rechazado tu actividad: ' . $actividad->titulo .
                '. Motivo: ' . $request->motivo,
                [
                    'link' => route('actividades.registradas'),
                    'icon' => 'ri-close-circle-line',
                    'color' => 'red',
                    'data' => ['actividad_id' => $actividad->id, 'motivo' => $request->motivo]
                ]
            );
        }

        if ($actividad->responsable_id && $actividad->responsable_id !== $actividad->creado_por_id) {
            NotificationHelper::send(
                $actividad->responsable_id,
                'actividad',
                '✗ Actividad rechazada',
                'La actividad "' . $actividad->titulo . '" ha sido rechazada. Motivo: ' . $request->motivo,
                [
                    'link' => route('actividades.registradas'),
                    'icon' => 'ri-close-circle-line',
                    'color' => 'red',
                    'data' => ['actividad_id' => $actividad->id]
                ]
            );
        }

        return redirect()->back()
            ->with('success', 'Actividad rechazada.');
    }

    public function adjuntarEvidencia(Request $request, $id)
    {
        $request->validate([
            'evidencia' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'descripcion' => 'nullable|string|max:255'
        ]);

        $actividad = Actividad::findOrFail($id);
        $path = $request->file('evidencia')->store('evidencias', 'public');

        $evidencias = $actividad->evidencias ?? [];
        $evidencias[] = [
            'archivo' => $path,
            'descripcion' => $request->descripcion,
            'usuario_id' => Auth::id(),
            'usuario_nombre' => Auth::user()->name,
            'fecha' => now()->toDateTimeString()
        ];

        $actividad->update(['evidencias' => $evidencias]);

        if ($actividad->creado_por_id && $actividad->creado_por_id !== Auth::id()) {
            NotificationHelper::send(
                $actividad->creado_por_id,
                'actividad',
                'Nueva evidencia adjuntada',
                Auth::user()->name . ' ha adjuntado evidencia a la actividad: ' . $actividad->titulo,
                [
                    'link' => route('actividades.registradas'),
                    'icon' => 'ri-attachment-line',
                    'color' => 'blue',
                    'data' => ['actividad_id' => $actividad->id]
                ]
            );
        }

        return redirect()->back()
            ->with('success', 'Evidencia adjuntada correctamente.');
    }

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
            'responsable_id' => 'nullable|exists:users,id',
        ]);
    }

    public function count(Request $r)
    {
        $r->validate([
            'start' => ['required', 'date', 'date_format:Y-m-d'],
            'end' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:start'],
            'areas' => ['nullable', 'string'],
        ]);

        $areas = array_values(array_filter(explode(',', (string) $r->query('areas'))));
        $q = Actividad::query()->whereBetween('fecha', [$r->query('start'), $r->query('end')]);
        if ($areas) {
            $q->whereIn('tipo_area', $areas);
        }
        return response()->json(['count' => $q->count()]);
    }
}
