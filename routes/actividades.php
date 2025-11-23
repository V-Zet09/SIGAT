<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

// =======================
// RUTAS PROTEGIDAS (requieren autenticación)
// =======================
Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Formularios de creación/edición
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])
        ->name('actividades.create');
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])
        ->name('actividades.edit');

    // CRUD ACTIVIDADES
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])
        ->name('actividades.store');
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])
        ->name('actividades.registradas');
    Route::get('/actividades/{id}/show', [ActividadController::class, 'show'])
        ->name('actividades.show');
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])
        ->name('actividades.update');

    // === ¡ESPECIAL! ===
    // Ruta para eliminar foto, debe ir ANTES que eliminar actividad
    Route::delete('/actividades/{id}/fotos/{foto}', [ActividadController::class, 'eliminarFoto'])
        ->name('actividades.fotos.eliminar');

    // Ruta para eliminar actividad (NUNCA antes que eliminarFoto)
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])
        ->name('actividades.destroy');

    Route::get('/api/actividades/contar', [ActividadController::class, 'count'])
        ->name('api.actividades.contar');
});

// =======================
// RUTAS PROTEGIDAS POR PERMISOS
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])
        ->middleware('can:ver actividades')
        ->name('actividades.registradas');
    Route::get('/actividades/{id}', [ActividadController::class, 'show'])
        ->middleware('can:ver actividades')
        ->name('actividades.show');
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])
        ->middleware('can:crear actividades')
        ->name('actividades.create');
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])
        ->middleware('can:crear actividades')
        ->name('actividades.store');
    Route::get('/actividades/{id}/editar', [ActividadController::class, 'edit'])
        ->middleware('can:editar actividades')
        ->name('actividades.edit');
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])
        ->middleware('can:editar actividades')
        ->name('actividades.update');

    // === ¡ESPECIAL! ===
    // Ruta para eliminar foto, debe ir ANTES que eliminar actividad
    Route::delete('/actividades/{id}/fotos/{foto}', [ActividadController::class, 'eliminarFoto'])
        ->middleware('can:editar actividades')
        ->name('actividades.fotos.eliminar');

    // Ruta para eliminar actividad
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])
        ->middleware('can:eliminar actividades')
        ->name('actividades.destroy');

    Route::post('/actividades/{id}/aprobar', [ActividadController::class, 'aprobar'])
        ->middleware('can:aprobar actividades')
        ->name('actividades.aprobar');
    Route::post('/actividades/{id}/rechazar', [ActividadController::class, 'rechazar'])
        ->middleware('can:aprobar actividades')
        ->name('actividades.rechazar');
    Route::post('/actividades/{id}/evidencia', [ActividadController::class, 'adjuntarEvidencia'])
        ->middleware('can:adjuntar evidencia')
        ->name('actividades.evidencia');
});
