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

    public function create()
    {
        return view('generar-informe');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'periodo' => 'required|string',
            'portada' => 'required|image|max:2048',
            'plantilla_imagen' => 'nullable|image|max:5120',
            
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
            
            // Guardar plantilla si existe
            $plantillaPath = null;
            if ($request->hasFile('plantilla_imagen')) {
                $plantillaPath = $request->file('plantilla_imagen')->store('informes/plantillas', 'public');
            }
            
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
                'plantilla_imagen_path' => $plantillaPath,
                
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

            // 🔥 CORRECCIÓN PRINCIPAL: Usar route() en lugar de string
            return redirect()->route('informes-generados')
                ->with('success', '✅ Informe generado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al crear informe: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withErrors(['error' => 'Error al crear el informe: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show($slug)
    {
        $informe = Informe::where('slug', $slug)->firstOrFail();
        return view('informes.show', compact('informe'));
    }

    public function edit($id)
    {
        $informe = Informe::findOrFail($id);
        return view('informes.edit', compact('informe'));
    }

    public function update(Request $request, $id)
    {
        try {
            $informe = Informe::findOrFail($id);
            
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'introduccion' => 'required|string',
            ]);

            $informe->update([
                'titulo' => $validated['titulo'],
                'introduccion' => $validated['introduccion'],
            ]);

            // Regenerar PDF si es necesario
            if ($informe->pdf_path) {
                $this->generarPDFAutomatico($informe);
            }

            // 🔥 CORRECCIÓN: Usar route()
            return redirect()->route('informes-generados')
                ->with('success', '✅ Informe actualizado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al actualizar informe: ' . $e->getMessage());
            
            return redirect()->back()
                ->withErrors(['error' => 'Error al actualizar el informe: ' . $e->getMessage()])
                ->withInput();
        }
    }

public function destroy($id)
{
    try {
        $informe = Informe::findOrFail($id);

        // Eliminar archivos físicos
        $archivos = [
            $informe->portada_path,
            $informe->plantilla_imagen_path,
            $informe->municipio_imagen_path,
            $informe->introduccion_imagen_path,
            $informe->gobierno_imagen_path,
            $informe->pdf_path
        ];

        foreach ($archivos as $archivo) {
            if ($archivo && Storage::disk('public')->exists($archivo)) {
                Storage::disk('public')->delete($archivo);
            }
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

    private function generarPDFAutomatico($informe)
    {
        try {
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
            Log::error('Error al generar PDF: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            return false;
        }
    }

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

    public function getStats()
    {
        try {
            $totalDescargas = Informe::sum('descargas');
            return response()->json([
                'success' => true,
                'totalDescargas' => $totalDescargas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }
}