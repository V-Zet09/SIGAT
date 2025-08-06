<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\DashboardPresidentController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\SidebarLayoutController;

// Nuevos controladores
use App\Http\Controllers\PresidenteMunicipalController;
use App\Http\Controllers\SindicoProcuradorController;
use App\Http\Controllers\RegidorController;
use App\Http\Controllers\DirectorDeAreaController;
use App\Http\Controllers\AuxiliarDeAreaController;
use App\Http\Controllers\GenerarInformeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Rutas de autenticación
Auth::routes();

// ✅ Redirige raíz al dashboard si está autenticado
Route::get('/', function () {
    return Auth::check()
        ? redirect('/dashboard-administrador')
        : view('auth.login');
})->name('root');

// ✅ Cambio de idioma
Route::get('index/{locale}', [HomeController::class, 'lang']);

// ✅ Actualización de perfil y contraseña
Route::post('/update-profile/{id}', [HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');

// ✅ Dashboards por rol
Route::get('/dashboard-administrador', [AdministradorController::class, 'index'])->middleware('auth')->name('dashboard-administrador');
Route::get('/dashboard-presidente-municipal', [PresidenteMunicipalController::class, 'index'])->middleware('auth')->name('dashboard-presidente-municipal');
Route::get('/dashboard-sindico-procurador', [SindicoProcuradorController::class, 'index'])->middleware('auth')->name('dashboard-sindico-procurador');
Route::get('/dashboard-regidor', [RegidorController::class, 'index'])->middleware('auth')->name('dashboard-regidor');
Route::get('/dashboard-director-de-area', [DirectorDeAreaController::class, 'index'])->middleware('auth')->name('dashboard-director-de-area');
Route::get('/dashboard-auxiliar-area', [AuxiliarDeAreaController::class, 'index'])->middleware('auth')->name('dashboard-auxiliar-area');

// ✅ Secciones específicas del dashboard
Route::get('/dashboard-presidentes', [DashboardPresidentController::class, 'index'])->middleware('auth')->name('dashboard-presidentes');
Route::get('/job-categories', [JobCategoryController::class, 'index'])->middleware('auth')->name('job-categories');
Route::get('/sidebar-layouts', [SidebarLayoutController::class, 'index'])->middleware('auth')->name('sidebar-layouts');

Route::get('dashboard-generar-informe', [GenerarInformeController::class, 'index'])->name('informes.index');
Route::post('dashboard-generar-informe', [GenerarInformeController::class, 'store'])->name('informes.store');

// ✅ Ruta dinámica para todo lo demás
Route::get('{any}', [HomeController::class, 'index'])->where('any', '.*')->middleware('auth')->name('index');
