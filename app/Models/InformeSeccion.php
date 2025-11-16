<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformeSeccion extends Model
{
    protected $table = 'informe_secciones';
    
    protected $fillable = [
        'informe_id',
        'titulo',
        'contenido',
        'nivel',
        'orden',
        'pagina',
        'mostrar_indice'
    ];

    public function informe()
    {
        return $this->belongsTo(Informe::class);
    }
    
    // Generar número para el índice
    public function getNumeroSeccionAttribute()
    {
        $secciones = $this->informe->secciones()
            ->where('nivel', 1)
            ->where('orden', '<=', $this->orden)
            ->count();
            
        return $secciones;
    }
}
