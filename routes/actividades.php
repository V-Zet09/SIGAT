<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

// Ruta para contar actividades del informe (protegida con auth)
Route::get('/actividades/contar-informe', [ActividadController::class, 'contarParaInforme'])
    ->middleware('auth')
    ->name('actividades.contarInforme');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/actividades', [ActividadController::class, 'index'])
        ->name('actividades.index');

    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])
        ->name('actividades.create');

    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])
        ->name('actividades.store');

    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])
        ->name('actividades.registradas');

    Route::post('/actividades/{id}/eliminar-foto', [ActividadController::class, 'eliminarFoto'])
        ->name('actividades.eliminar-foto');

    Route::delete('/actividades/{id}/fotos/{foto}', [ActividadController::class, 'eliminarFoto'])
        ->name('actividades.fotos.eliminar');

    Route::post('/actividades/{id}/evidencia', [ActividadController::class, 'adjuntarEvidencia'])
        ->name('actividades.evidencia');

    Route::get('/actividades-buscar', [ActividadController::class, 'buscar'])
        ->name('actividades.buscar');

    Route::get('/actividades-estado/{estado}', [ActividadController::class, 'filtrarPorEstado'])
        ->name('actividades.filtrar-estado');

    Route::get('/actividades-calendario', [ActividadController::class, 'calendario'])
        ->name('actividades.calendario');

    Route::get('/api/actividades/contar', [ActividadController::class, 'count'])
        ->name('api.actividades.contar');

    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])
        ->name('actividades.edit');

    Route::get('/actividades/{id}', [ActividadController::class, 'show'])
        ->name('actividades.show');

    Route::put('/actividades/{id}', [ActividadController::class, 'update'])
        ->name('actividades.update');

    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])
        ->name('actividades.destroy');
});
