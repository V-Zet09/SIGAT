<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gobierno extends Model
{
    use HasFactory;

    protected $table = 'gobierno';

    protected $fillable = [
        'periodo',
        'presidente_nombre',
        'presidente_telefono',
        'presidente_facebook',
        'presidente_direccion',
        'presidente_imagen',
        'cabildo_imagen',
        'sindica_nombre',
        'secretario_nombre',
        'regidores'
    ];

    protected $casts = [
        'regidores' => 'array'
    ];

    /**
     * Accessor para la URL de la imagen del presidente
     */
    public function getPresidenteImagenUrlAttribute()
    {
        if ($this->presidente_imagen) {
            return Storage::url($this->presidente_imagen);
        }
        return asset('resources/images/presi.jpg');
    }

    /**
     * Accessor para la URL de la imagen del cabildo
     */
    public function getCabildoImagenUrlAttribute()
    {
        if ($this->cabildo_imagen) {
            return Storage::url($this->cabildo_imagen);
        }
        return asset('images/cabildo-municipal.jpg');
    }
}