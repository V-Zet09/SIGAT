<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

// Ruta para contar actividades del informe (protegida con auth)
Route::get('/actividades/contar-informe', [ActividadController::class, 'contarParaInforme'])
    ->middleware('auth')
    ->name('actividades.contarInforme');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // LISTAR ACTIVIDADES (solo lectura)
    Route::get('/actividades', [ActividadController::class, 'index'])
        ->name('actividades.index')
        ->middleware('can:ver actividades');

    // FORMULARIO CREAR ACTIVIDAD
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])
        ->name('actividades.create')
        ->middleware('can:crear actividades');

    // GUARDAR NUEVA ACTIVIDAD
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])
        ->name('actividades.store')
        ->middleware('can:crear actividades');

    // ACTIVIDADES REGISTRADAS (solo lectura)
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])
        ->name('actividades.registradas')
        ->middleware('can:ver actividades');

    // ELIMINAR FOTO DE ACTIVIDAD
    Route::post('/actividades/{id}/eliminar-foto', [ActividadController::class, 'eliminarFoto'])
        ->name('actividades.eliminar-foto')
        ->middleware('can:editar actividades');

    // ELIMINAR FOTO ESPECÍFICA
    Route::delete('/actividades/{id}/fotos/{foto}', [ActividadController::class, 'eliminarFoto'])
        ->name('actividades.fotos.eliminar')
        ->middleware('can:editar actividades');

    // ADJUNTAR EVIDENCIA
    Route::post('/actividades/{id}/evidencia', [ActividadController::class, 'adjuntarEvidencia'])
        ->name('actividades.evidencia')
        ->middleware('can:editar actividades');

    // BUSCAR ACTIVIDADES (solo lectura)
    Route::get('/actividades-buscar', [ActividadController::class, 'buscar'])
        ->name('actividades.buscar')
        ->middleware('can:ver actividades');

    // FILTRAR POR ESTADO (solo lectura)
    Route::get('/actividades-estado/{estado}', [ActividadController::class, 'filtrarPorEstado'])
        ->name('actividades.filtrar-estado')
        ->middleware('can:ver actividades');

    // CALENDARIO (solo lectura)
    Route::get('/actividades-calendario', [ActividadController::class, 'calendario'])
        ->name('actividades.calendario')
        ->middleware('can:ver actividades');

    // API CONTAR ACTIVIDADES (solo lectura)
    Route::get('/api/actividades/contar', [ActividadController::class, 'count'])
        ->name('api.actividades.contar')
        ->middleware('can:ver actividades');

    // EDITAR ACTIVIDAD
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])
        ->name('actividades.edit')
        ->middleware('can:editar actividades');

    // VER DETALLE (solo lectura)
    Route::get('/actividades/{id}', [ActividadController::class, 'show'])
        ->name('actividades.show')
        ->middleware('can:ver actividades');

    // ACTUALIZAR ACTIVIDAD
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])
        ->name('actividades.update')
        ->middleware('can:editar actividades');

    // ELIMINAR ACTIVIDAD
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])
        ->name('actividades.destroy')
        ->middleware('can:eliminar actividades');
});
