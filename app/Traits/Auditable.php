<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    /**
     * Boot del trait
     */
    protected static function bootAuditable()
    {
        // =============================
        // 📝 AL CREAR UN REGISTRO
        // =============================
        static::created(function ($model) {
            $modelName = class_basename($model);
            $identifier = $model->titulo ?? $model->name ?? $model->municipio_nombre ?? "#{$model->id}";
            
            AuditLog::log(
                action: 'crear',
                description: "Creó {$modelName}: {$identifier}",
                modelType: get_class($model),
                modelId: $model->id,
                oldValues: null,
                newValues: $model->getAttributes()
            );
        });

        // =============================
        // ✏️ AL ACTUALIZAR UN REGISTRO
        // =============================
        static::updated(function ($model) {
            $modelName = class_basename($model);
            $identifier = $model->titulo ?? $model->name ?? $model->municipio_nombre ?? "#{$model->id}";
            
            $changes = $model->getChanges();
            $original = $model->getOriginal();
            
            // Filtrar solo los campos que cambiaron
            $oldValues = array_intersect_key($original, $changes);
            $newValues = $changes;
            
            // Crear descripción detallada
            $description = "Editó {$modelName}: {$identifier}";
            
            // Detectar cambios específicos importantes
            if (isset($changes['estado'])) {
                $oldEstado = $original['estado'] ?? 'sin estado';
                $newEstado = $changes['estado'];
                $description .= " - Estado: {$oldEstado} → {$newEstado}";
            }
            
            if (isset($changes['aprobada_por']) && !isset($original['aprobada_por'])) {
                $description = "Aprobó {$modelName}: {$identifier}";
            }
            
            if (isset($changes['rechazada_por']) && !isset($original['rechazada_por'])) {
                $motivo = $changes['motivo_rechazo'] ?? 'sin motivo';
                $description = "Rechazó {$modelName}: {$identifier} - Motivo: {$motivo}";
            }
            
            AuditLog::log(
                action: 'editar',
                description: $description,
                modelType: get_class($model),
                modelId: $model->id,
                oldValues: $oldValues,
                newValues: $newValues
            );
        });

        // =============================
        // 🗑️ AL ELIMINAR UN REGISTRO
        // =============================
        static::deleted(function ($model) {
            $modelName = class_basename($model);
            $identifier = $model->titulo ?? $model->name ?? $model->municipio_nombre ?? "#{$model->id}";
            
            AuditLog::log(
                action: 'eliminar',
                description: "Eliminó {$modelName}: {$identifier}",
                modelType: get_class($model),
                modelId: $model->id,
                oldValues: $model->getAttributes(),
                newValues: null
            );
        });
    }
}
