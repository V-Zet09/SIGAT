<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\{
    HomeController,
    AdministradorController,
    DashboardPresidentController,
    JobCategoryController,
    SidebarLayoutController,
    PresidenteMunicipalController,
    SindicoProcuradorController,
    RegidorController,
    DirectorDeAreaController,
    AuxiliarDeAreaController,
    GenerarInformeController,
    ActividadController
    
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Autenticación
Auth::routes();

// ✅ Redirección raíz
Route::get('/', function () {
    return Auth::check()
        ? redirect('/dashboard-administrador')
        : view('auth.login');
})->name('root');

// ✅ Idioma
Route::get('index/{locale}', [HomeController::class, 'lang']);

// ✅ Perfil
Route::post('/update-profile/{id}', [HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');

// ✅ Dashboards por rol
Route::middleware('auth')->group(function () {
    Route::get('/dashboard-administrador', [AdministradorController::class, 'index'])->name('dashboard-administrador');
    Route::get('/dashboard-presidente-municipal', [PresidenteMunicipalController::class, 'index'])->name('dashboard-presidente-municipal');
    Route::get('/dashboard-sindico-procurador', [SindicoProcuradorController::class, 'index'])->name('dashboard-sindico-procurador');
    Route::get('/dashboard-regidor', [RegidorController::class, 'index'])->name('dashboard-regidor');
    Route::get('/dashboard-director-de-area', [DirectorDeAreaController::class, 'index'])->name('dashboard-director-de-area');
    Route::get('/dashboard-auxiliar-area', [AuxiliarDeAreaController::class, 'index'])->name('dashboard-auxiliar-area');

    // ✅ Secciones específicas

    Route::get('/dashboard-president', [PresidenteMunicipalController::class, 'index'])->name('dashboard-president');
    //Route::get('/job-categories', [JobCategoryController::class, 'index'])->name('job-categories');
    //Route::get('/sidebar-layouts', [SidebarLayoutController::class, 'index'])->name('sidebar-layouts');

    // ✅ Actividades
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])->name('actividades.create');
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])->name('actividades.store');
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])->name('actividades.registradas');
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])->name('actividades.edit');
    Route::get('/actividades/{id}/show', [ActividadController::class, 'show'])->name('actividades.show');
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])->name('actividades.update');
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])->name('actividades.destroy');

    Route::middleware(['auth'])->group(function () {
    Route::get('/generar-informe', [InformeController::class, 'create'])->name('generar-informe');
    Route::post('/generar-informe', [InformeController::class, 'store'])->name('informes.store');
    Route::get('/informes/{slug}', [InformeController::class, 'show'])->name('informes.show');
});

});
