<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard-users', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/dashboard-crear-usuario', [UserController::class, 'create'])->name('dashboard-crear-usuario');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('vista-editar-usuario');
});
