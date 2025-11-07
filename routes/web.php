<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;


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


Route::get('/test-organigrama', function() {
    return view('test-organigrama');
});




// ✅ Cargar módulos
require __DIR__.'/dashboards.php';
require __DIR__.'/users.php';
require __DIR__.'/informes.php';
require __DIR__.'/actividades.php';
require __DIR__.'/menu.php';


use App\Http\Controllers\UserController;
use App\Http\Controllers\SalaPrensaController;
use App\Http\Controllers\CarruselController;
// Ruta para Roles simple
Route::get('/roles-simple', [UserController::class, 'rolesSimple'])->name('roles-simple');
Route::get('/sala-prensa', [SalaPrensaController::class, 'index'])->name('sala-prensa');
Route::post('/carrusel/store', [CarruselController::class, 'store'])->name('carrusel.store')->middleware('auth');
Route::delete('/carrusel/{id}', [CarruselController::class, 'destroy'])->name('carrusel.destroy')->middleware('auth');