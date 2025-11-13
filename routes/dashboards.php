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
