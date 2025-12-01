<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdministradorController,
    PresidenteMunicipalController,
    SindicoProcuradorController,
    RegidorController,
    DirectorDeAreaController,
    AuxiliarDeAreaController
};

/*
|--------------------------------------------------------------------------
| RUTAS DE DASHBOARDS
|--------------------------------------------------------------------------
| Todas las rutas de dashboards protegidas por autenticación y permisos.
| El Administrador puede ver TODOS los dashboards.
| Otros roles solo ven SU dashboard.
*/

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Dashboard Administrador
    Route::middleware(['can:acceder dashboard administrador'])
        ->get('/dashboard-administrador', [AdministradorController::class, 'index'])
        ->name('dashboard-administrador');

    // Dashboard Presidente Municipal
    Route::middleware(['can:acceder dashboard presidente'])
        ->get('/dashboard-presidente-municipal', [PresidenteMunicipalController::class, 'index'])
        ->name('dashboard-presidente-municipal');

    // Dashboard Síndico Procurador
    Route::middleware(['can:acceder dashboard sindico'])
        ->get('/dashboard-sindico-procurador', [SindicoProcuradorController::class, 'index'])
        ->name('dashboard-sindico-procurador');

    // Dashboard Regidor
    Route::middleware(['can:acceder dashboard regidor'])
        ->get('/dashboard-regidor', [RegidorController::class, 'index'])
        ->name('dashboard-regidor');

    // Dashboard Director de Área
    Route::middleware(['can:acceder dashboard director'])
        ->get('/dashboard-director-de-area', [DirectorDeAreaController::class, 'index'])
        ->name('dashboard-director-de-area');

    // Dashboard Auxiliar de Área
    Route::middleware(['can:acceder dashboard auxiliar'])
        ->get('/dashboard-auxiliar-area', [AuxiliarDeAreaController::class, 'index'])
        ->name('dashboard-auxiliar-area');

});