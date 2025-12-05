<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Listado general (otra pantalla)
    Route::get('/actividades', [ActividadController::class, 'index'])
        ->name('actividades.index');

    // Formulario de creación
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])
        ->name('actividades.create');

    // Guardar nueva actividad
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])
        ->name('actividades.store');

    // Listado "Actividades Registradas"
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])
        ->name('actividades.registradas');

    // Gestión de fotos
    Route::post('/actividades/{id}/eliminar-foto', [ActividadController::class, 'eliminarFoto'])
        ->name('actividades.eliminar-foto');

    Route::delete('/actividades/{id}/fotos/{foto}', [ActividadController::class, 'eliminarFoto'])
        ->name('actividades.fotos.eliminar');

    Route::post('/actividades/{id}/evidencia', [ActividadController::class, 'adjuntarEvidencia'])
        ->name('actividades.evidencia');

    // Rutas adicionales
    Route::get('/actividades-buscar', [ActividadController::class, 'buscar'])
        ->name('actividades.buscar');

    Route::get('/actividades-estado/{estado}', [ActividadController::class, 'filtrarPorEstado'])
        ->name('actividades.filtrar-estado');

    Route::get('/actividades-calendario', [ActividadController::class, 'calendario'])
        ->name('actividades.calendario');

    Route::get('/api/actividades/contar', [ActividadController::class, 'count'])
        ->name('api.actividades.contar');

    // Rutas con {id}
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])
        ->name('actividades.edit');

    Route::get('/actividades/{id}', [ActividadController::class, 'show'])
        ->name('actividades.show');

    Route::put('/actividades/{id}', [ActividadController::class, 'update'])
        ->name('actividades.update');

    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])
        ->name('actividades.destroy');
});
