<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';
    
        protected $fillable = [
        'titulo',
        'autor',
        'fecha',
        'tipo_area',
        'tipo_actividad',
        'resumen',
        'contenido',
        'presupuesto',
        'tipo_presupuesto',
        'numero',
        'fase',
        'fotos', // Solo este campo
        'creado_por_id',
        'responsable_id',
        'estado',
        'aprobada_por',
        'fecha_aprobacion',
        'rechazada_por',
        'motivo_rechazo',
        'fecha_rechazo',
        'evidencias',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_aprobacion' => 'datetime',
        'fecha_rechazo' => 'datetime',
        'evidencias' => 'array',
        'fotos' => 'array', // Solo este campo
    ];


    // RELACIONES
    
    /**
     * Usuario que creó la actividad
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por_id');
    }

    /**
     * Usuario responsable de la actividad
     */
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * Usuario que aprobó
     */
    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobada_por');
    }

    /**
     * Usuario que rechazó
     */
    public function rechazador()
    {
        return $this->belongsTo(User::class, 'rechazada_por');
    }
}