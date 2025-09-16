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




// ✅ Cargar módulos
require __DIR__.'/dashboards.php';
require __DIR__.'/users.php';
require __DIR__.'/informes.php';
require __DIR__.'/actividades.php';
require __DIR__.'/menu.php';
require __DIR__.'/noticias.php';