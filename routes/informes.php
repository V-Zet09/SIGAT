<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformeController;

Route::middleware(['auth', 'prevent.back'])->group(function () {

    // ========= DASHBOARD DE INFORMES =========
    Route::get('/dashboard-informes-generados', [InformeController::class, 'index'])
        ->middleware('can:visualizar informes')
        ->name('informes-generados');

    Route::get('/dashboard-informes-generados/stats', [InformeController::class, 'getStats'])
        ->middleware('can:visualizar informes')
        ->name('informes.stats');

    // ========= CREAR INFORMES =========
    Route::get('/generar-informe', [InformeController::class, 'create'])
        ->middleware('can:generar informes')
        ->name('generar-informe');

    Route::post('/generar-informe', [InformeController::class, 'store'])
        ->middleware('can:generar informes')
        ->name('informes.store');

    // ========= EDITAR INFORMES =========
    Route::get('/informes/{informe}/editar', [InformeController::class, 'edit'])
        ->middleware('can:editar informes')
        ->name('informes.editar')
        ->where('informe', '[0-9]+');

    Route::put('/informes/{informe}', [InformeController::class, 'update'])
        ->middleware('can:editar informes')
        ->name('informes.update')
        ->where('informe', '[0-9]+');

    // ========= ELIMINAR INFORMES =========
    Route::delete('/informes/{informe}', [InformeController::class, 'destroy'])
        ->middleware('can:eliminar informes')
        ->name('informes.destroy')
        ->where('informe', '[0-9]+');

    // ========= VISTA PREVIA Y DESCARGA =========
    Route::get('/informes/{informe}/preview', [InformeController::class, 'preview'])
        ->middleware('can:visualizar informes')
        ->name('informes.preview')
        ->where('informe', '[0-9]+');

    Route::get('/informes/{informe}/download', [InformeController::class, 'downloadById'])
        ->middleware('can:visualizar informes')
        ->name('informes.download')
        ->where('informe', '[0-9]+');

    Route::get('/informes/{informe}/contador', [InformeController::class, 'getDownloadCount'])
        ->middleware('can:visualizar informes')
        ->name('informes.contador')
        ->where('informe', '[0-9]+');

    // ========= SECCIONES =========
    Route::post('/informes/{informe}/secciones', [InformeController::class, 'agregarSeccion'])
        ->middleware('can:editar informes')
        ->name('informes.secciones.store')
        ->where('informe', '[0-9]+');

    Route::delete('/informes/{informe}/secciones/{seccion}', [InformeController::class, 'eliminarSeccion'])
        ->middleware('can:editar informes')
        ->name('informes.secciones.destroy')
        ->where(['informe' => '[0-9]+', 'seccion' => '[0-9]+']);

    // ========= MOSTRAR UN INFORME (por slug o id) =========
    Route::get('/informes/{slug}', [InformeController::class, 'show'])
        ->middleware('can:visualizar informes')
        ->name('informes.show');
    Route::post('/informes/{informe}/increment-descarga', [InformeController::class, 'incrementDescarga'])
    ->middleware('can:visualizar informes')
    ->name('informes.increment-descarga');

});
