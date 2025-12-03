<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Traits\Auditable; // ← AGREGADO

class Informe extends Model
{
    use HasFactory, SoftDeletes, Auditable; // ← AGREGADO Auditable

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
        
        // ✅ CAMPOS DE NOTIFICACIONES
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

    // =======================
    // 🔗 RELACIONES
    // =======================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function secciones()
    {
        return $this->hasMany(InformeSeccion::class)->orderBy('orden');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobada_por');
    }

    public function rechazador()
    {
        return $this->belongsTo(User::class, 'rechazada_por');
    }

    // =======================
    // ⚙️ BOOT Y EVENTOS
    // =======================
    protected static function boot()
    {
        parent::boot();
        
        // Crear slug automáticamente
        static::creating(function ($informe) {
            if (empty($informe->slug)) {
                $slug = Str::slug(($informe->titulo ?? 'informe') . '-' . ($informe->periodo ?? now()->year));
                $slugOriginal = $slug;
                $contador = 1;
                
                while (self::where('slug', $slug)->exists()) {
                    $slug = $slugOriginal . '-' . $contador;
                    $contador++;
                }
                
                $informe->slug = $slug;
            }
        });

        // Crear secciones por defecto después de crear el informe
        static::created(function ($informe) {
            $informe->crearSeccionesPorDefecto();
        });
    }

    // =======================
    // 🧩 MÉTODOS PERSONALIZADOS
    // =======================
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

    public function getActividadesFiltradas()
    {
        return \App\Models\Actividad::whereBetween('fecha', [
                $this->actividades_fecha_inicio,
                $this->actividades_fecha_fin
            ])
            ->when($this->dependencias_seleccionadas, function($query) {
                $query->whereIn('tipo_area', $this->dependencias_seleccionadas);
            })
            ->orderBy('fecha', 'desc')
            ->get();
    }
    
    public function incrementarDescargas()
    {
        $this->increment('descargas');
    }

    public function estaAprobado()
    {
        return $this->estado === 'Aprobado';
    }

    public function estaRechazado()
    {
        return $this->estado === 'Rechazado';
    }

    public function estaPendiente()
    {
        return $this->estado === 'Pendiente' || $this->estado === null;
    }
}
