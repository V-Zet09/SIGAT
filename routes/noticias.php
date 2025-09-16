<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticiaController;

// Ruta para ver una noticia individual
Route::get('/noticias/{id}', [NoticiaController::class, 'show'])->name('noticias.show');
Route::get('/noticias', [NoticiaController::class, 'todos'])->name('noticias.todos');