<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    ActividadController,
    UserController,
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

// ✅ Ruta dinámica para todo lo demás
Route::get('{any}', [HomeController::class, 'index'])->where('any', '.*')->middleware('auth')->name('index');


// Ver lista de usuarios
Route::get('/dashboard-users', [UserController::class, 'index'])->name('usuarios.index');

// Mostrar formulario de creación
Route::get('/dashboard-crear-usuario', [UserController::class, 'create'])->name('usuarios.create');

// Guardar usuario
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show'); // Ver (JSON)
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update'); // Editar
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy'); // Eliminar
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('vista-ver-usuarios');
Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('vista-editar-usuario');
    // ✅ Informes
    Route::get('dashboard-generar-informe', [GenerarInformeController::class, 'index'])->name('informes.index');
    Route::post('dashboard-generar-informe', [GenerarInformeController::class, 'store'])->name('informes.store');

    // ✅ Actividades
    Route::get('/dashboard-actividades', [ActividadController::class, 'create'])->name('actividades.create');
    Route::post('/dashboard-actividades', [ActividadController::class, 'store'])->name('actividades.store');
    Route::get('/dashboard-actividades-registradas', [ActividadController::class, 'showRegistradas'])->name('actividades.registradas');
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])->name('actividades.edit');
    Route::get('/actividades/{id}/show', [ActividadController::class, 'show'])->name('actividades.show');
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])->name('actividades.update');
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])->name('actividades.destroy');

});
