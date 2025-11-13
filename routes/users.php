<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    
    // ========== RUTAS CON prevent.back (formularios) ==========
    Route::middleware('prevent.back')->group(function () {
        // Formulario de crear usuario
        Route::get('/dashboard-crear-usuario', [UserController::class, 'create'])
            ->name('dashboard-crear-usuario');
        
        // Formulario de editar usuario
        Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])
            ->name('vista-editar-usuario');
    });
    
    // ========== RUTAS SIN prevent.back (resto) ==========
    
    // Listado de usuarios
    Route::get('/dashboard-users', [UserController::class, 'index'])
        ->name('usuarios.index');
    
    // Crear usuario (envío de formulario)
    Route::post('/usuarios', [UserController::class, 'store'])
        ->name('usuarios.store');
    
    // Ver usuario
    Route::get('/usuarios/{id}', [UserController::class, 'show'])
        ->name('usuarios.show'); // También se puede acceder como 'vista-ver-usuarios'
    
    // Actualizar usuario
    Route::put('/usuarios/{id}', [UserController::class, 'update'])
        ->name('usuarios.update');
    
    // Eliminar usuario
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])
        ->name('usuarios.destroy');
    
    // Roles
    Route::get('/roles', [UserController::class, 'roles'])
        ->name('roles');
});
