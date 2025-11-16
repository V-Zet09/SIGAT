<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarruselFoto extends Model
{
    protected $fillable = ['imagen', 'titulo', 'descripcion', 'orden'];
}
