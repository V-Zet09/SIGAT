<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\PresidenteController;
use App\Http\Controllers\CargoAyuntamientoController;
use App\Http\Controllers\OrganigramaController;

// ============================================
// PÁGINAS PRINCIPALES PÚBLICAS
// ============================================
Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');
Route::get('/sala-de-prensa', [PaginaController::class, 'sala'])->name('sala-de-prensa');
Route::get('/gobierno', [PaginaController::class, 'gobierno'])->name('gobierno');

// ✅ CORREGIDO: Ahora usa OrganigramaController
Route::get('/ayuntamiento', [OrganigramaController::class, 'index'])->name('ayuntamiento');

// ============================================
// ORGANIGRAMA PÚBLICO
// ============================================
Route::get('/organigrama', [OrganigramaController::class, 'index'])->name('organigrama.index');

// ============================================
// DEPENDENCIAS MUNICIPALES (vistas estáticas)
// ============================================
Route::prefix('dependencias')->name('dependencias.')->group(function() {
    Route::view('/obras_publicas', 'dependencias.obras_publicas')->name('obras_publicas');
    Route::view('/educacion', 'dependencias.educacion')->name('educacion');
    Route::view('/salud', 'dependencias.salud')->name('salud');
    Route::view('/tesoreria', 'dependencias.tesoreria')->name('tesoreria');
    Route::view('/cultura', 'dependencias.cultura')->name('cultura');
});

// ============================================
// RUTAS PROTEGIDAS POR AUTENTICACIÓN
// ============================================
Route::middleware('auth')->group(function() {
    
    // Gestión del Presidente
    Route::post('/presidente/actualizar', [PresidenteController::class, 'actualizar'])
         ->name('presidente.actualizar');

    // AGREGAR ESTAS DOS LÍNEAS AQUÍ:
    Route::put('/ayuntamiento/{id}', [OrganigramaController::class, 'actualizar'])->name('organigrama.actualizar');
    Route::delete('/ayuntamiento/{id}', [OrganigramaController::class, 'eliminar'])->name('organigrama.eliminar');

    Route::get('/organigrama/editar', [OrganigramaController::class, 'editar'])->name('organigrama.editar');
    Route::post('/organigrama/crear', [OrganigramaController::class, 'crear'])->name('organigrama.crear');
});

// ============================================
// RUTA DE DIAGNÓSTICO (TEMPORAL)
// ============================================
Route::get('/test-cargos', function() {
    try {
        $total = \App\Models\Cargo::count();
        
        // ✅ CORREGIDO: jerarquía 1 (no 2)
        $presidente = \App\Models\Cargo::where('jerarquia', 1)
            ->where('orden_visual', 1)
            ->first();
        
        $primeros10 = \App\Models\Cargo::orderBy('jerarquia')
            ->orderBy('orden_visual')
            ->limit(10)
            ->get();
        
        return response()->json([
            'total_registros' => $total,
            'presidente_encontrado' => $presidente ? 'SÍ ✅' : 'NO ❌',
            'datos_presidente' => $presidente,
            'primeros_10_cargos' => $primeros10,
            'tabla_detectada' => (new \App\Models\Cargo)->getTable()
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'linea' => $e->getLine(),
            'archivo' => $e->getFile()
        ], 500, [], JSON_PRETTY_PRINT);
    }
});