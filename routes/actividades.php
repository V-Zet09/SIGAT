<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

/*
|--------------------------------------------------------------------------
| RUTAS DE ACTIVIDADES (PROTEGIDAS)
|--------------------------------------------------------------------------
| - Requieren autenticación.
| - Usan el middleware prevent-back-history para impedir
|   regresar con el botón "Atrás" después de cerrar sesión.
*/

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // ============================================
    // FORMULARIOS (crear / editar)
    // ============================================
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])
        ->name('actividades.create');

    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])
        ->name('actividades.edit');

    // ============================================
    // CRUD DE ACTIVIDADES
    // ============================================

    // Crear nueva actividad (envío de formulario)
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])
        ->name('actividades.store');

    // Listado de actividades registradas
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])
        ->name('actividades.registradas');

    // Ver actividad individual
    Route::get('/actividades/{id}/show', [ActividadController::class, 'show'])
        ->name('actividades.show');

    // Actualizar actividad existente
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])
        ->name('actividades.update');

    // Eliminar actividad
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])
        ->name('actividades.destroy');
    Route::get('/api/actividades/contar', [ActividadController::class, 'count'])
        ->name('api.actividades.contar');
});
