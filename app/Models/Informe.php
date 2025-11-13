<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Informe extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'informes'; 
    
    protected $fillable = [
        'user_id',
        'slug',
        'portada_imagen_path',
        'plantilla_imagen_path',
        'comuna_imagen_path',
        
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
        
        // ✅ CAMPOS DE NOTIFICACIONES (si los agregaste en la migración)
        'creado_por_id',
        'codigo',
        'estado',
        'aprobada_por',
        'fecha_aprobacion',
        'rechazada_por',
        'motivo_rechazo',
        'fecha_rechazo',
        'comentarios',
    ];

    protected $casts = [
        'regidores' => 'array',
        'dependencias_seleccionadas' => 'array',
        'actividades_fecha_inicio' => 'date',
        'actividades_fecha_fin' => 'date',
        'descargas' => 'integer',
        'fecha_aprobacion' => 'datetime',
        'fecha_rechazo' => 'datetime',
        'comentarios' => 'array',
    ];

    // RELACIONES
    
    /**
     * Usuario que creó el informe
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function secciones()
    {
        return $this->hasMany(InformeSeccion::class)->orderBy('orden');
    }

    // ✅ Método boot optimizado - Solo crea secciones después de guardar
    /**
     * Alias para compatibilidad con notificaciones
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Usuario que aprobó el informe
     */
    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobada_por');
    }

    /**
     * Usuario que rechazó el informe
     */
    public function rechazador()
    {
        return $this->belongsTo(User::class, 'rechazada_por');
    }

    // ✅ BOOT: Generar slug automáticamente
    protected static function boot()
    {
        parent::boot();
        
        // Crear secciones por defecto después de crear el informe
        static::created(function ($informe) {
            $informe->crearSeccionesPorDefecto();
        });
    }

    // Método para crear secciones por defecto
    public function crearSeccionesPorDefecto()
    {
        $seccionesDefault = [
            ['titulo' => 'Introducción', 'nivel' => 1, 'orden' => 1],
            ['titulo' => 'Información General del Municipio', 'nivel' => 1, 'orden' => 2],
            ['titulo' => 'Gobierno y Desarrollo Municipal', 'nivel' => 1, 'orden' => 3],
            ['titulo' => 'Despacho del Presidente Municipal', 'nivel' => 2, 'orden' => 4],
            ['titulo' => 'Secretaría Particular', 'nivel' => 3, 'orden' => 5],
            ['titulo' => 'Sindicatura', 'nivel' => 1, 'orden' => 6],
            ['titulo' => 'Secretaría General', 'nivel' => 1, 'orden' => 7],
            ['titulo' => 'Tesorería', 'nivel' => 1, 'orden' => 8],
            ['titulo' => 'Obras Públicas', 'nivel' => 1, 'orden' => 9],
            ['titulo' => 'DIF Municipal', 'nivel' => 1, 'orden' => 10],
        ];
        
        foreach ($seccionesDefault as $seccion) {
            $this->secciones()->create($seccion);
        }
    }

    // Método para obtener actividades filtradas
        static::creating(function ($informe) {
            if (empty($informe->slug)) {
                $slug = Str::slug($informe->titulo . '-' . $informe->periodo);
                $slugOriginal = $slug;
                $contador = 1;
                
                // Asegurar que el slug sea único
                while (self::where('slug', $slug)->exists()) {
                    $slug = $slugOriginal . '-' . $contador;
                    $contador++;
                }
                
                $informe->slug = $slug;
            }
        });
    }

    // ✅ MÉTODOS AUXILIARES
    
    /**
     * Obtener actividades filtradas según los criterios del informe
     */
    public function getActividadesFiltradas()
    {
        return \App\Models\Actividad::whereBetween('fecha', [
                $this->actividades_fecha_inicio,
                $this->actividades_fecha_fin
            ])
            ->when($this->dependencias_seleccionadas, function($query) {
                $query->whereIn('tipo_area', $this->dependencias_seleccionadas);
            })
            ->whereIn('tipo_area', $this->dependencias_seleccionadas ?? [])
            ->orderBy('fecha', 'desc')
            ->get();
    }
    
    /**
     * Incrementar contador de descargas
     */
    public function incrementarDescargas()
    {
        $this->increment('descargas');
    }
}

    /**
     * Verificar si el informe está aprobado
     */
    public function estaAprobado()
    {
        return $this->estado === 'Aprobado';
    }

    /**
     * Verificar si el informe está rechazado
     */
    public function estaRechazado()
    {
        return $this->estado === 'Rechazado';
    }

    /**
     * Verificar si el informe está pendiente
     */
    public function estaPendiente()
    {
        return $this->estado === 'Pendiente' || $this->estado === null;
    }
}
