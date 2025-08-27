<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades'; 

    protected $fillable = [
        'titulo',
        'autor',
        'fecha',
        'tipo_area',
        'resumen',
        'contenido',
        'presupuesto',
        'tipo_presupuesto',
        'numero',
        'fase',
        'foto',
    ];
}
