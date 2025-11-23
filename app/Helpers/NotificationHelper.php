<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;

class NotificationHelper
{
    /**
     * Enviar notificación a un usuario
     */
    public static function send($userId, $type, $title, $message, $options = [])
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $options['icon'] ?? self::getDefaultIcon($type),
            'color' => $options['color'] ?? self::getDefaultColor($type),
            'link' => $options['link'] ?? null,
            'data' => $options['data'] ?? null,
        ]);
    }

    /**
     * Enviar notificación a múltiples usuarios
     */
    public static function sendToMany($userIds, $type, $title, $message, $options = [])
    {
        foreach ($userIds as $userId) {
            self::send($userId, $type, $title, $message, $options);
        }
    }

    /**
     * Enviar notificación a usuarios con un rol específico
     */
    public static function sendToRole($roleName, $type, $title, $message, $options = [])
    {
        $users = User::role($roleName)->pluck('id');
        self::sendToMany($users, $type, $title, $message, $options);
    }

    /**
     * Iconos por defecto según tipo
     */
    private static function getDefaultIcon($type)
    {
        $icons = [
            'actividad' => 'ri-calendar-check-line',
            'informe' => 'ri-file-list-line',
            'sistema' => 'ri-settings-line',
            'usuario' => 'ri-user-line',
        ];

        return $icons[$type] ?? 'ri-notification-line';
    }

    /**
     * Colores por defecto según tipo
     */
    private static function getDefaultColor($type)
    {
        $colors = [
            'actividad' => 'blue',
            'informe' => 'green',
            'sistema' => 'yellow',
            'usuario' => 'purple',
        ];

        return $colors[$type] ?? 'gray';
    }
}