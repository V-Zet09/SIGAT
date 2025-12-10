<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTA RAÍZ - REDIRIGE AL LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
| Dashboards y rutas que requieren autenticación
*/

Route::middleware(['auth', 'prevent-back-history'])->group(function() {
    
    // Aquí puedes agregar tu dashboard principal después del login
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
});
