<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdministradorController,
    PresidenteMunicipalController,
    SindicoProcuradorController,
    RegidorController,
    DirectorDeAreaController,
    AuxiliarDeAreaController,
    HomeController
};

/*
|--------------------------------------------------------------------------
| RUTAS INTERNAS DEL SISTEMA
|--------------------------------------------------------------------------
| Todas estas rutas requieren:
| - Sesión iniciada (auth)
| - Bloqueo de historial (prevent-back-history)
|
| Esto evita que se pueda regresar con el botón "atrás"
| después de cerrar sesión.
*/

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    Route::get('/dashboard-administrador', [AdministradorController::class, 'index'])
        ->name('dashboard-administrador');

    Route::get('/dashboard-presidente-municipal', [PresidenteMunicipalController::class, 'index'])
        ->name('dashboard-presidente-municipal');

    Route::get('/dashboard-sindico-procurador', [SindicoProcuradorController::class, 'index'])
        ->name('dashboard-sindico-procurador');

    Route::get('/dashboard-regidor', [RegidorController::class, 'index'])
        ->name('dashboard-regidor');

    Route::get('/dashboard-director-de-area', [DirectorDeAreaController::class, 'index'])
        ->name('dashboard-director-de-area');

    Route::get('/dashboard-auxiliar-area', [AuxiliarDeAreaController::class, 'index'])
        ->name('dashboard-auxiliar-area');


});

// ============================================
// DASHBOARDS PROTEGIDOS POR ROL
// ============================================

// ✅ Dashboard Administrador (solo rol Administrador)
Route::get('/dashboard-administrador', [App\Http\Controllers\AdministradorController::class, 'index'])
    ->middleware(['auth', 'role:Administrador'])
    ->name('dashboard-administrador');

// ✅ Dashboard Presidente Municipal (solo rol Presidente Municipal)
Route::get('/dashboard-presidente-municipal', [App\Http\Controllers\PresidenteMunicipalController::class, 'index'])
    ->middleware(['auth', 'role:Presidente Municipal'])
    ->name('dashboard-presidente-municipal');

// ✅ Dashboard Síndico Procurador (solo rol Síndico Procurador)
Route::get('/dashboard-sindico-procurador', [App\Http\Controllers\SindicoProcuradorController::class, 'index'])
    ->middleware(['auth', 'role:Síndico Procurador'])
    ->name('dashboard-sindico-procurador');

// ✅ Dashboard Regidor (solo rol Regidor)
Route::get('/dashboard-regidor', [App\Http\Controllers\RegidorController::class, 'index'])
    ->middleware(['auth', 'role:Regidor'])
    ->name('dashboard-regidor');

// ✅ Dashboard Director de Área (solo rol Director de Área)
Route::get('/dashboard-director-de-area', [App\Http\Controllers\DirectorDeAreaController::class, 'index'])
    ->middleware(['auth', 'role:Director de Área'])
    ->name('dashboard-director-de-area');

// ✅ Dashboard Auxiliar de Área (solo rol Auxiliar de Área)
Route::get('/dashboard-auxiliar-area', [App\Http\Controllers\AuxiliarDeAreaController::class, 'index'])
    ->middleware(['auth', 'role:Auxiliar de Área'])
    ->name('dashboard-auxiliar-area');
