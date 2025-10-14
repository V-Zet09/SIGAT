<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformeController;

Route::middleware('auth')->group(function () {
    // Dashboard de informes
    Route::get('/dashboard-informes-generados', [InformeController::class, 'index'])
        ->name('informes-generados');

    // Crear informe
    Route::get('/generar-informe', [InformeController::class, 'create'])
        ->name('generar-informe');
        
    Route::post('/generar-informe', [InformeController::class, 'store'])
        ->name('informes.store');

    // IMPORTANTE: Esta ruta DEBE estar ANTES de la ruta {slug}
    Route::get('/informes/{id}/descargar-pdf', [InformeController::class, 'downloadById'])
        ->name('informes.download')
        ->where('id', '[0-9]+'); // Solo acepta números
    
    // Editar informe
    Route::get('/informes/{id}/editar', [InformeController::class, 'edit'])
        ->name('informes.edit')
        ->where('id', '[0-9]+');
        
    Route::put('/informes/{informe}', [InformeController::class, 'update'])
        ->name('informes.update');
        
    // Eliminar informe
    Route::delete('/informes/{id}', [InformeController::class, 'destroy'])
        ->name('informes.destroy')
        ->where('id', '[0-9]+');
    
    // Ver informe - ESTA DEBE SER LA ÚLTIMA
    Route::get('/informes/{slug}', [InformeController::class, 'show'])
        ->name('informes.show');
        // Rutas para actualizar contadores en tiempo real
    Route::get('/informe/{id}/download-count', [InformeController::class, 'getDownloadCount']);
    Route::get('/dashboard-informes-generados/stats', [InformeController::class, 'getStats']);
});