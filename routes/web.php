<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardPresidentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Registro de rutas de autenticación (login, logout, etc.)
Auth::routes();

// ✅ Redirige raíz al dashboard si está autenticado, si no al login
Route::get('/', function () {
    return Auth::check()
        ? redirect('/dashboard-administrador')
        : view('auth.login'); // Usa la vista de login directamente
})->name('root');

// ✅ Cambio de idioma
Route::get('index/{locale}', [HomeController::class, 'lang']);

// ✅ Actualización de perfil y contraseña
Route::post('/update-profile/{id}', [HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');

// ✅ Todas las demás vistas dinámicas protegidas
Route::get('{any}', [HomeController::class, 'index'])->where('any', '.*')->middleware('auth')->name('index');
