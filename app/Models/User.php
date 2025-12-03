<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\Auditable; // ← AGREGADO

/**
 * @method bool hasRole(string $roleName)
 * @method \Illuminate\Database\Eloquent\Relations\HasMany notifications()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany unreadNotifications()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Auditable; // ← AGREGADO Auditable

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'sexo',
        'area',
        'cargo',
        'email',
        'password',
        'avatar',
        'last_login_at',    
        'last_login_ip',     
        'login_history',       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',     
        'login_history' => 'array',        
    ];

    // =======================
    // 🔗 RELACIONES
    // =======================
    
    /**
     * Relación con notificaciones
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }

    /**
     * Notificaciones no leídas
     */
    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }

    /**
     * Contar notificaciones no leídas
     */
    public function unreadNotificationsCount()
    {
        return $this->unreadNotifications()->count();
    }

    /**
     * Logs de auditoría del usuario
     */
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class)->latest();
    }

    /**
     * Última actividad registrada
     */
    public function lastActivity()
    {
        return $this->hasOne(AuditLog::class)->latest();
    }

    /**
     * Actividades creadas por este usuario
     */
    public function actividadesCreadas()
    {
        return $this->hasMany(Actividad::class, 'creado_por_id');
    }

    /**
     * Actividades donde es responsable
     */
    public function actividadesResponsable()
    {
        return $this->hasMany(Actividad::class, 'responsable_id');
    }

    /**
     * Informes creados por este usuario
     */
    public function informes()
    {
        return $this->hasMany(Informe::class, 'user_id');
    }

    // =======================
    // 🎯 MÉTODOS DE ESTADO
    // =======================
    
    /**
     * Verificar si el usuario está en línea (últimos 5 minutos)
     */
    public function isOnline()
    {
        return $this->last_login_at && 
               $this->last_login_at->diffInMinutes(now()) < 5;
    }

    /**
     * Obtener el estado del usuario (online, away, offline)
     */
    public function getStatusAttribute()
    {
        if ($this->isOnline()) {
            return 'online';
        }
        
        if ($this->last_login_at && $this->last_login_at->diffInHours(now()) < 24) {
            return 'away';
        }
        
        return 'offline';
    }

    /**
     * Obtener texto del estado
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'online' => 'En línea',
            'away' => 'Ausente',
            'offline' => 'Desconectado',
            default => 'Desconocido',
        };
    }
}
