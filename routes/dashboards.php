<?php

use Illuminate\Support\Facades\Route;

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