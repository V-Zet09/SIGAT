<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles; // si usas Spatie

class User extends Authenticatable implements AuthenticatableContract
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Atributos que se pueden asignar en masa.
     */
    protected $fillable = [
        'name',
        'sexo',
        'email',
        'password',
        'cargo',
        'area',
        'avatar',
        'last_activity_at',   // importante para el estado en línea
    ];

    /**
     * Atributos ocultos para arrays/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting de atributos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_activity_at'  => 'datetime',  // para usar Carbon directamente
    ];

    /**
     * Scope: usuarios considerados activos (online).
     */
    public function scopeActive($query, int $minutes = 5)
    {
        return $query->where('last_activity_at', '>=', now()->subMinutes($minutes));
    }

    /**
     * Scope: usuarios inactivos (offline).
     */
    public function scopeInactive($query, int $minutes = 5)
    {
        return $query
            ->whereNotNull('last_activity_at')
            ->where('last_activity_at', '<', now()->subMinutes($minutes));
    }

    /**
     * Saber si el usuario está en línea.
     */
    public function isOnline(int $minutes = 5): bool
    {
        if (! $this->last_activity_at instanceof Carbon) {
            return false;
        }

        return $this->last_activity_at->gte(now()->subMinutes($minutes));
    }
}
