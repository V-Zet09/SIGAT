<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// ============================================
// GESTIÓN DE USUARIOS (Solo Administrador)
// ============================================
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    // Listado de usuarios
    Route::get('/dashboard-users', [UserController::class, 'index'])->name('usuarios.index');
    
    // Crear usuario
    Route::get('/dashboard-crear-usuario', [UserController::class, 'create'])->name('dashboard-crear-usuario');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    
    // Ver usuario
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
    
    // Editar usuario
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('vista-editar-usuario');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    
    // Eliminar usuario
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
});