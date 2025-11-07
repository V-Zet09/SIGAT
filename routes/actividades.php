<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

// ============================================
// RUTAS DE ACTIVIDADES PROTEGIDAS POR PERMISOS
// ============================================

Route::middleware('auth')->group(function () {
    
    // ✅ VER ACTIVIDADES (todos los usuarios autenticados con permiso)
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])
        ->middleware('can:ver actividades')
        ->name('actividades.registradas');
    
    // ✅ VER DETALLE DE UNA ACTIVIDAD
    Route::get('/actividades/{id}', [ActividadController::class, 'show'])
        ->middleware('can:ver actividades')
        ->name('actividades.show');
    
    // ✅ CREAR ACTIVIDADES (solo usuarios con permiso)
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])
        ->middleware('can:crear actividades')
        ->name('actividades.create');
    
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])
        ->middleware('can:crear actividades')
        ->name('actividades.store');
    
    // ✅ EDITAR ACTIVIDADES (solo usuarios con permiso)
    Route::get('/actividades/{id}/editar', [ActividadController::class, 'edit'])
        ->middleware('can:editar actividades')
        ->name('actividades.edit');
    
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])
        ->middleware('can:editar actividades')
        ->name('actividades.update');
    
    // ✅ ELIMINAR ACTIVIDADES (solo usuarios con permiso)
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])
        ->middleware('can:eliminar actividades')
        ->name('actividades.destroy');
    
    // ✅ APROBAR ACTIVIDADES (solo usuarios con permiso)
    Route::post('/actividades/{id}/aprobar', [ActividadController::class, 'aprobar'])
        ->middleware('can:aprobar actividades')
        ->name('actividades.aprobar');
    
    // ✅ RECHAZAR ACTIVIDADES (solo usuarios con permiso)
    Route::post('/actividades/{id}/rechazar', [ActividadController::class, 'rechazar'])
        ->middleware('can:aprobar actividades')
        ->name('actividades.rechazar');
    
    // ✅ ADJUNTAR EVIDENCIA (solo usuarios con permiso)
    Route::post('/actividades/{id}/evidencia', [ActividadController::class, 'adjuntarEvidencia'])
        ->middleware('can:adjuntar evidencia')
        ->name('actividades.evidencia');
});