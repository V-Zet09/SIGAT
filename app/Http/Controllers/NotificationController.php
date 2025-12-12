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
        $notifications = Auth::user()
            ->notifications()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Obtener notificaciones para el dropdown (AJAX)
     */
    public function getRecent()
    {
        $user = auth()->user();
        
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function($notif) use ($user) {
                $data = [
                    'id' => $notif->id,
                    'title' => $notif->title ?? 'Notificación',
                    'message' => $notif->message ?? '',
                    'icon' => $notif->icon ?? 'ri-notification-3-line',
                    'color' => $notif->color ?? 'blue',
                    'link' => null, // Por defecto null, se asignará si tiene permiso
                    'read' => $notif->read_at !== null,
                    'created_at' => $notif->created_at->toISOString(),
                ];
                
                // ✅ VERIFICAR PERMISOS ANTES DE AGREGAR LINKS
                if ($notif->link) {
                    $canAccess = true;
                    
                    // Si el link es a informes, verificar permiso
                    if (str_contains($notif->link, '/informes/') || str_contains($notif->link, '/generar-informe')) {
                        $canAccess = $user->can('visualizar informes');
                    }
                    // Si el link es a actividades, verificar permiso
                    elseif (str_contains($notif->link, '/actividades/')) {
                        $canAccess = $user->can('ver actividades');
                    }
                    // Si el link es a usuarios, verificar rol admin
                    elseif (str_contains($notif->link, '/users') || str_contains($notif->link, '/dashboard-users')) {
                        $canAccess = $user->hasRole('Administrador');
                    }
                    // Si el link es a roles y permisos
                    elseif (str_contains($notif->link, '/roles')) {
                        $canAccess = $user->hasRole('Administrador');
                    }
                    // Si el link es a dashboards, verificar permisos específicos
                    elseif (str_contains($notif->link, '/dashboard-')) {
                        if (str_contains($notif->link, 'presidente')) {
                            $canAccess = $user->can('acceder dashboard presidente');
                        } elseif (str_contains($notif->link, 'sindico')) {
                            $canAccess = $user->can('acceder dashboard sindico');
                        } elseif (str_contains($notif->link, 'regidor')) {
                            $canAccess = $user->can('acceder dashboard regidor');
                        } elseif (str_contains($notif->link, 'director')) {
                            $canAccess = $user->can('acceder dashboard director');
                        } elseif (str_contains($notif->link, 'auxiliar')) {
                            $canAccess = $user->can('acceder dashboard auxiliar');
                        } elseif (str_contains($notif->link, 'administrador')) {
                            $canAccess = $user->can('acceder dashboard administrador');
                        }
                    }
                    
                    // Solo agregar link si tiene permiso
                    if ($canAccess) {
                        $data['link'] = $notif->link;
                    }
                }
                
                return $data;
            });

        $unreadCount = Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

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

        $notification->markAsRead();

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
        Auth::user()
            ->unreadNotifications()
            ->update([
                'read' => true,
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
        Auth::user()
            ->notifications()
            ->read()
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notificaciones leídas eliminadas',
        ]);
    }
}