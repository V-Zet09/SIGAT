<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])->name('actividades.create');
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])->name('actividades.store');
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])->name('actividades.registradas');
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])->name('actividades.edit');
    Route::get('/actividades/{id}/show', [ActividadController::class, 'show'])->name('actividades.show');
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])->name('actividades.update');
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])->name('actividades.destroy');
});
