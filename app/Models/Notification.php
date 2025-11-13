<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'icon',
        'color',
        'link',
        'read',
        'read_at',
        'data',
    ];

    protected $casts = [
        'read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    // ✅ Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Scope: Solo no leídas
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    // ✅ Scope: Solo leídas
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    // ✅ Scope: Por tipo
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // ✅ Marcar como leída
    public function markAsRead()
    {
        $this->update([
            'read' => true,
            'read_at' => now(),
        ]);
    }

    // ✅ Marcar como no leída
    public function markAsUnread()
    {
        $this->update([
            'read' => false,
            'read_at' => null,
        ]);
    }

    // ✅ Tiempo desde creación (hace 5 minutos, hace 2 horas, etc.)
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}