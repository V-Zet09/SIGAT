<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presidente extends Model
{
    protected $table = 'presidente';
    
    protected $fillable = [
        'nombre',
        'cargo',
        'foto',
        'biografia'
    ];
}