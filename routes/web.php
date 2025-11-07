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

// ✅ Cargar módulos
require __DIR__.'/dashboards.php';
require __DIR__.'/users.php';
require __DIR__.'/informes.php';
require __DIR__.'/actividades.php';
require __DIR__.'/menu.php';

// ============================================
// ROLES Y PERMISOS (Solo Administrador)
// ============================================
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles');
    Route::post('/roles/{id}/permisos', [App\Http\Controllers\RoleController::class, 'updatePermissions'])->name('roles.update-permissions');
});

// ============================================
// PERFIL DEL USUARIO (Todos los usuarios autenticados)
// ============================================
Route::middleware('auth')->group(function () {
    Route::get('/mi-perfil', [App\Http\Controllers\ProfileController::class, 'index'])->name('perfil.index');
    Route::post('/mi-perfil/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('perfil.update');
    Route::post('/mi-perfil/update-password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('perfil.updatePassword');
    Route::post('/mi-perfil/update-avatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('perfil.updateAvatar');
    Route::delete('/mi-perfil/remove-avatar', [App\Http\Controllers\ProfileController::class, 'removeAvatar'])->name('perfil.removeAvatar');
    Route::post('/mi-perfil/logout-all', [App\Http\Controllers\ProfileController::class, 'logoutAllDevices'])->name('perfil.logoutAll');
});

// ============================================
// NOTIFICACIONES (Usuarios autenticados)
// ============================================
Route::middleware('auth')->group(function () {
    // Ver todas las notificaciones
    Route::get('/notificaciones', [App\Http\Controllers\NotificationController::class, 'index'])
        ->name('notifications.index');
    
    // Obtener notificaciones recientes (AJAX)
    Route::get('/notificaciones/recent', [App\Http\Controllers\NotificationController::class, 'getRecent'])
        ->name('notifications.recent');
    
    // Marcar como leída
    Route::post('/notificaciones/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    
    // Marcar todas como leídas
    Route::post('/notificaciones/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');
    
    // Eliminar notificación
    Route::delete('/notificaciones/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])
        ->name('notifications.destroy');
    
    // Limpiar notificaciones leídas
    Route::post('/notificaciones/clear-read', [App\Http\Controllers\NotificationController::class, 'clearRead'])
        ->name('notifications.clearRead');
});