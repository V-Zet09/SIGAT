<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ActividadController;

Route::middleware('auth')->group(function () {
    Route::get('/informes-registrados', [ActividadController::class, 'showRegistradas'])->name('informes-registrados');
    Route::get('/generar-informe', [InformeController::class, 'create'])->name('generar-informe');
    Route::post('/generar-informe', [InformeController::class, 'store'])->name('informes.store');
    Route::get('/informes/{slug}', [InformeController::class, 'show'])->name('informes.show');
});
