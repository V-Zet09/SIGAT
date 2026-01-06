<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdministradorController,
    PresidenteMunicipalController,
    SindicoProcuradorController,
    RegidorController,
    DirectorDeAreaController,
    AuxiliarDeAreaController,
    HomeController,
    ColaboradorController
};

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        
        if ($user->hasRole('Administrador')) {
            return redirect()->route('dashboard-administrador');
        } elseif ($user->hasRole('Presidente Municipal')) {
            return redirect()->route('dashboard-presidente-municipal');
        } elseif ($user->hasRole('Síndico Procurador')) {
            return redirect()->route('dashboard-sindico-procurador');
        } elseif ($user->hasRole('Regidor')) {
            return redirect()->route('dashboard-regidor');
        } elseif ($user->hasRole('Director de Área')) {
            return redirect()->route('dashboard-director-de-area');
        } else {
            return redirect()->route('dashboard-auxiliar-de-area');
        }
    }

    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // DASHBOARD ADMINISTRADOR
    Route::get('/dashboard-administrador', [AdministradorController::class, 'index'])
        ->middleware('role:Administrador')
        ->name('dashboard-administrador');

    Route::get('/api/calendario-eventos', [AdministradorController::class, 'getCalendarioEventos'])
        ->middleware('role:Administrador')
        ->name('api.calendario.eventos');

    // DASHBOARD PRESIDENTE MUNICIPAL
    Route::get('/dashboard-presidente-municipal', [PresidenteMunicipalController::class, 'index'])
        ->middleware('can:acceder dashboard presidente')
        ->name('dashboard-presidente-municipal');

    // DASHBOARD SÍNDICO PROCURADOR
    Route::get('/dashboard-sindico-procurador', [SindicoProcuradorController::class, 'index'])
        ->middleware('can:acceder dashboard sindico')
        ->name('dashboard-sindico-procurador');

    // DASHBOARD REGIDOR
    Route::get('/dashboard-regidor', [RegidorController::class, 'index'])
        ->middleware('can:acceder dashboard regidor')
        ->name('dashboard-regidor');

    // DASHBOARD DIRECTOR DE ÁREA
    Route::get('/dashboard-director-de-area', [DirectorDeAreaController::class, 'index'])
        ->middleware('can:acceder dashboard director')
        ->name('dashboard-director-de-area');

    // ✅ APROBAR / RECHAZAR (solo auth, permisos dentro del controlador)
    Route::put('/actividades/{id}/aprobar', [DirectorDeAreaController::class, 'aprobar'])
        ->name('actividades.aprobar');

    Route::put('/actividades/{id}/rechazar', [DirectorDeAreaController::class, 'rechazar'])
        ->name('actividades.rechazar');

    // DASHBOARD AUXILIAR DE ÁREA
    Route::get('/dashboard-auxiliar-de-area', [AuxiliarDeAreaController::class, 'index'])
        ->middleware('can:acceder dashboard auxiliar')
        ->name('dashboard-auxiliar-de-area');


Route::get('/colaboradores', [ColaboradorController::class, 'index'])
    ->name('colaboradores')
    ->middleware(['auth']); // o los middleware que uses

});
