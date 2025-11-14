<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\PresidenteMunicipalController;
use App\Http\Controllers\SindicoProcuradorController;
use App\Http\Controllers\RegidorController;
use App\Http\Controllers\DirectorDeAreaController;
use App\Http\Controllers\AuxiliarDeAreaController;

// Dashboard Administrador
Route::middleware(['auth', 'can:acceder dashboard administrador'])
    ->get('/dashboard-administrador', [AdministradorController::class, 'index'])
    ->name('dashboard-administrador');

// Dashboard Presidente Municipal
Route::middleware(['auth', 'can:acceder dashboard presidente'])
    ->get('/dashboard-presidente-municipal', [PresidenteMunicipalController::class, 'index'])
    ->name('dashboard-presidente-municipal');

// Dashboard Síndico Procurador
Route::middleware(['auth', 'can:acceder dashboard sindico'])
    ->get('/dashboard-sindico-procurador', [SindicoProcuradorController::class, 'index'])
    ->name('dashboard-sindico-procurador');

// Dashboard Regidor
Route::middleware(['auth', 'can:acceder dashboard regidor'])
    ->get('/dashboard-regidor', [RegidorController::class, 'index'])
    ->name('dashboard-regidor');

// Dashboard Director de Área
Route::middleware(['auth', 'can:acceder dashboard director'])
    ->get('/dashboard-director-de-area', [DirectorDeAreaController::class, 'index'])
    ->name('dashboard-director-de-area');

// Dashboard Auxiliar de Área
Route::middleware(['auth', 'can:acceder dashboard auxiliar'])
    ->get('/dashboard-auxiliar-area', [AuxiliarDeAreaController::class, 'index'])
    ->name('dashboard-auxiliar-area');