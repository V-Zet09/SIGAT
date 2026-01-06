<?php

if (!function_exists('isUserOnline')) {
    function isUserOnline($userId)
    {
        $user = \App\Models\User::find($userId);
        
        if (!$user || !$user->last_activity_at) {
            return false;
        }
        
        // Considerar en línea si estuvo activo en los últimos 5 minutos
        return $user->last_activity_at->diffInMinutes(now()) < 5;
    }
}
