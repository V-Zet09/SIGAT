<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\AuditLog;

class ActividadController extends Controller
{
    /**
     * Mostrar lista de actividades
     */
    public function index()
    {
        $user = Auth::user();
        
        // Filtrar según el rol del usuario
        if ($user->cargo === 'Administrador') {
            // Admin ve TODAS las actividades
            $actividades = Actividad::with(['creador', 'responsable'])
                ->latest()
                ->paginate(20);
        } elseif ($user->cargo === 'Director') {
            // Director ve solo las de SU área
            $actividades = Actividad::with(['creador', 'responsable'])
                ->where('tipo_area', $user->departamento)
                ->latest()
                ->paginate(20);
        } else {
            // Auxiliar ve solo las de SU área
            $actividades = Actividad::with(['creador', 'responsable'])
                ->where('tipo_area', $user->departamento)
                ->latest()
                ->paginate(20);
        }
        
        return view('actividades.index', compact('actividades'));
    }
    /**
 * Mostrar actividades registradas (listado)
 */
public function create()
{
    $usuarios = User::where('activo', 1)->get();
    return view('dashboard-actividades', compact('usuarios'));
}

// ✅ AGREGAR ESTE MÉTODO AQUÍ
/**
 * Guardar nueva actividad
 */
public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'autor' => 'nullable|string|max:255',
        'fecha' => 'required|date',
        'tipo_area' => 'required|string',
        'resumen' => 'required|string',
        'contenido' => 'required|string',
        'presupuesto' => 'nullable|numeric',
        'tipo_presupuesto' => 'nullable|string',
        'numero' => 'nullable|string',
        'fase' => 'nullable|string',
        'responsable_id' => 'nullable|exists:users,id',
        'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    $user = Auth::user();
    $fotos = [];

    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $foto) {
            if (count($fotos) < 5) {
                $filename = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('actividades/fotos', $filename, 'public');
                $fotos[] = $path;
            }
        }
    }

    Actividad::create([
        'titulo' => $request->titulo,
        'autor' => $request->autor ?? $user->name,
        'fecha' => $request->fecha,
        'tipo_area' => $request->tipo_area,
        'resumen' => $request->resumen,
        'contenido' => $request->contenido,
        'presupuesto' => $request->presupuesto,
        'tipo_presupuesto' => $request->tipo_presupuesto,
        'numero' => $request->numero,
        'fase' => $request->fase,
        'fotos' => $fotos,
        'responsable_id' => $request->responsable_id,
        'creado_por_id' => $user->id,
        'estado' => 'Pendiente',
    ]);

    return redirect()->route('actividades.registradas')
        ->with('success', 'Actividad creada exitosamente');
}

