<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformeController;

// ============================================
// RUTAS DE INFORMES PROTEGIDAS POR PERMISOS
// ============================================

Route::middleware('auth')->group(function () {
    
    // ✅ VER/VISUALIZAR INFORMES (todos con permiso)
    Route::get('/dashboard-informes-generados', [InformeController::class, 'index'])
        ->middleware('can:visualizar informes')
        ->name('informes-generados');
    
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