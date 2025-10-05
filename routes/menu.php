<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;


// PÁGINAS PRINCIPALES
Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');
Route::get('/ayuntamiento', [PaginaController::class, 'ayuntamiento'])->name('ayuntamiento');
Route::get('/sala-de-prensa', [PaginaController::class, 'sala'])->name('sala-de-prensa');
Route::get('/gobierno', [PaginaController::class, 'gobierno'])->name('gobierno');


// DEPENDENCIAS MUNICIPALES (vistas estáticas)
Route::view('/dependencias/obras_publicas', 'dependencias.obras_publicas')->name('dependencias.obras_publicas');
Route::view('/dependencias/educacion', 'dependencias.educacion')->name('dependencias.educacion');
Route::view('/dependencias/salud', 'dependencias.salud')->name('dependencias.salud');
Route::view('/dependencias/tesoreria', 'dependencias.tesoreria')->name('dependencias.tesoreria');
Route::view('/dependencias/cultura', 'dependencias.cultura')->name('dependencias.cultura');

