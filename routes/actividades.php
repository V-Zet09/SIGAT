<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

// =======================
// RUTAS PROTEGIDAS (requieren autenticación)
// =======================
Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // ==========================================
    // CRUD ACTIVIDADES - VERSIÓN ACTUALIZADA
    // ==========================================
    
    // Ver listado de actividades
    Route::get('/actividades', [ActividadController::class, 'index'])
        ->name('actividades.index');
    
    // Formulario de creación
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])
        ->name('actividades.create');
    
    // Guardar nueva actividad
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])
        ->name('actividades.store');
    
    // Ver actividades registradas (listado)
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])
        ->name('actividades.registradas');
    
    // ✅ VER DETALLE (DEBE IR ANTES DE /edit)
    Route::get('/actividades/{id}', [ActividadController::class, 'show'])
        ->name('actividades.show');
    
    // Formulario de edición
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])
        ->name('actividades.edit');
    
    // Actualizar actividad
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])
        ->name('actividades.update');

    // ==========================================
    // GESTIÓN DE FOTOS
    // ==========================================
    
    // Eliminar foto (DEBE IR ANTES que eliminar actividad)
    Route::delete('/actividades/{id}/fotos/{foto}', [ActividadController::class, 'eliminarFoto'])
        ->name('actividades.fotos.eliminar');
    
    // Eliminar foto alternativa (POST para Ajax)
    Route::post('/actividades/{id}/eliminar-foto', [ActividadController::class, 'eliminarFoto'])
        ->name('actividades.eliminar-foto');

    // ==========================================
    // ELIMINAR ACTIVIDAD
    // ==========================================
    
    // Eliminar actividad (SIEMPRE DESPUÉS de rutas de fotos)
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])
        ->name('actividades.destroy');

    // ==========================================
    // RUTAS ADICIONALES
    // ==========================================
    
    // Buscar actividades (Ajax)
    Route::get('/actividades-buscar', [ActividadController::class, 'buscar'])
        ->name('actividades.buscar');
    
    // Filtrar por estado
    Route::get('/actividades-estado/{estado}', [ActividadController::class, 'filtrarPorEstado'])
        ->name('actividades.filtrar-estado');
    
    // Calendario (Ajax)
    Route::get('/actividades-calendario', [ActividadController::class, 'calendario'])
        ->name('actividades.calendario');
    
    // Contador API
    Route::get('/api/actividades/contar', [ActividadController::class, 'count'])
        ->name('api.actividades.contar');
    
    // Adjuntar evidencia
    Route::post('/actividades/{id}/evidencia', [ActividadController::class, 'adjuntarEvidencia'])
        ->name('actividades.evidencia');
});