public function showRegistradas(Request $request)
{
    $user = Auth::user();
    
    // Construir la query base según el rol
    $query = Actividad::with(['creador', 'responsable']);
    
    // Filtrar por rol
    if ($user->cargo === 'Administrador') {
        // Admin ve TODAS
    } elseif ($user->cargo === 'Director') {
        $query->where('tipo_area', $user->departamento);
    } else {
        $query->where('tipo_area', $user->departamento);
    }
    
    // ===================================
    // ⭐ FILTRO POR ESTADO (NUEVO)
    // ===================================
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }
    
    // ===================================
    // FILTRO POR AÑO
    // ===================================
    if ($request->filled('filtro_anio') && $request->filtro_anio !== 'Todos los años') {
        $query->whereYear('fecha', $request->filtro_anio);
    }
    
    // ===================================
    // FILTRO POR MES
    // ===================================
    if ($request->filled('filtro_mes') && $request->filtro_mes !== '') {
        $query->whereMonth('fecha', $request->filtro_mes);
    }
    
    // ===================================
    // BÚSQUEDA AUTOMÁTICA (área, autor, fecha, título)
    // ===================================
    if ($request->filled('buscar')) {
        $busqueda = $request->buscar;
        
        $query->where(function($q) use ($busqueda) {
            // Buscar en título
            $q->where('titulo', 'LIKE', "%{$busqueda}%")
              // Buscar en autor
              ->orWhere('autor', 'LIKE', "%{$busqueda}%")
              // Buscar en área
              ->orWhere('tipo_area', 'LIKE', "%{$busqueda}%")
              // Buscar en contenido
              ->orWhere('contenido', 'LIKE', "%{$busqueda}%")
              // Buscar en resumen
              ->orWhere('resumen', 'LIKE', "%{$busqueda}%");
            
            // Buscar por fecha (formato dd/mm/yyyy)
            if (preg_match('/(\d{2})[\/\-](\d{2})[\/\-](\d{4})/', $busqueda, $matches)) {
                $fechaBuscada = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
                $q->orWhere('fecha', $fechaBuscada);
            }
            
            // Buscar por año (formato yyyy)
            if (preg_match('/^\d{4}$/', $busqueda)) {
                $q->orWhereYear('fecha', $busqueda);
            }
            
            // Buscar por mes en español
            $mesesEspanol = [
                'enero' => 1, 'febrero' => 2, 'marzo' => 3, 'abril' => 4,
                'mayo' => 5, 'junio' => 6, 'julio' => 7, 'agosto' => 8,
                'septiembre' => 9, 'octubre' => 10, 'noviembre' => 11, 'diciembre' => 12
            ];
            
            $busquedaLower = strtolower($busqueda);
            foreach ($mesesEspanol as $nombreMes => $numeroMes) {
                if (strpos($busquedaLower, $nombreMes) !== false) {
                    $q->orWhereMonth('fecha', $numeroMes);
                    break;
                }
            }
        });
    }
    
    // Ordenar por fecha más reciente
    $actividades = $query->orderBy('fecha', 'desc')->paginate(10);
    
    return view('dashboard-actividades-registradas', compact('actividades'));
}



    /**
     * Mostrar detalle de una actividad
     */
    public function show($id)
    {
        $actividad = Actividad::with(['creador', 'responsable', 'aprobador', 'rechazador'])
            ->findOrFail($id);
        
        // Verificar permisos
        $user = Auth::user();
        if ($user->cargo !== 'Administrador' && $actividad->tipo_area !== $user->departamento) {
            abort(403, 'No tienes permiso para ver esta actividad');
        }
        
        return view('show', compact('actividad'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
{
    $actividad = Actividad::findOrFail($id);
    
    // Verificar permisos
    $user = Auth::user();
    
    // Solo puede editar si:
    // 1. Es Admin
    // 2. Es el creador y está Pendiente o Rechazada
    // 3. Es Director de la misma área
    if ($user->cargo === 'Administrador') {
        // Admin puede editar todo
    } elseif ($actividad->creado_por_id === $user->id) {
        // El creador solo puede editar si está Pendiente o Rechazada
        if (!in_array($actividad->estado, ['Pendiente', 'Rechazada', null])) {
            return redirect()->back()
                ->with('error', 'No puedes editar una actividad que ya fue aprobada');
        }
    } elseif ($user->cargo === 'Director' && $actividad->tipo_area === $user->departamento) {
        // Director puede editar las de su área
    } else {
        abort(403, 'No tienes permiso para editar esta actividad');
    }
    
    // ✅ CONVERTIR FOTOS DE JSON STRING A ARRAY
    if ($actividad->fotos) {
        if (is_string($actividad->fotos)) {
            $actividad->fotos = json_decode($actividad->fotos, true);
        }
        // Si después de decodificar sigue siendo null o no es array, usar array vacío
        if (!is_array($actividad->fotos)) {
            $actividad->fotos = [];
        }
    } else {
        $actividad->fotos = [];
    }
    
    $usuarios = User::where('activo', 1)->get();
    
    return view('edit', compact('actividad', 'usuarios'));
}

public function update(Request $request, $id)
{
    $actividad = Actividad::findOrFail($id);
    
    // Verificar permisos
    $user = Auth::user();
    
    if ($user->cargo === 'Administrador') {
        // Admin puede actualizar todo
    } elseif ($actividad->creado_por_id === $user->id) {
        if (!in_array($actividad->estado, ['Pendiente', 'Rechazada', null])) {
            return redirect()->back()
                ->with('error', 'No puedes editar una actividad que ya fue aprobada');
        }
    } elseif ($user->cargo === 'Director' && $actividad->tipo_area === $user->departamento) {
        // Director puede actualizar
    } else {
        abort(403, 'No tienes permiso para actualizar esta actividad');
    }

    // Validación
    $request->validate([
        'titulo' => 'required|string|max:255',
        'autor' => 'nullable|string|max:255',
        'fecha' => 'required|date',
        'tipo_area' => 'required|string',
        'resumen' => 'required|string',
        'contenido' => 'required|string',
        'presupuesto' => 'nullable|numeric',
        'tipo_presupuesto' => 'nullable|string',
        'numero' => 'nullable|string',
        'fase' => 'nullable|string',
        'responsable_id' => 'nullable|exists:users,id',
        'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'cambiar_foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    // ✅ CAPTURAR VALORES ANTERIORES PARA LOG
    $valoresAntiguos = [
        'titulo' => $actividad->titulo,
        'autor' => $actividad->autor,
        'fecha' => $actividad->fecha,
        'tipo_area' => $actividad->tipo_area,
        'resumen' => $actividad->resumen,
        'contenido' => $actividad->contenido,
        'presupuesto' => $actividad->presupuesto,
        'tipo_presupuesto' => $actividad->tipo_presupuesto,
        'numero' => $actividad->numero,
        'fase' => $actividad->fase,
        'responsable_id' => $actividad->responsable_id,
    ];

    // Obtener fotos actuales
    $fotosActuales = is_array($actividad->fotos) ? $actividad->fotos : 
                     (is_string($actividad->fotos) ? json_decode($actividad->fotos, true) : []);
    
    if (!is_array($fotosActuales)) {
        $fotosActuales = [];
    }

    $cantidadFotosAntes = count($fotosActuales);
    $fotosModificadas = false;
    $fotosAgregadas = 0;
    $fotosCambiadas = 0;

    // ✅ PROCESAR FOTOS CAMBIADAS (botón "Cambiar")
    if ($request->hasFile('cambiar_foto')) {
        foreach ($request->file('cambiar_foto') as $index => $fotoNueva) {
            if ($fotoNueva && isset($fotosActuales[$index])) {
                // Eliminar foto antigua
                Storage::disk('public')->delete($fotosActuales[$index]);
                
                // Guardar foto nueva
                $filename = time() . '_' . uniqid() . '.' . $fotoNueva->getClientOriginalExtension();
                $path = $fotoNueva->storeAs('actividades/fotos', $filename, 'public');
                
                // Reemplazar en el array
                $fotosActuales[$index] = $path;
                $fotosModificadas = true;
                $fotosCambiadas++;
            }
        }
    }

    // ✅ PROCESAR FOTOS NUEVAS (agregar)
    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $foto) {
            if (count($fotosActuales) < 5) {
                $filename = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('actividades/fotos', $filename, 'public');
                $fotosActuales[] = $path;
                $fotosModificadas = true;
                $fotosAgregadas++;
            }
        }
    }

    // ✅ CAPTURAR VALORES NUEVOS
    $valoresNuevos = [
        'titulo' => $request->titulo,
        'autor' => $request->autor,
        'fecha' => $request->fecha,
        'tipo_area' => $request->tipo_area,
        'resumen' => $request->resumen,
        'contenido' => $request->contenido,
        'presupuesto' => $request->presupuesto,
        'tipo_presupuesto' => $request->tipo_presupuesto,
        'numero' => $request->numero,
        'fase' => $request->fase,
        'responsable_id' => $request->responsable_id,
    ];

    // ✅ DETECTAR QUÉ CAMPOS CAMBIARON
    $camposModificados = [];
    foreach ($valoresAntiguos as $campo => $valorAntiguo) {
        if ($valorAntiguo != $valoresNuevos[$campo]) {
            $camposModificados[] = $campo;
        }
    }

    // Actualizar la actividad
    $actividad->update([
        'titulo' => $request->titulo,
        'autor' => $request->autor,
        'fecha' => $request->fecha,
        'tipo_area' => $request->tipo_area,
        'resumen' => $request->resumen,
        'contenido' => $request->contenido,
        'presupuesto' => $request->presupuesto,
        'tipo_presupuesto' => $request->tipo_presupuesto,
        'numero' => $request->numero,
        'fase' => $request->fase,
        'fotos' => $fotosActuales,
        'responsable_id' => $request->responsable_id,
    ]);

    // Si era rechazada y se editó, volver a Pendiente
    if ($actividad->estado === 'Rechazada') {
        $actividad->update([
            'estado' => 'Pendiente',
            'rechazada_por' => null,
            'motivo_rechazo' => null,
            'fecha_rechazo' => null,
        ]);
    }

    // ✅ REGISTRAR LOG DE EDICIÓN CON DETALLES
    $descripcionLog = "Editó Actividad: " . $actividad->titulo;
    
    // Agregar detalles de qué cambió
    $detalles = [];
    
    if (!empty($camposModificados)) {
        $nombresAmigables = [
            'titulo' => 'título',
            'autor' => 'autor',
            'fecha' => 'fecha',
            'tipo_area' => 'área',
            'resumen' => 'resumen',
            'contenido' => 'descripción',
            'presupuesto' => 'presupuesto',
            'tipo_presupuesto' => 'tipo de presupuesto',
            'numero' => 'número',
            'fase' => 'fase',
            'responsable_id' => 'responsable',
        ];
        
        foreach ($camposModificados as $campo) {
            $nombreCampo = $nombresAmigables[$campo] ?? $campo;
            $detalles[] = $nombreCampo;
        }
    }
    
    if ($fotosModificadas) {
        if ($fotosAgregadas > 0) {
            $detalles[] = "agregó {$fotosAgregadas} " . ($fotosAgregadas == 1 ? 'foto' : 'fotos');
        }
        if ($fotosCambiadas > 0) {
            $detalles[] = "cambió {$fotosCambiadas} " . ($fotosCambiadas == 1 ? 'foto' : 'fotos');
        }
    }
    
    if (!empty($detalles)) {
        $descripcionLog .= " - Modificó: " . implode(', ', $detalles);
    }

    // Registrar en AuditLog
    \App\Models\AuditLog::log(
        'editar',
        $descripcionLog,
        'App\Models\Actividad',
        $actividad->id,
        $valoresAntiguos,
        $valoresNuevos
    );

return redirect()->route('actividades.show', [
    'id' => $actividad->id,
    'success' => 'Actividad actualizada exitosamente'
]);

}

    /**
     * Eliminar foto de una actividad
     */
    public function eliminarFoto(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id);
        
        $fotoIndex = $request->input('foto_index');
        $fotos = $actividad->fotos ?? [];
        
        if (isset($fotos[$fotoIndex])) {
            // Eliminar archivo físico
            Storage::disk('public')->delete($fotos[$fotoIndex]);
            
            // Eliminar del array
            unset($fotos[$fotoIndex]);
            $fotos = array_values($fotos); // Re-indexar array
            
            $actividad->update(['fotos' => $fotos]);
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 400);
    }

    public function destroy($id)
{
    $actividad = Actividad::findOrFail($id);

    // Solo Admin o el creador pueden eliminar (si está Pendiente)
    $user = Auth::user();

    if ($user->cargo !== 'Administrador') {
        if ($actividad->creado_por_id !== $user->id) {
            abort(403, 'No tienes permiso para eliminar esta actividad');
        }
        if ($actividad->estado !== 'Pendiente' && $actividad->estado !== null) {
            return redirect()->back()
                ->with('error', 'No puedes eliminar una actividad que ya fue procesada');
        }
    }

    // Normalizar fotos a array
    $fotos = $actividad->fotos;

    if (is_string($fotos) && !empty($fotos)) {
        // Si por alguna razón quedó guardado como JSON o como una sola ruta
        $decoded = json_decode($fotos, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $fotos = $decoded;
        } else {
            $fotos = [$fotos];
        }
    }

    if (!is_array($fotos)) {
        $fotos = [];
    }

    // Eliminar fotos físicas
    foreach ($fotos as $foto) {
        if ($foto && Storage::disk('public')->exists($foto)) {
            Storage::disk('public')->delete($foto);
        }
    }

    $actividad->delete();

    return redirect()->route('actividades.registradas')
        ->with('success', 'Actividad eliminada exitosamente');
}



    /**
     * Buscar actividades (para Ajax)
     */
    public function buscar(Request $request)
    {
        $query = $request->input('q');
        $user = Auth::user();
        
        $actividades = Actividad::query()
            ->when($user->cargo !== 'Administrador', function($q) use ($user) {
                return $q->where('tipo_area', $user->departamento);
            })
            ->where(function($q) use ($query) {
                $q->where('titulo', 'LIKE', "%{$query}%")
                  ->orWhere('resumen', 'LIKE', "%{$query}%")
                  ->orWhere('autor', 'LIKE', "%{$query}%");
            })
            ->with(['creador', 'responsable'])
            ->latest()
            ->take(10)
            ->get();
        
        return response()->json($actividades);
    }

    /**
     * Filtrar actividades por estado
     */
    public function filtrarPorEstado($estado)
    {
        $user = Auth::user();
        
        $actividades = Actividad::query()
            ->when($user->cargo !== 'Administrador', function($q) use ($user) {
                return $q->where('tipo_area', $user->departamento);
            })
            ->where('estado', $estado)
            ->with(['creador', 'responsable'])
            ->latest()
            ->paginate(20);
        
        return view('actividades.index', compact('actividades', 'estado'));
    }

    /**
     * Obtener actividades para calendario (Ajax)
     */
    public function calendario()
    {
        $user = Auth::user();
        
        $actividades = Actividad::query()
            ->when($user->cargo !== 'Administrador', function($q) use ($user) {
                return $q->where('tipo_area', $user->departamento);
            })
            ->select('id', 'titulo', 'fecha', 'estado', 'tipo_area')
            ->get()
            ->map(function($actividad) {
                return [
                    'id' => $actividad->id,
                    'title' => $actividad->titulo,
                    'start' => $actividad->fecha,
                    'color' => $actividad->estado === 'Aprobada' ? '#10b981' : 
                              ($actividad->estado === 'Rechazada' ? '#ef4444' : '#f59e0b'),
                ];
            });
        
        return response()->json($actividades);
    }
    /**
 * Contar actividades para el informe (solo Aprobadas)
 */
public function contarParaInforme(Request $request)
{
    $query = Actividad::where('estado', 'Aprobada');

    if ($request->filled('start') && $request->filled('end')) {
        $query->whereBetween('fecha', [$request->start, $request->end]);
    }

    if ($request->filled('areas')) {
        $areas = explode(',', $request->areas);      // ← convierte el string a array
        $areas = array_filter($areas);               // limpia vacíos
        if (!empty($areas)) {
            $query->whereIn('tipo_area', $areas);
        }
    }

    return response()->json([
        'success' => true,
        'count'   => $query->count(),
    ]);
}

    
}
