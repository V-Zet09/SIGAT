<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ActividadController;

Route::middleware('auth')->group(function () {
    // Listar todos los informes generados
    Route::get('/dashboard-informes-generados', [InformeController::class, 'index'])
        ->name('informes-generados');

    // Crear un informe nuevo
    Route::get('/generar-informe', [InformeController::class, 'create'])->name('generar-informe');
    Route::post('/generar-informe', [InformeController::class, 'store'])->name('informes.store');

    // Mostrar un informe en específico por slug
    Route::get('/informes/{slug}', [InformeController::class, 'show'])->name('informes.show');
});
