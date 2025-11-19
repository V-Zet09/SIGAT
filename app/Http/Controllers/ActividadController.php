<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class ActividadController extends Controller
{
    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('dashboard-actividades');
    }

    /**
     * Guardar nueva actividad
     */
    public function store(Request $request)
{
    // Validación incluyendo límite de máximo 5 fotos
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'autor' => 'nullable|string|max:255',
        'fecha' => 'required|date|before_or_equal:today',
        'tipo_area' => 'nullable|string|max:255',
        'resumen' => 'nullable|string',
        'presupuesto' => 'nullable|numeric',
        'tipo_presupuesto' => 'nullable|string',
        'contenido' => 'nullable|string',
        'foto' => 'array|max:5', // máximo 5 archivos como array
        'foto.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048', // validación por archivo
    ]);

    $rutasFotos = [];

    if ($request->hasFile('foto')) {
        foreach ($request->file('foto') as $archivo) {
            $rutasFotos[] = $archivo->store('actividades', 'public');
        }
    }

    // Guardamos las rutas de fotos en el validated si se desea guardar en JSON o relación
    // Aquí como ejemplo se guarda en JSON en columna 'fotos' (debes asegurar que exista)
    $validated['fotos'] = json_encode($rutasFotos);

    // Agregar ID creador
    $validated['creado_por_id'] = Auth::id();

    $actividad = Actividad::create($validated);

    // El resto del código de notificaciones igual

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

    // Filtro por año
    if ($request->filled('filtro_anio')) {
        $query->whereYear('fecha', $request->filtro_anio);
    }

    // Filtro por mes
    if ($request->filled('filtro_mes')) {
        $query->whereMonth('fecha', $request->filtro_mes);
    }

    // 🔍 Buscador inteligente (busca en múltiples campos)
    if ($request->filled('buscar')) {
        $buscar = $request->buscar;
        
        $query->where(function($q) use ($buscar) {
            // Buscar en título
            $q->where('titulo', 'like', '%' . $buscar . '%')
              // Buscar en autor
              ->orWhere('autor', 'like', '%' . $buscar . '%')
              // Buscar en área
              ->orWhere('tipo_area', 'like', '%' . $buscar . '%')
              // Buscar en contenido/resumen
              ->orWhere('contenido', 'like', '%' . $buscar . '%')
              ->orWhere('resumen', 'like', '%' . $buscar . '%');
            
            // 📅 Detectar si es una fecha (formato dd/mm/yyyy o dd-mm-yyyy)
            if (preg_match('/(\d{2})[\/\-](\d{2})[\/\-](\d{4})/', $buscar, $matches)) {
                $fechaBuscada = $matches[3] . '-' . $matches[2] . '-' . $matches[1]; // Convertir a Y-m-d
                $q->orWhere('fecha', $fechaBuscada);
            }
            
            // 📅 Detectar si es solo un año (4 dígitos)
            if (preg_match('/^\d{4}$/', $buscar)) {
                $q->orWhereYear('fecha', $buscar);
            }
            
            // 📅 Detectar nombre de mes (enero, febrero, etc.)
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

    // Ordenar por fecha descendente (más reciente primero)
    $actividades = $query->orderBy('fecha', 'desc')->paginate(10);

    return view('dashboard-actividades-registradas', compact('actividades'));
}






    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('edit', compact('actividad'));
    }

    /**
     * Actualizar actividad
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validarActividad($request);
        $actividad = Actividad::findOrFail($id);
        
        // Detectar cambios importantes para notificación
        $cambios = [];
        
        if ($actividad->titulo !== $validated['titulo']) {
            $cambios[] = 'Título modificado';
        }
        
        if ($actividad->fecha !== $validated['fecha']) {
            $cambios[] = 'Fecha: ' . $validated['fecha'];
        }
        
        if (isset($validated['fase']) && $actividad->fase !== $validated['fase']) {
            $cambios[] = 'Fase: ' . $validated['fase'];
        }

        // Actualizar foto si es necesaria
        if ($request->hasFile('foto')) {
            if ($actividad->foto) {
                Storage::disk('public')->delete($actividad->foto);
            }
            $validated['foto'] = $request->file('foto')->store('actividades', 'public');
        }

        $actividad->update($validated);

        // ✅ NOTIFICACIONES: Actividad actualizada (solo si hay cambios importantes)
        if (!empty($cambios)) {
            
            // Notificar al responsable (si existe y no es quien editó)
            if ($actividad->responsable_id && $actividad->responsable_id !== Auth::id()) {
                NotificationHelper::send(
                    $actividad->responsable_id,
                    'actividad',
                    'Actividad actualizada',
                    Auth::user()->name . ' ha actualizado la actividad: ' . $actividad->titulo . 
                    '. Cambios: ' . implode(', ', $cambios),
                    [
                        'link' => route('actividades.registradas'),
                        'icon' => 'ri-edit-line',
                        'color' => 'yellow',
                        'data' => ['actividad_id' => $actividad->id]
                    ]
                );
            }

            // Notificar al creador (si existe y no es quien editó)
            if ($actividad->creado_por_id && $actividad->creado_por_id !== Auth::id()) {
                NotificationHelper::send(
                    $actividad->creado_por_id,
                    'actividad',
                    'Tu actividad fue actualizada',
                    Auth::user()->name . ' ha actualizado tu actividad: ' . $actividad->titulo,
                    [
                        'link' => route('actividades.registradas'),
                        'icon' => 'ri-edit-line',
                        'color' => 'yellow',
                        'data' => ['actividad_id' => $actividad->id]
                    ]
                );
            }
        }

        return redirect()->route('actividades.registradas')
            ->with('success', 'Actividad actualizada correctamente.');
    }

    /**
     * Eliminar actividad
     */
    public function destroy($id)
    {
        $actividad = Actividad::findOrFail($id);
        $tituloActividad = $actividad->titulo;
        $responsableId = $actividad->responsable_id;
        $creadoPorId = $actividad->creado_por_id;

        // Eliminar foto si existe
        if ($actividad->foto) {
            Storage::disk('public')->delete($actividad->foto);
        }

        $actividad->delete();

        // ✅ NOTIFICACIONES: Actividad eliminada
        
        // Notificar al responsable (si existe y no es quien eliminó)
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

        // Notificar al creador (si existe y no es quien eliminó)
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

    /**
     * Mostrar detalle de actividad
     */
    public function show($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('show', compact('actividad'));
    }

    /**
     * Aprobar actividad
     */
    public function aprobar($id)
    {
        $actividad = Actividad::findOrFail($id);
        
        $actividad->update([
            'estado' => 'Aprobada',
            'aprobada_por' => Auth::id(),
            'fecha_aprobacion' => now()
        ]);

        // ✅ NOTIFICACIONES: Actividad aprobada
        
        // Notificar al creador (si existe)
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

        // Notificar al responsable (si existe y no es el creador)
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

    /**
     * Rechazar actividad
     */
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

        // ✅ NOTIFICACIONES: Actividad rechazada
        
        // Notificar al creador (si existe)
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

        // Notificar al responsable (si existe y no es el creador)
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

    /**
     * Adjuntar evidencia a una actividad
     */
    public function adjuntarEvidencia(Request $request, $id)
    {
        $request->validate([
            'evidencia' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', // 5MB
            'descripcion' => 'nullable|string|max:255'
        ]);

        $actividad = Actividad::findOrFail($id);
        
        $path = $request->file('evidencia')->store('evidencias', 'public');
        
        // Agregar evidencia al campo JSON o crear campo separado según tu estructura
        $evidencias = $actividad->evidencias ?? [];
        $evidencias[] = [
            'archivo' => $path,
            'descripcion' => $request->descripcion,
            'usuario_id' => Auth::id(),
            'usuario_nombre' => Auth::user()->name,
            'fecha' => now()->toDateTimeString()
        ];
        
        $actividad->update(['evidencias' => $evidencias]);

        // ✅ NOTIFICACIONES: Nueva evidencia
        
        // Notificar al creador (si no es quien subió)
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
            'responsable_id' => 'nullable|exists:users,id',
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
