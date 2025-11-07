<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';
    
    protected $fillable = [
        'nombre',
        'puesto',
        'departamento',
        'jerarquia',
        'orden_visual',
        'esta_vacio',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'esta_vacio' => 'boolean',
    ];

    /**
     * Obtener subordinados del siguiente nivel
     */
    public function subordinados()
    {
        return $this->hasMany(Cargo::class, 'id_superior', 'id')
                    ->orderBy('orden_visual');
    }
}
