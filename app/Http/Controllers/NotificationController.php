<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mostrar todas las notificaciones del usuario
     */
    public function index()
    {
        // Ordenamos por fecha de creación descendente (más nuevas primero)
        $notifications = Auth::user()
            ->notifications()
            ->latest() 
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Obtener notificaciones para el dropdown (AJAX)
     */
    public function getRecent()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get();

        // CORRECCIÓN: Laravel usa la relación unreadNotifications()
        $unreadCount = Auth::user()->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Marcar una notificación como leída
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead(); // Este método ya lo arreglamos en el Modelo

        return response()->json([
            'success' => true,
            'message' => 'Notificación marcada como leída',
        ]);
    }

    /**
     * Marcar todas como leídas
     */
    public function markAllAsRead()
    {
        // CORRECCIÓN: Solo actualizamos read_at, quitamos la columna 'read'
        Auth::user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones marcadas como leídas',
        ]);
    }

    /**
     * Eliminar una notificación
     */
    public function destroy($id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notificación eliminada',
        ]);
    }

    /**
     * Eliminar todas las notificaciones leídas
     */
    public function clearRead()
    {
        // CORRECCIÓN: Usamos el scope que ya viene con el trait o el modelo
        // Auth::user()->readNotifications() devuelve las leídas.
        Auth::user()
            ->readNotifications() 
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notificaciones leídas eliminadas',
        ]);
    }
}
