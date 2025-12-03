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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\NotificationHelper;
use App\Models\AuditLog; // ← AGREGADO

class InformeController extends Controller
{
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
        $informesEsteMes = Informe::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
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

    public function create()
    {
        return view('generar-informe', [
            'informe' => null,
            'isEdit' => false
        ]);
    }

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

            // ✅ REGISTRAR LOG DE CREACIÓN DE INFORME
            AuditLog::log(
                action: 'crear',
                description: "Generó informe del municipio: {$validated['municipio_nombre']} - Período: {$validated['periodo_inicio']} a {$validated['periodo_fin']}",
                modelType: 'App\Models\Informe',
                modelId: $informe->id,
                newValues: [
                    'municipio' => $validated['municipio_nombre'],
                    'periodo' => $validated['periodo_inicio'] . ' - ' . $validated['periodo_fin'],
                    'dependencias' => count($validated['dependencias']),
                    'actividades' => $actividades->count()
                ]
            );

            // Notificar a roles que pueden ver informes
            $roles = ['Administrador', 'Presidente Municipal', 'Síndico Procurador', 'Regidor', 'Director de Área'];
            foreach ($roles as $rol) {
                NotificationHelper::sendToRole(
                    $rol,
                    'informe',
                    'Nuevo informe generado',
                    Auth::user()->name . ' ha generado un informe',
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

    public function edit($id)
    {
        $informe = Informe::findOrFail($id);

        // Verificar permiso
        if ($informe->user_id !== Auth::id() && !Auth::user()->hasRole('Administrador')) {
            abort(403, 'No tienes permiso para editar este informe');
        }

        return view('generar-informe', [
            'informe' => $informe,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, Informe $informe)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');
        ini_set('max_input_vars', '5000');

        Log::info('=== INICIO UPDATE INFORME ID: ' . $informe->id . ' ===');

        // Verificar permisos
        if ($informe->user_id !== Auth::id() && !Auth::user()->hasRole('Administrador')) {
            abort(403, 'No tienes permiso para editar este informe');
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
        ]);

        try {
            // Actualizar imágenes si se suben nuevas
            if ($request->hasFile('portada_imagen')) {
                if (!empty($informe->portada_imagen_path)) {
                    Storage::disk('public')->delete($informe->portada_imagen_path);
                }
                $informe->portada_imagen_path = $request->file('portada_imagen')->store('informes/portadas', 'public');
            }
            if ($request->hasFile('plantilla_imagen')) {
                if (!empty($informe->plantilla_imagen_path)) {
                    Storage::disk('public')->delete($informe->plantilla_imagen_path);
                }
                $informe->plantilla_imagen_path = $request->file('plantilla_imagen')->store('informes/plantillas', 'public');
            }
            if ($request->hasFile('comuna_imagen')) {
                if (!empty($informe->comuna_imagen_path)) {
                    Storage::disk('public')->delete($informe->comuna_imagen_path);
                }
                $informe->comuna_imagen_path = $request->file('comuna_imagen')->store('informes/comuna', 'public');
            }
            if ($request->hasFile('municipio_imagen')) {
                if (!empty($informe->municipio_imagen_path)) {
                    Storage::disk('public')->delete($informe->municipio_imagen_path);
                }
                $informe->municipio_imagen_path = $request->file('municipio_imagen')->store('informes/municipio', 'public');
            }
            if ($request->hasFile('introduccion_imagen')) {
                if (!empty($informe->introduccion_imagen_path)) {
                    Storage::disk('public')->delete($informe->introduccion_imagen_path);
                }
                $informe->introduccion_imagen_path = $request->file('introduccion_imagen')->store('informes/introduccion', 'public');
            }
            if ($request->hasFile('gobierno_imagen')) {
                if (!empty($informe->gobierno_imagen_path)) {
                    Storage::disk('public')->delete($informe->gobierno_imagen_path);
                }
                $informe->gobierno_imagen_path = $request->file('gobierno_imagen')->store('informes/gobierno', 'public');
            }

            // Actualizar datos principales
            $informe->update([
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
                'actividades_fecha_inicio' => $validated['periodo_inicio'],
                'actividades_fecha_fin' => $validated['periodo_fin'],
                'dependencias_seleccionadas' => $validated['dependencias'],
            ]);

            // Actualizar regidores
            $informe->regidores = [
                ['nombre' => $validated['regidor1Nombre'], 'cargo' => $validated['regidor1Cargo']],
                ['nombre' => $validated['regidor2Nombre'], 'cargo' => $validated['regidor2Cargo']],
                ['nombre' => $validated['regidor3Nombre'], 'cargo' => $validated['regidor3Cargo']],
                ['nombre' => $validated['regidor4Nombre'], 'cargo' => $validated['regidor4Cargo']],
                ['nombre' => $validated['regidor5Nombre'], 'cargo' => $validated['regidor5Cargo']],
                ['nombre' => $validated['regidor6Nombre'], 'cargo' => $validated['regidor6Cargo']],
            ];
            $informe->save();

            Log::info('✅ Informe actualizado en BD');

            $actividades = $informe->getActividadesFiltradas();
            $actividades = $actividades->sortBy('tipo_area');
            Log::info('📊 Actividades para PDF actualizado: ' . $actividades->count());

            $this->generarPDFConMPdf($informe, $actividades);

            Log::info('✅ PDF regenerado exitosamente');

            // ✅ LOG DE EDICIÓN (se hace automáticamente con Auditable trait)

            return redirect()->route('informes-generados')
                ->with('success', 'Informe editado exitosamente');
        } catch (\Exception $e) {
            Log::error('❌ ERROR al actualizar informe: ' . $e->getMessage());
            Log::error('Línea: ' . $e->getLine());
            Log::error('Stack: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withErrors(['error' => 'Error al actualizar el informe: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $informe = Informe::findOrFail($id);
            $municipioNombre = $informe->municipio_nombre;

            // Solo el creador o administrador puede eliminar
            if ($informe->user_id !== Auth::id() && !Auth::user()->hasRole('Administrador')) {
                abort(403, 'No tienes permiso para eliminar este informe');
            }

            // Eliminar imágenes del storage
            if (!empty($informe->portada_imagen_path)) {
                Storage::disk('public')->delete($informe->portada_imagen_path);
            }
            if (!empty($informe->plantilla_imagen_path)) {
                Storage::disk('public')->delete($informe->plantilla_imagen_path);
            }
            if (!empty($informe->comuna_imagen_path)) {
                Storage::disk('public')->delete($informe->comuna_imagen_path);
            }
            if (!empty($informe->municipio_imagen_path)) {
                Storage::disk('public')->delete($informe->municipio_imagen_path);
            }
            if (!empty($informe->introduccion_imagen_path)) {
                Storage::disk('public')->delete($informe->introduccion_imagen_path);
            }
            if (!empty($informe->gobierno_imagen_path)) {
                Storage::disk('public')->delete($informe->gobierno_imagen_path);
            }
            if (!empty($informe->pdf_path)) {
                Storage::disk('public')->delete($informe->pdf_path);
            }

            InformeSeccion::where('informe_id', $informe->id)->delete();

            $informe->forceDelete();

            // ✅ LOG DE ELIMINACIÓN (se hace automáticamente con Auditable trait)

            return redirect()->route('informes-generados')
                ->with('success', 'Informe eliminado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar informe: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar el informe']);
        }
    }

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

            // ✅ REGISTRAR LOG DE DESCARGA
            AuditLog::log(
                action: 'descargar',
                description: "Descargó el informe: {$informe->municipio_nombre}",
                modelType: 'App\Models\Informe',
                modelId: $informe->id
            );

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

    public function getStats()
    {
        $totalDescargas = Informe::sum('descargas');
        return response()->json([
            'success' => true,
            'totalDescargas' => $totalDescargas
        ]);
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
    
    public function incrementDescarga($id) {
        $informe = Informe::findOrFail($id);
        $informe->increment('descargas');
        
        // ✅ REGISTRAR LOG DE DESCARGA
        AuditLog::log(
            action: 'descargar',
            description: "Incrementó contador de descargas del informe: {$informe->municipio_nombre}",
            modelType: 'App\Models\Informe',
            modelId: $informe->id
        );
        
        return response()->json(['success' => true, 'descargas' => $informe->descargas]);
    }
}
