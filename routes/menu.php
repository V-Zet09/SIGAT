<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\NoticiaController;


Route::get('/', [NoticiaController::class, 'index'])->name('inicio');
Route::get('/ayuntamiento', [PaginaController::class, 'ayuntamiento'])->name('ayuntamiento');
Route::get('/sala', [PaginaController::class, 'sala'])->name('sala-de-prensa');
Route::get('/gobierno', [PaginaController::class, 'gobierno'])->name('gobierno');
