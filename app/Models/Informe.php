<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Informe extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'titulo',
        'periodo',
        'slug',
        'portada_path',
        
        // Comuna
        'presidente_nombre',
        'presidente_cargo',
        'sindicato_nombre',
        'sindicato_cargo',
        'secretario_nombre',
        'secretario_cargo',
        'regidores',
        
        // Municipio
        'municipio_nombre',
        'municipio_descripcion',
        'municipio_imagen_path',
        
        // Introducciones
        'introduccion',
        'introduccion_imagen_path',
        'gobierno_introduccion',
        'gobierno_imagen_path',
        
        // Actividades (filtros)
        'actividades_fecha_inicio',
        'actividades_fecha_fin',
        'dependencias_seleccionadas',
        
        // PDF
        'pdf_path',
        'descargas',
    ];

    protected $casts = [
        'regidores' => 'array',
        'dependencias_seleccionadas' => 'array',
        'actividades_fecha_inicio' => 'date',
        'actividades_fecha_fin' => 'date',
        'descargas' => 'integer',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generar slug automáticamente
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($informe) {
            if (empty($informe->slug)) {
                $informe->slug = Str::slug($informe->titulo . '-' . $informe->periodo);
            }
        });
    }

    // Método para obtener actividades filtradas
    public function getActividadesFiltradas()
    {
        // Aquí conectarás con el modelo de tu compañero
        // Por ahora retorno un ejemplo
        return \App\Models\Actividad::whereBetween('fecha', [
                $this->actividades_fecha_inicio,
                $this->actividades_fecha_fin
            ])
            ->whereIn('dependencia', $this->dependencias_seleccionadas)
            ->orderBy('fecha', 'desc')
            ->get();
    }
    
    // Incrementar contador de descargas
    public function incrementarDescargas()
    {
        $this->increment('descargas');
    }
}