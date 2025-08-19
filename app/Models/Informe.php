<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Informe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'periodo',
        'portada_path',
        'comuna_path',
        'introduccion',
        'actividades',
        'conclusion',
        'actividades_imagen_path',
        'slug'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesor para la URL de la portada
    public function getPortadaUrlAttribute()
    {
        return $this->portada_path ? Storage::url($this->portada_path) : null;
    }

    // Accesor para la URL de la comuna
    public function getComunaUrlAttribute()
    {
        return $this->comuna_path ? Storage::url($this->comuna_path) : null;
    }

    // Accesor para la URL de actividades
    public function getActividadesImagenUrlAttribute()
    {
        return $this->actividades_imagen_path ? Storage::url($this->actividades_imagen_path) : null;
    }
}