<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformeController;

Route::middleware(['auth', 'prevent.back'])->group(function () {

    // ========= Dashboard =========
// ============================================
// RUTAS DE INFORMES PROTEGIDAS POR PERMISOS
// ============================================

Route::middleware('auth')->group(function () {
    
    // ✅ VER/VISUALIZAR INFORMES (todos con permiso)
    Route::get('/dashboard-informes-generados', [InformeController::class, 'index'])
        ->middleware('can:visualizar informes')
        ->name('informes-generados');

    Route::get('/dashboard-informes-generados/stats', [InformeController::class, 'getStats'])
        ->name('informes.stats');

    // ========= Formularios (rutas específicas ANTES de las wildcards) =========
    // Formulario VACÍO para crear nuevo informe
    Route::get('/generar-informe', [InformeController::class, 'create'])
        ->name('generar-informe');

    // Formulario LLENO para editar informe existente
    Route::get('/informes/{id}/editar', [InformeController::class, 'edit'])
        ->name('informes.editar')
        ->where('id', '[0-9]+');

    // ========= Vista previa y descarga (rutas específicas) =========
    Route::get('/informes/{id}/preview', [InformeController::class, 'preview'])
        ->name('informes.preview')
        ->where('id', '[0-9]+');

    Route::get('/informes/{id}/download', [InformeController::class, 'downloadById'])
        ->name('informes.download')
        ->where('id', '[0-9]+');

    Route::get('/informes/{id}/contador', [InformeController::class, 'getDownloadCount'])
        ->name('informes.contador')
        ->where('id', '[0-9]+');

    // Ruta de testing
    Route::get('/test-pdf/{id}', [InformeController::class, 'testPdf'])
        ->name('test.pdf')
        ->where('id', '[0-9]+');

    // ========= Acciones POST/PUT/DELETE =========
    // Crear informe completo con formulario
    Route::post('/generar-informe', [InformeController::class, 'store'])
        ->name('informes.store');

    // Generar informe rápido con actividades
    Route::post('/informes/generar', [InformeController::class, 'generar'])
        ->name('informes.generar');

    // Actualizar informe existente
    Route::put('/informes/{informe}', [InformeController::class, 'update'])
        ->name('informes.update')
        ->where('informe', '[0-9]+');

    // Eliminar informe
    Route::delete('/informes/{id}', [InformeController::class, 'destroy'])
        ->name('informes.destroy')
        ->where('id', '[0-9]+');

    // ========= Secciones (Índice) =========
    Route::post('/informes/{informe}/secciones', [InformeController::class, 'agregarSeccion'])
        ->name('informes.secciones.store')
        ->where('informe', '[0-9]+');

    Route::delete('/informes/{informe}/secciones/{seccion}', [InformeController::class, 'eliminarSeccion'])
        ->name('informes.secciones.destroy')
        ->where(['informe' => '[0-9]+', 'seccion' => '[0-9]+']);

    // ========= Ruta con slug AL FINAL (wildcard debe ir último) =========
    // ⚠️ IMPORTANTE: Esta ruta SIEMPRE debe estar al final porque es un wildcard
    Route::get('/informes/{slug}', [InformeController::class, 'show'])
        ->name('informes.show');
});
    
    Route::get('/dashboard-informes-generados/stats', [InformeController::class, 'getStats'])
        ->middleware('can:visualizar informes')
        ->name('informes.stats');
    
    // ✅ GENERAR INFORMES (solo usuarios con permiso)
    Route::get('/generar-informe', [InformeController::class, 'create'])
        ->middleware('can:generar informes')
        ->name('informes.create');
    
    Route::post('/generar-informe', [InformeController::class, 'store'])
        ->middleware('can:generar informes')
        ->name('informes.store');
    
    // ✅ EDITAR INFORMES (solo usuarios con permiso)
    Route::get('/informes/{id}/editar', [InformeController::class, 'edit'])
        ->middleware('can:editar informes')
        ->name('informes.edit');
    
    Route::put('/informes/{id}', [InformeController::class, 'update'])
        ->middleware('can:editar informes')
        ->name('informes.update');
    
    // ✅ ELIMINAR INFORMES (solo usuarios con permiso)
    Route::delete('/informes/{id}', [InformeController::class, 'destroy'])
        ->middleware('can:eliminar informes')
        ->name('informes.destroy');
    
    // ✅ VER DETALLES DE UN INFORME (con permiso visualizar)
    Route::get('/informes/{id}', [InformeController::class, 'show'])
        ->middleware('can:visualizar informes')
        ->name('informes.show');
});
