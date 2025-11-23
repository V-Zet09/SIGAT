<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

// ============================================
// USUARIOS AUTENTICADOS
// ============================================
Route::middleware('auth')->group(function () {

    // ---------- FORMULARIOS CON prevent.back ----------
    Route::middleware('prevent.back')->group(function () {
        Route::get('/dashboard-crear-usuario', [UserController::class, 'create'])->name('dashboard-crear-usuario');
        Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('vista-editar-usuario');
    });

    // ---------- RUTAS DE USUARIOS (GENERALES) ----------
    Route::get('/dashboard-users', [UserController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    // Roles simple
    Route::get('/roles-simple', [UserController::class, 'rolesSimple'])->name('roles-simple');

    // ============================================
    // PERFIL DEL USUARIO
    // ============================================
    Route::get('/mi-perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::post('/mi-perfil/update', [ProfileController::class, 'update'])->name('perfil.update');
    Route::post('/mi-perfil/update-password', [ProfileController::class, 'updatePassword'])->name('perfil.updatePassword');
    Route::post('/mi-perfil/update-avatar', [ProfileController::class, 'updateAvatar'])->name('perfil.updateAvatar');
    Route::delete('/mi-perfil/remove-avatar', [ProfileController::class, 'removeAvatar'])->name('perfil.removeAvatar');
    Route::post('/mi-perfil/logout-all', [ProfileController::class, 'logoutAllDevices'])->name('perfil.logoutAll');

    // ============================================
    // NOTIFICACIONES
    // ============================================
    Route::get('/notificaciones', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notificaciones/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('/notificaciones/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notificaciones/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notificaciones/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notificaciones/clear-read', [NotificationController::class, 'clearRead'])->name('notifications.clearRead');
});

// ============================================
// ADMINISTRADOR (ROLES Y PERMISOS)
// ============================================
Route::middleware(['auth', 'role:Administrador'])->group(function () {

    // Gestión de usuarios solo para administradores
    Route::get('/dashboard-users', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/dashboard-crear-usuario', [UserController::class, 'create'])->name('dashboard-crear-usuario');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('vista-editar-usuario');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    // Roles y permisos
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::post('/roles/{id}/permisos', [RoleController::class, 'updatePermissions'])->name('roles.update-permissions');
});
