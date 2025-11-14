<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use App\Models\InformeSeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;
use App\Models\Actividad;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\NotificationHelper;

class InformeController extends Controller
{
    /**
     * Mostrar lista de informes
     */
    public function index(Request $request)
    {
        $query = Informe::query();

        if ($request->has('filtro')) {
            switch ($request->filtro) {
                case 'recientes': $query->orderBy('created_at', 'desc'); break;
                case 'antiguos': $query->orderBy('created_at', 'asc'); break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $informes = $query->paginate(10);

        $totalInformes = Informe::count();
        $informesEsteMes = Informe::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count();
        $totalDescargas = Informe::sum('descargas');
        $ultimoInforme = Informe::latest()->first()?->created_at->diffForHumans() ?? 'N/A';

        return view('dashboard-informes-generados', compact(
            'informes',
            'totalInformes',
            'informesEsteMes',
            'totalDescargas',
            'ultimoInforme'
        ));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('generar-informe', [
            'informe' => null,
            'isEdit' => false
        ]);
    }

    /**
     * Guardar nuevo informe
     */
    public function store(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');
        ini_set('max_input_vars', '5000');

        Log::info('=== INICIO STORE INFORME ===');
        Log::info('Datos recibidos:', $request->all());

        $validated = $request->validate([
            'portada_imagen' => 'required|image|max:5120',
            'plantilla_imagen' => 'nullable|image|max:5120',
            'comuna_imagen' => 'required|image|max:5120',
            
            'presidenteNombre' => 'required|string',
            'presidenteCargo' => 'required|string',
            'sindicatoNombre' => 'required|string',
            'sindicatoCargo' => 'required|string',
            'secretarioNombre' => 'required|string',
            'secretarioCargo' => 'required|string',
            
            'regidor1Nombre' => 'required|string',
            'regidor1Cargo' => 'required|string',
            'regidor2Nombre' => 'required|string',
            'regidor2Cargo' => 'required|string',
            'regidor3Nombre' => 'required|string',
            'regidor3Cargo' => 'required|string',
            'regidor4Nombre' => 'required|string',
            'regidor4Cargo' => 'required|string',
            'regidor5Nombre' => 'required|string',
            'regidor5Cargo' => 'required|string',
            'regidor6Nombre' => 'required|string',
            'regidor6Cargo' => 'required|string',
            
            'municipio_nombre' => 'required|string',
            'municipio_descripcion' => 'required|string',
            'municipio_imagen' => 'required|image',
            
            'introduccion' => 'required|string',
            'introduccion_imagen' => 'required|image',
            'gobierno_introduccion' => 'required|string',
            'gobierno_imagen' => 'required|image',
            
            'periodo_inicio' => 'required|date',
            'periodo_fin' => 'required|date|after_or_equal:periodo_inicio',
            'dependencias' => 'required|array|min:1',
        ]);

        Log::info('✅ Validación exitosa');

        try {
            Log::info('📤 Subiendo imágenes...');
            
            $portadaImagenPath = $request->file('portada_imagen')->store('informes/portadas', 'public');
            
            $plantillaPath = null;
            if ($request->hasFile('plantilla_imagen')) {
                $plantillaPath = $request->file('plantilla_imagen')->store('informes/plantillas', 'public');
            }
            
            $comunaImagenPath = $request->file('comuna_imagen')->store('informes/comuna', 'public');
            $municipioImagenPath = $request->file('municipio_imagen')->store('informes/municipio', 'public');
            $introduccionImagenPath = $request->file('introduccion_imagen')->store('informes/introduccion', 'public');
            $gobiernoImagenPath = $request->file('gobierno_imagen')->store('informes/gobierno', 'public');

            Log::info('✅ Imágenes subidas correctamente');

            $slug = 'informe-' . now()->format('Y-m-d-His');
            $contador = 1;
            while (Informe::where('slug', $slug)->exists()) {
                $slug = 'informe-' . now()->format('Y-m-d-His') . '-' . $contador;
                $contador++;
            }

            Log::info('🔑 Slug generado: ' . $slug);

            $informe = Informe::create([
                'user_id' => Auth::id(),
                'slug' => $slug,
                'portada_imagen_path' => $portadaImagenPath,
                'plantilla_imagen_path' => $plantillaPath,
                'comuna_imagen_path' => $comunaImagenPath,
                
                'presidente_nombre' => $validated['presidenteNombre'],
                'presidente_cargo' => $validated['presidenteCargo'],
                'sindicato_nombre' => $validated['sindicatoNombre'],
                'sindicato_cargo' => $validated['sindicatoCargo'],
                'secretario_nombre' => $validated['secretarioNombre'],
                'secretario_cargo' => $validated['secretarioCargo'],
                
                'regidores' => [
                    ['nombre' => $validated['regidor1Nombre'], 'cargo' => $validated['regidor1Cargo']],
                    ['nombre' => $validated['regidor2Nombre'], 'cargo' => $validated['regidor2Cargo']],
                    ['nombre' => $validated['regidor3Nombre'], 'cargo' => $validated['regidor3Cargo']],
                    ['nombre' => $validated['regidor4Nombre'], 'cargo' => $validated['regidor4Cargo']],
                    ['nombre' => $validated['regidor5Nombre'], 'cargo' => $validated['regidor5Cargo']],
                    ['nombre' => $validated['regidor6Nombre'], 'cargo' => $validated['regidor6Cargo']],
                ],
                
                'municipio_nombre' => $validated['municipio_nombre'],
                'municipio_descripcion' => $validated['municipio_descripcion'],
                'municipio_imagen_path' => $municipioImagenPath,
                
                'introduccion' => $validated['introduccion'],
                'introduccion_imagen_path' => $introduccionImagenPath,
                'gobierno_introduccion' => $validated['gobierno_introduccion'],
                'gobierno_imagen_path' => $gobiernoImagenPath,
                
                'actividades_fecha_inicio' => $validated['periodo_inicio'],
                'actividades_fecha_fin' => $validated['periodo_fin'],
                'dependencias_seleccionadas' => $validated['dependencias'],
                'descargas' => 0,
            ]);

            Log::info('✅ Informe creado con ID: ' . $informe->id);
            Log::info('Datos guardados:', $informe->toArray());

            $actividades = $informe->getActividadesFiltradas();
            $actividades = $actividades->sortBy('tipo_area');
            Log::info('📊 Actividades para PDF: ' . $actividades->count());

            $this->generarPDFConMPdf($informe, $actividades);

            Log::info('✅ PDF generado exitosamente');

            return redirect()->route('informes-generados')
                ->with('success', 'Informe generado exitosamente');
            // ✅ NOTIFICACIONES: Nuevo informe generado
            
            // Notificar a roles que pueden ver informes
            $roles = ['Administrador', 'Presidente Municipal', 'Síndico Procurador', 'Regidor', 'Director de Área'];
            
            foreach ($roles as $rol) {
                NotificationHelper::sendToRole(
                    $rol,
                    'informe',
                    'Nuevo informe generado',
                    Auth::user()->name . ' ha generado el informe: ' . $informe->titulo . ' (' . $informe->periodo . ')',
                    [
                        'link' => route('informes-generados'),
                        'icon' => 'ri-file-list-line',
                        'color' => 'green',
                        'data' => ['informe_id' => $informe->id]
                    ]
                );
            }

            return redirect('/dashboard-informes-generados')
                ->with('success', 'Informe creado exitosamente');

        } catch (\Exception $e) {
            Log::error('❌ ERROR en store: ' . $e->getMessage());
            Log::error('Línea: ' . $e->getLine());
            Log::error('Stack: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withErrors(['error' => 'Error al crear el informe: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function generar(Request $request) 
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        $data = $request->validate([
            'periodo_inicio' => ['required','date','date_format:Y-m-d'],
            'periodo_fin'    => ['required','date','date_format:Y-m-d','after_or_equal:periodo_inicio'],
            'periodo_tipo'   => ['required','in:anio,semestre,mes'],
            'dependencias'   => ['nullable','array'],
            'dependencias.*' => ['string'],
        ]);

        try {
            $q = Actividad::query()->whereBetween('fecha', [$data['periodo_inicio'], $data['periodo_fin']]);
            if (!empty($data['dependencias'])) {
                $q->whereIn('tipo_area', $data['dependencias']);
            }
            $actividades = $q->orderBy('fecha')->get();
            $actividades = $actividades->sortBy('tipo_area');

            Log::info('📊 Actividades encontradas: ' . $actividades->count());

            $slugBase = 'informe-actividades-' . now()->format('Y-m-d-His');
            $slug = $slugBase; 
            $i = 1;
            while (Informe::where('slug', $slug)->exists()) {
                $slug = $slugBase . '-' . $i++;
            }

            $informe = Informe::create([
                'user_id' => $request->user()->id,
                'slug'    => $slug,
                'presidente_nombre'         => 'N/D',
                'presidente_cargo'          => 'N/D',
                'sindicato_nombre'          => 'N/D',
                'sindicato_cargo'           => 'N/D',
                'secretario_nombre'         => 'N/D',
                'secretario_cargo'          => 'N/D',
                'regidores'                 => [],
                'municipio_nombre'          => 'N/D',
                'municipio_descripcion'     => '',
                'introduccion'              => '',
                'gobierno_introduccion'     => '',
                'actividades_fecha_inicio'  => $data['periodo_inicio'],
                'actividades_fecha_fin'     => $data['periodo_fin'],
                'dependencias_seleccionadas' => $data['dependencias'] ?? [],
                'descargas' => 0,
            ]);

            Log::info('✅ Informe creado con ID: ' . $informe->id);

            $this->generarPDFConMPdf($informe, $actividades);

            return redirect()->route('informes-generados')
                ->with('success', 'Informe de actividades generado correctamente');
                
        } catch (\Exception $e) {
            Log::error('❌ Error al generar informe de actividades: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withErrors(['error' => 'Error al generar el informe: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Mostrar detalle de informe
     */
    public function show($slug)
    {
        $informe = Informe::where('slug', $slug)->firstOrFail();
        return view('informes.show', compact('informe'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $informe = Informe::findOrFail($id);
        
        return view('generar-informe', [
            'informe' => $informe,
            'isEdit' => true
        ]);
        // Solo el creador o administrador puede editar
        if ($informe->user_id !== Auth::id() && !Auth::user()->hasRole('Administrador')) {
            abort(403, 'No tienes permiso para editar este informe');
        }
        
        return view('informes.edit', compact('informe'));
    }

    /**
     * Actualizar informe
     */
    public function update(Request $request, Informe $informe)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');
        ini_set('max_input_vars', '5000');

        Log::info('=== INICIO UPDATE INFORME ID: ' . $id . ' ===');
        // Verificar permisos
        if ($informe->user_id !== Auth::id() && !Auth::user()->hasRole('Administrador')) {
            abort(403, 'No tienes permiso para editar este informe');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'periodo' => 'required|string|max:100',
            'portada' => 'nullable|image|max:2048',
            
            // Comuna
            'presidenteNombre' => 'required|string',
            'presidenteCargo' => 'required|string',
            'sindicatoNombre' => 'required|string',
            'sindicatoCargo' => 'required|string',
            'secretarioNombre' => 'required|string',
            'secretarioCargo' => 'required|string',
            
            // Municipio
            'municipio_nombre' => 'required|string',
            'municipio_descripcion' => 'required|string',
            'municipio_imagen' => 'nullable|image|max:2048',
            
            // Introducciones
            'introduccion' => 'required|string',
            'introduccion_imagen' => 'nullable|image|max:2048',
            'gobierno_introduccion' => 'required|string',
            'gobierno_imagen' => 'nullable|image|max:2048',
            
            // Actividades
            'actividades_fecha_inicio' => 'required|date',
            'actividades_fecha_fin' => 'required|date|after_or_equal:actividades_fecha_inicio',
            'dependencias' => 'required|array|min:1',
        ]);

        try {
            // Detectar cambios importantes
            $cambios = [];
            
            if ($informe->titulo !== $validated['titulo']) {
                $cambios[] = 'Título modificado';
            }
            
            $validated = $request->validate([
                'portada_imagen' => 'nullable|image|max:5120',
                'plantilla_imagen' => 'nullable|image|max:5120',
                'comuna_imagen' => 'nullable|image|max:5120',
                
                'presidenteNombre' => 'required|string',
                'presidenteCargo' => 'required|string',
                'sindicatoNombre' => 'required|string',
                'sindicatoCargo' => 'required|string',
                'secretarioNombre' => 'required|string',
                'secretarioCargo' => 'required|string',
                
                'regidor1Nombre' => 'required|string',
                'regidor1Cargo' => 'required|string',
                'regidor2Nombre' => 'required|string',
                'regidor2Cargo' => 'required|string',
                'regidor3Nombre' => 'required|string',
                'regidor3Cargo' => 'required|string',
                'regidor4Nombre' => 'required|string',
                'regidor4Cargo' => 'required|string',
                'regidor5Nombre' => 'required|string',
                'regidor5Cargo' => 'required|string',
                'regidor6Nombre' => 'required|string',
                'regidor6Cargo' => 'required|string',
                
                'municipio_nombre' => 'required|string',
                'municipio_descripcion' => 'required|string',
                'municipio_imagen' => 'nullable|image|max:5120',
                
                'introduccion' => 'required|string',
                'introduccion_imagen' => 'nullable|image|max:5120',
                'gobierno_introduccion' => 'required|string',
                'gobierno_imagen' => 'nullable|image|max:5120',
                
                'periodo_inicio' => 'required|date',
                'periodo_fin' => 'required|date|after_or_equal:periodo_inicio',
                'dependencias' => 'required|array|min:1',
            if ($informe->periodo !== $validated['periodo']) {
                $cambios[] = 'Periodo actualizado: ' . $validated['periodo'];
            }

            // Actualizar imágenes si se subieron nuevas
            if($request->hasFile('portada')){
                if($informe->portada_path) Storage::disk('public')->delete($informe->portada_path);
                $validated['portada_path'] = $request->file('portada')->store('informes/portadas', 'public');
            }
            if($request->hasFile('municipio_imagen')){
                if($informe->municipio_imagen_path) Storage::disk('public')->delete($informe->municipio_imagen_path);
                $validated['municipio_imagen_path'] = $request->file('municipio_imagen')->store('informes/municipio', 'public');
            }
            if($request->hasFile('introduccion_imagen')){
                if($informe->introduccion_imagen_path) Storage::disk('public')->delete($informe->introduccion_imagen_path);
                $validated['introduccion_imagen_path'] = $request->file('introduccion_imagen')->store('informes/introduccion', 'public');
            }
            if($request->hasFile('gobierno_imagen')){
                if($informe->gobierno_imagen_path) Storage::disk('public')->delete($informe->gobierno_imagen_path);
                $validated['gobierno_imagen_path'] = $request->file('gobierno_imagen')->store('informes/gobierno', 'public');
            }

            // Actualizar datos
            $informe->update([
                'titulo' => $validated['titulo'],
                'periodo' => $validated['periodo'],
                'presidente_nombre' => $validated['presidenteNombre'],
                'presidente_cargo' => $validated['presidenteCargo'],
                'sindicato_nombre' => $validated['sindicatoNombre'],
                'sindicato_cargo' => $validated['sindicatoCargo'],
                'secretario_nombre' => $validated['secretarioNombre'],
                'secretario_cargo' => $validated['secretarioCargo'],
                'municipio_nombre' => $validated['municipio_nombre'],
                'municipio_descripcion' => $validated['municipio_descripcion'],
                'introduccion' => $validated['introduccion'],
                'gobierno_introduccion' => $validated['gobierno_introduccion'],
                'actividades_fecha_inicio' => $validated['actividades_fecha_inicio'],
                'actividades_fecha_fin' => $validated['actividades_fecha_fin'],
                'dependencias_seleccionadas' => $validated['dependencias'],
            ]);

            Log::info('✅ Validación exitosa');

            // Actualizar imágenes solo si se suben nuevas
            if ($request->hasFile('portada_imagen')) {
                if ($informe->portada_imagen_path) {
                    Storage::disk('public')->delete($informe->portada_imagen_path);
                }
                $informe->portada_imagen_path = $request->file('portada_imagen')
                    ->store('informes/portadas', 'public');
                Log::info('✅ Nueva portada subida');
            }

            if ($request->hasFile('plantilla_imagen')) {
                if ($informe->plantilla_imagen_path) {
                    Storage::disk('public')->delete($informe->plantilla_imagen_path);
                }
                $informe->plantilla_imagen_path = $request->file('plantilla_imagen')
                    ->store('informes/plantillas', 'public');
                Log::info('✅ Nueva plantilla subida');
            }

            if ($request->hasFile('comuna_imagen')) {
                if ($informe->comuna_imagen_path) {
                    Storage::disk('public')->delete($informe->comuna_imagen_path);
                }
                $informe->comuna_imagen_path = $request->file('comuna_imagen')
                    ->store('informes/comuna', 'public');
                Log::info('✅ Nueva imagen de comuna subida');
            }

            if ($request->hasFile('municipio_imagen')) {
                if ($informe->municipio_imagen_path) {
                    Storage::disk('public')->delete($informe->municipio_imagen_path);
                }
                $informe->municipio_imagen_path = $request->file('municipio_imagen')
                    ->store('informes/municipio', 'public');
                Log::info('✅ Nueva imagen de municipio subida');
            }

            if ($request->hasFile('introduccion_imagen')) {
                if ($informe->introduccion_imagen_path) {
                    Storage::disk('public')->delete($informe->introduccion_imagen_path);
                }
                $informe->introduccion_imagen_path = $request->file('introduccion_imagen')
                    ->store('informes/introduccion', 'public');
                Log::info('✅ Nueva imagen de introducción subida');
            }

            if ($request->hasFile('gobierno_imagen')) {
                if ($informe->gobierno_imagen_path) {
                    Storage::disk('public')->delete($informe->gobierno_imagen_path);
                }
                $informe->gobierno_imagen_path = $request->file('gobierno_imagen')
                    ->store('informes/gobierno', 'public');
                Log::info('✅ Nueva imagen de gobierno subida');
            }

            // Actualizar todos los campos
            $informe->presidente_nombre = $validated['presidenteNombre'];
            $informe->presidente_cargo = $validated['presidenteCargo'];
            $informe->sindicato_nombre = $validated['sindicatoNombre'];
            $informe->sindicato_cargo = $validated['sindicatoCargo'];
            $informe->secretario_nombre = $validated['secretarioNombre'];
            $informe->secretario_cargo = $validated['secretarioCargo'];
            
            $informe->regidores = [
                ['nombre' => $validated['regidor1Nombre'], 'cargo' => $validated['regidor1Cargo']],
                ['nombre' => $validated['regidor2Nombre'], 'cargo' => $validated['regidor2Cargo']],
                ['nombre' => $validated['regidor3Nombre'], 'cargo' => $validated['regidor3Cargo']],
                ['nombre' => $validated['regidor4Nombre'], 'cargo' => $validated['regidor4Cargo']],
                ['nombre' => $validated['regidor5Nombre'], 'cargo' => $validated['regidor5Cargo']],
                ['nombre' => $validated['regidor6Nombre'], 'cargo' => $validated['regidor6Cargo']],
            ];
            
            $informe->municipio_nombre = $validated['municipio_nombre'];
            $informe->municipio_descripcion = $validated['municipio_descripcion'];
            $informe->introduccion = $validated['introduccion'];
            $informe->gobierno_introduccion = $validated['gobierno_introduccion'];
            $informe->actividades_fecha_inicio = $validated['periodo_inicio'];
            $informe->actividades_fecha_fin = $validated['periodo_fin'];
            $informe->dependencias_seleccionadas = $validated['dependencias'];

            $informe->save();
            
            Log::info('✅ Informe actualizado en BD');

            $actividades = $informe->getActividadesFiltradas();
            $actividades = $actividades->sortBy('tipo_area');
            Log::info('📊 Actividades para PDF actualizado: ' . $actividades->count());
            
            $this->generarPDFConMPdf($informe, $actividades);
            
            Log::info('✅ PDF regenerado exitosamente');

            // ✅ MENSAJE PERSONALIZADO AL EDITAR
            return redirect()->route('informes-generados')
                ->with('success', 'Informe editado exitosamente');
            // ✅ NOTIFICACIONES: Informe actualizado (solo si hay cambios importantes)
            if (!empty($cambios)) {
                
                // Notificar a administradores y presidente
                NotificationHelper::sendToRole(
                    'Administrador',
                    'informe',
                    'Informe actualizado',
                    Auth::user()->name . ' ha actualizado el informe: ' . $informe->titulo . 
                    '. Cambios: ' . implode(', ', $cambios),
                    [
                        'link' => route('informes-generados'),
                        'icon' => 'ri-edit-line',
                        'color' => 'yellow',
                        'data' => ['informe_id' => $informe->id]
                    ]
                );

                NotificationHelper::sendToRole(
                    'Presidente Municipal',
                    'informe',
                    'Informe actualizado',
                    'El informe "' . $informe->titulo . '" ha sido actualizado',
                    [
                        'link' => route('informes-generados'),
                        'icon' => 'ri-edit-line',
                        'color' => 'yellow',
                        'data' => ['informe_id' => $informe->id]
                    ]
                );
            }

            return redirect('/dashboard-informes-generados')
                ->with('success', 'Informe actualizado correctamente');

        } catch (\Exception $e) {
            Log::error('❌ ERROR al actualizar informe: ' . $e->getMessage());
            Log::error('Línea: ' . $e->getLine());
            Log::error('Stack: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withErrors(['error' => 'Error al actualizar el informe: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Eliminar informe
     */
    public function destroy($id)
    {
        try {
            $informe = Informe::findOrFail($id);
            
            // Eliminar imágenes del storage
            if ($informe->portada_imagen_path) {
                Storage::disk('public')->delete($informe->portada_imagen_path);
            }
            if ($informe->plantilla_imagen_path) {
                Storage::disk('public')->delete($informe->plantilla_imagen_path);
            }
            if ($informe->comuna_imagen_path) {
                Storage::disk('public')->delete($informe->comuna_imagen_path);
            }
            if ($informe->municipio_imagen_path) {
                Storage::disk('public')->delete($informe->municipio_imagen_path);
            }
            if ($informe->introduccion_imagen_path) {
                Storage::disk('public')->delete($informe->introduccion_imagen_path);
            }
            if ($informe->gobierno_imagen_path) {
                Storage::disk('public')->delete($informe->gobierno_imagen_path);
            }
            if ($informe->pdf_path) {
                Storage::disk('public')->delete($informe->pdf_path);
            }
            
            $informe->delete();
            
            return redirect()->route('informes-generados')
                ->with('success', 'Informe eliminado exitosamente');
                
        } catch (\Exception $e) {
            Log::error('Error al eliminar informe: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar el informe']);
        }
    }

            $tituloInforme = $informe->titulo;
            $userId = $informe->user_id;

            // Solo el creador o administrador puede eliminar
            if ($informe->user_id !== Auth::id() && !Auth::user()->hasRole('Administrador')) {
                abort(403, 'No tienes permiso para eliminar este informe');
            }

        // Eliminar archivos físicos
        $archivos = [
            $informe->portada_path,
            $informe->plantilla_imagen_path,
            $informe->municipio_imagen_path,
            $informe->introduccion_imagen_path,
            $informe->gobierno_imagen_path,
            $informe->pdf_path
        ];

            $informe->delete();

            // ✅ NOTIFICACIONES: Informe eliminado
            
            // Notificar al creador (si no es quien eliminó)
            if ($userId && $userId !== Auth::id()) {
                NotificationHelper::send(
                    $userId,
                    'informe',
                    'Tu informe fue eliminado',
                    'Tu informe "' . $tituloInforme . '" ha sido eliminado del sistema por ' . Auth::user()->name,
                    [
                        'icon' => 'ri-delete-bin-line',
                        'color' => 'red'
                    ]
                );
            }

            // Notificar a administradores
            NotificationHelper::sendToRole(
                'Administrador',
                'informe',
                'Informe eliminado',
                Auth::user()->name . ' ha eliminado el informe: ' . $tituloInforme,
                [
                    'icon' => 'ri-delete-bin-line',
                    'color' => 'red'
                ]
            );

            return redirect('/dashboard-informes-generados')
                ->with('success', 'Informe eliminado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar informe: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar el informe: ' . $e->getMessage()]);
        }

        // 🔥 ELIMINAR FÍSICAMENTE (no soft delete)
        $informe->forceDelete();

        return redirect()->route('informes-generados')
            ->with('success', '✅ Informe eliminado correctamente');

    } catch (\Exception $e) {
        Log::error('Error al eliminar informe: ' . $e->getMessage());
        
        return redirect()->back()
            ->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
    }
}

    /**
     * Descargar PDF por ID
     */
    public function downloadById($id)
    {
        try {
            $informe = Informe::findOrFail($id);
            
            if (!$informe->pdf_path) {
                Log::error('Informe sin PDF: ' . $id);
                abort(404, 'PDF no encontrado');
            }
            
            $filePath = storage_path('app/public/' . $informe->pdf_path);
            
            if (!file_exists($filePath)) {
                Log::error('Archivo no existe: ' . $filePath);
                abort(404, 'Archivo no encontrado');
            }
            
            $informe->increment('descargas');
            
            return response()->download(
                $filePath,
                'informe_' . $informe->id . '.pdf',
                ['Content-Type' => 'application/pdf']
            );
            
        } catch (\Exception $e) {
            Log::error('Error downloadById: ' . $e->getMessage());
            abort(500, 'Error al descargar');
        }
    }

    /**
     * Obtener contador de descargas
     */
    public function getDownloadCount($id)
    {
        try {
            $informe = Informe::findOrFail($id);
            return response()->json([
                'success' => true,
                'descargas' => $informe->descargas
            ]);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], 404);
        }
    }

    /**
     * Obtener estadísticas
     */
    public function getStats()
    {
        $totalDescargas = Informe::sum('descargas');
        return response()->json([
            'success' => true,
            'totalDescargas' => $totalDescargas
        ]);
    }

    /**
     * Generar PDF automático
     */
    private function generarPDFAutomatico($informe)
    {
        try {
            $totalDescargas = Informe::sum('descargas');
            $totalInformes = Informe::count();
            return response()->json([
                'success' => true,
                'totalDescargas' => $totalDescargas,
                'totalInformes' => $totalInformes
            $pdf = PDF::loadView('informes.pdf', compact('informe'));

            $pdf->setPaper('letter', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'chroot' => storage_path('app/public'),
            ]);

            $dirPath = storage_path('app/public/pdfs');
            if (!file_exists($dirPath)) {
                mkdir($dirPath, 0755, true);
            }

            $pdfPath = 'pdfs/informe_' . $informe->id . '_' . time() . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdf->output());

            $informe->update(['pdf_path' => $pdfPath]);

            Log::info('PDF generado correctamente: ' . $pdfPath);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], 500);
            Log::error('Error al generar PDF: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            return false;
        }
    }

    public function preview($id)
    {
        try {
            $informe = Informe::with('secciones')->findOrFail($id);
            
            if (!$informe->pdf_path) {
                abort(404, 'PDF no generado aún');
            }
            
            $filePath = storage_path('app/public/' . $informe->pdf_path);
            
            if (!file_exists($filePath)) {
                abort(404, 'Archivo no encontrado');
            }
            
            return response()->file($filePath);
            
        } catch (\Exception $e) {
            Log::error('Error en preview: ' . $e->getMessage());
            abort(500, 'Error');
        }
    }

    public function testPdf($id)
    {
        $informe = Informe::findOrFail($id);
        return view('informes.pdf', compact('informe'));
    }

    public function agregarSeccion(Request $request, $informeId)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'nullable|string',
            'nivel' => 'required|integer|min:1|max:3',
            'pagina' => 'nullable|integer|min:1'
        ]);
        
        $informe = Informe::findOrFail($informeId);
        $validated['orden'] = $informe->secciones()->max('orden') + 1;
        $informe->secciones()->create($validated);
        
        return redirect()->back()->with('success', 'Sección agregada');
    }

    public function eliminarSeccion($informeId, $seccionId)
    {
        $seccion = InformeSeccion::where('informe_id', $informeId)
                                 ->where('id', $seccionId)
                                 ->firstOrFail();
        
        $seccion->delete();
        
        return redirect()->back()->with('success', 'Sección eliminada');
    }

    private function generarPDFConMPdf($informe, $actividades = null)
    {
        try {
            ini_set('memory_limit', '512M');
            ini_set('max_execution_time', '300');

            $tempDir = storage_path('app/temp');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $pdfDir = storage_path('app/public/pdfs');
            if (!is_dir($pdfDir)) {
                mkdir($pdfDir, 0777, true);
            }
            
            $pdfPath = 'pdfs/informe_' . $informe->id . '.pdf';
            $fullPath = storage_path('app/public/' . $pdfPath);
            
            Log::info('📍 Ruta del PDF: ' . $fullPath);
            
            if (file_exists($fullPath)) {
                unlink($fullPath);
                Log::info('🗑️ PDF anterior eliminado');
            }
            
            if ($actividades === null) {
                $actividades = $informe->getActividadesFiltradas();
            }
            $actividades = $actividades->sortBy('tipo_area');
            
            Log::info('🔄 Renderizando HTML con ' . $actividades->count() . ' actividades...');
            $html = view('informes.pdf', compact('informe', 'actividades'))->render();
            Log::info('✅ HTML renderizado');
            
            Log::info('🔧 Creando mPDF...');
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'Letter',
                'orientation' => 'P',
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
                'tempDir' => $tempDir,
            ]);
            Log::info('✅ mPDF creado');
            $mpdf->h2toc = ['H1' => 0, 'H2' => 1, 'H3' => 2];
            $mpdf->h2bookmarks = ['H1' => 0, 'H2' => 1, 'H3' => 2];
            
            $mpdf->shrink_tables_to_fit = 1;
            $mpdf->SetCompression(true);
            $mpdf->simpleTables = true;
            
            Log::info('📝 Escribiendo HTML en PDF...');
            $mpdf->WriteHTML($html);
            Log::info('✅ HTML escrito');
            
            Log::info('💾 Guardando PDF a archivo...');
            $mpdf->Output($fullPath, 'F');
            Log::info('✅ PDF guardado');
            
            if (!file_exists($fullPath)) {
                throw new \Exception('El archivo no se creó en: ' . $fullPath);
            }
            
            Log::info('✅ Archivo verificado, actualizando BD...');
            $informe->update(['pdf_path' => $pdfPath]);
            Log::info('✅✅✅ PDF GENERADO EXITOSAMENTE');
            
        } catch (\Exception $e) {
            Log::error('❌ ERROR EN generarPDFConMPdf: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            throw $e;
        }
    }
}
