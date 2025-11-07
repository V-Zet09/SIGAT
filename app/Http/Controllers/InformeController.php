<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
        return view('generar-informe');
    }

    /**
     * Guardar nuevo informe
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'periodo' => 'required|string',
            'portada' => 'required|image|max:2048',
            
            // Comuna
            'presidenteNombre' => 'required|string',
            'presidenteCargo' => 'required|string',
            'sindicatoNombre' => 'required|string',
            'sindicatoCargo' => 'required|string',
            'secretarioNombre' => 'required|string',
            'secretarioCargo' => 'required|string',
            
            // Regidores
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
            
            // Municipio
            'municipio_nombre' => 'required|string',
            'municipio_descripcion' => 'required|string',
            'municipio_imagen' => 'required|image',
            
            // Introducciones
            'introduccion' => 'required|string',
            'introduccion_imagen' => 'required|image',
            'gobierno_introduccion' => 'required|string',
            'gobierno_imagen' => 'required|image',
            
            // Actividades (filtros)
            'actividades_fecha_inicio' => 'required|date',
            'actividades_fecha_fin' => 'required|date|after_or_equal:actividades_fecha_inicio',
            'dependencias' => 'required|array|min:1',
        ]);

        try {
            // Guardar archivos
            $portadaPath = $request->file('portada')->store('informes/portadas', 'public');
            $municipioImagenPath = $request->file('municipio_imagen')->store('informes/municipio', 'public');
            $introduccionImagenPath = $request->file('introduccion_imagen')->store('informes/introduccion', 'public');
            $gobiernoImagenPath = $request->file('gobierno_imagen')->store('informes/gobierno', 'public');

            // Generar slug único
            $slug = Str::slug($validated['titulo'] . '-' . $validated['periodo']);
            $slugOriginal = $slug;
            $contador = 1;
            while (Informe::where('slug', $slug)->exists()) {
                $slug = $slugOriginal . '-' . $contador;
                $contador++;
            }

            // Crear informe
            $informe = Informe::create([
                'user_id' => Auth::id(),
                'titulo' => $validated['titulo'],
                'periodo' => $validated['periodo'],
                'slug' => $slug,
                'portada_path' => $portadaPath,
                
                // Comuna
                'presidente_nombre' => $validated['presidenteNombre'],
                'presidente_cargo' => $validated['presidenteCargo'],
                'sindicato_nombre' => $validated['sindicatoNombre'],
                'sindicato_cargo' => $validated['sindicatoCargo'],
                'secretario_nombre' => $validated['secretarioNombre'],
                'secretario_cargo' => $validated['secretarioCargo'],
                
                // Regidores
                'regidores' => [
                    ['nombre' => $validated['regidor1Nombre'], 'cargo' => $validated['regidor1Cargo']],
                    ['nombre' => $validated['regidor2Nombre'], 'cargo' => $validated['regidor2Cargo']],
                    ['nombre' => $validated['regidor3Nombre'], 'cargo' => $validated['regidor3Cargo']],
                    ['nombre' => $validated['regidor4Nombre'], 'cargo' => $validated['regidor4Cargo']],
                    ['nombre' => $validated['regidor5Nombre'], 'cargo' => $validated['regidor5Cargo']],
                    ['nombre' => $validated['regidor6Nombre'], 'cargo' => $validated['regidor6Cargo']],
                ],
                
                // Municipio
                'municipio_nombre' => $validated['municipio_nombre'],
                'municipio_descripcion' => $validated['municipio_descripcion'],
                'municipio_imagen_path' => $municipioImagenPath,
                
                // Introducciones
                'introduccion' => $validated['introduccion'],
                'introduccion_imagen_path' => $introduccionImagenPath,
                'gobierno_introduccion' => $validated['gobierno_introduccion'],
                'gobierno_imagen_path' => $gobiernoImagenPath,
                
                // Filtros de actividades
                'actividades_fecha_inicio' => $validated['actividades_fecha_inicio'],
                'actividades_fecha_fin' => $validated['actividades_fecha_fin'],
                'dependencias_seleccionadas' => $validated['dependencias'],
            ]);

            // Generar PDF automáticamente
            $this->generarPDFAutomatico($informe);

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
            Log::error('Error al crear informe: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Error al crear el informe: ' . $e->getMessage()])
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

            // Regenerar PDF
            $this->generarPDFAutomatico($informe);

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
            Log::error('Error al actualizar informe: ' . $e->getMessage());
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
            $tituloInforme = $informe->titulo;
            $userId = $informe->user_id;

            // Solo el creador o administrador puede eliminar
            if ($informe->user_id !== Auth::id() && !Auth::user()->hasRole('Administrador')) {
                abort(403, 'No tienes permiso para eliminar este informe');
            }

            // Eliminar archivos
            if ($informe->portada_path) Storage::disk('public')->delete($informe->portada_path);
            if ($informe->municipio_imagen_path) Storage::disk('public')->delete($informe->municipio_imagen_path);
            if ($informe->introduccion_imagen_path) Storage::disk('public')->delete($informe->introduccion_imagen_path);
            if ($informe->gobierno_imagen_path) Storage::disk('public')->delete($informe->gobierno_imagen_path);
            if ($informe->pdf_path) Storage::disk('public')->delete($informe->pdf_path);

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
    }

    /**
     * Descargar PDF por ID
     */
    public function downloadById($id)
    {
        try {
            $informe = Informe::findOrFail($id);
            
            Log::info('Descargando PDF - ID: ' . $id);
            Log::info('PDF Path: ' . ($informe->pdf_path ?? 'NULL'));
            
            if (empty($informe->pdf_path)) {
                Log::error('pdf_path está vacío');
                abort(404, 'PDF no encontrado - sin ruta');
            }
            
            if (!Storage::disk('public')->exists($informe->pdf_path)) {
                Log::error('Archivo no existe: ' . $informe->pdf_path);
                abort(404, 'PDF no encontrado - archivo no existe');
            }
            
            // Incrementar contador de descargas
            $informe->increment('descargas');
            
            $filePath = storage_path('app/public/' . $informe->pdf_path);
            $fileName = 'informe_' . $informe->id . '.pdf';
            
            Log::info('Descarga exitosa - Descargas totales: ' . $informe->descargas);
            
            return response()->download($filePath, $fileName);
            
        } catch (\Exception $e) {
            Log::error('Error en downloadById: ' . $e->getMessage());
            abort(500, 'Error al descargar: ' . $e->getMessage());
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
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener contador'
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
            $pdf = PDF::loadView('informes.pdf', compact('informe'));

            $pdf->setPaper('letter', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial',
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
            Log::error('Error al generar PDF: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            return false;
        }
    }
}