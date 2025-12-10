<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'url',
        'method',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Registrar un log de auditoría
     */
    public static function log($action, $description, $modelType = null, $modelId = null, $oldValues = null, $newValues = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name,
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
        ]);
    }

    /**
     * Obtener icono según la acción
     */
    public function getIconAttribute()
    {
        return match($this->action) {
            'crear' => 'fa-plus-circle',
            'editar' => 'fa-edit',
            'eliminar' => 'fa-trash',
            'aprobar' => 'fa-check-circle',
            'rechazar' => 'fa-times-circle',
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'ver' => 'fa-eye',
            'descargar' => 'fa-download',
            'exportar' => 'fa-file-export',
            default => 'fa-circle',
        };
    }

    /**
     * Obtener color según la acción
     */
    public function getColorAttribute()
    {
        return match($this->action) {
            'crear' => 'green',
            'editar' => 'blue',
            'eliminar' => 'red',
            'aprobar' => 'emerald',
            'rechazar' => 'orange',
            'login' => 'cyan',
            'logout' => 'gray',
            'ver' => 'purple',
            'descargar' => 'indigo',
            default => 'gray',
        };
    }

    /**
     * Obtener nombre amigable del modelo
     */
    public function getModelNameAttribute()
    {
        return match($this->model_type) {
            'App\Models\User' => 'Usuario',
            'App\Models\Actividad' => 'Actividad',
            'App\Models\Informe' => 'Informe',
            null => 'Sistema',
            default => class_basename($this->model_type ?? ''),
        };
    }
}
