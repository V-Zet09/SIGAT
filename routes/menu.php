<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\PresidenteController;
use App\Http\Controllers\CargoAyuntamientoController;
use App\Http\Controllers\OrganigramaController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
| Estas rutas son accesibles sin iniciar sesión.
| No se les aplica el middleware prevent-back-history.
*/

Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');
Route::get('/sala-de-prensa', [PaginaController::class, 'sala'])->name('sala-de-prensa');
Route::get('/gobierno', [PaginaController::class, 'gobierno'])->name('gobierno');

// ✅ CORREGIDO: Usa OrganigramaController
Route::get('/ayuntamiento', [OrganigramaController::class, 'index'])->name('ayuntamiento');

// ============================================
// ORGANIGRAMA PÚBLICO
// ============================================
Route::get('/organigrama', [OrganigramaController::class, 'index'])->name('organigrama.index');

// ============================================
// DEPENDENCIAS MUNICIPALES (vistas estáticas)
// ============================================
Route::prefix('dependencias')->name('dependencias.')->group(function() {
    Route::view('/obras_publicas', 'dependencias.obras_publicas')->name('obras_publicas');
    Route::view('/educacion', 'dependencias.educacion')->name('educacion');
    Route::view('/salud', 'dependencias.salud')->name('salud');
    Route::view('/tesoreria', 'dependencias.tesoreria')->name('tesoreria');
    Route::view('/cultura', 'dependencias.cultura')->name('cultura');
});


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (LOGIN + PREVENIR HISTORIAL)
|--------------------------------------------------------------------------
| Estas rutas requieren autenticación y además
| no permiten usar el botón "atrás" después del logout.
*/

Route::middleware(['auth', 'prevent-back-history'])->group(function() {

    // ============================================
    // GESTIÓN DEL PRESIDENTE MUNICIPAL
    // ============================================
    Route::post('/presidente/actualizar', [PresidenteController::class, 'actualizar'])
         ->name('presidente.actualizar');

    // ============================================
    // ORGANIGRAMA (CRUD PROTEGIDO)
    // ============================================
    Route::put('/ayuntamiento/{id}', [OrganigramaController::class, 'actualizar'])
         ->name('organigrama.actualizar');

    Route::delete('/ayuntamiento/{id}', [OrganigramaController::class, 'eliminar'])
         ->name('organigrama.eliminar');

    Route::get('/organigrama/editar', [OrganigramaController::class, 'editar'])
         ->name('organigrama.editar');

    Route::post('/organigrama/crear', [OrganigramaController::class, 'crear'])
         ->name('organigrama.crear');
});
