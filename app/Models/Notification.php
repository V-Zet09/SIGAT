<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    // IMPORTANTE: Decirle a Eloquent que el ID no es auto-incrementable (es UUID)
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',               // Necesario para guardar el UUID manual
        'notifiable_id',    // Nuevo campo
        'notifiable_type',  // Nuevo campo
        'type',
        'title',
        'message',
        'icon',
        'color',
        'link',
        'read_at',          // Usaremos esto para saber si está leída
        'data',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    // ✅ Relación Polimórfica (Reemplaza a user())
    public function notifiable()
    {
        return $this->morphTo();
    }

    // ✅ Helper para obtener el usuario fácilmente (si siempre son usuarios)
    public function user()
    {
        // Esto asume que el notifiable_type siempre es App\Models\User
        return $this->belongsTo(User::class, 'notifiable_id');
    }

    // ✅ Scope: Solo no leídas (Ahora se basa en si read_at es null)
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    // ✅ Scope: Solo leídas
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    // ✅ Scope: Por tipo
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // ✅ Marcar como leída
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update([
                'read_at' => now(),
            ]);
        }
    }

    // ✅ Marcar como no leída
    public function markAsUnread()
    {
        $this->update([
            'read_at' => null,
        ]);
    }

    // ✅ Atributo virtual 'read' para compatibilidad con tu código viejo
    public function getReadAttribute()
    {
        return !is_null($this->read_at);
    }

    // ✅ Tiempo desde creación
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
