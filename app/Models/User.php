<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'sexo',
        'area',
        'cargo',
        'email',
        'password',
        'avatar',
        'telefono',
        'jefe_id',
        'orden',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación: Un usuario puede tener un jefe
     */
    public function jefe()
    {
        return $this->belongsTo(User::class, 'jefe_id');
    }

    /**
     * Relación: Un usuario puede tener muchos subordinados
     */
    public function subordinados()
    {
        return $this->hasMany(User::class, 'jefe_id')->orderBy('orden');
    }

    /**
     * Relación recursiva para obtener todos los subordinados anidados
     */
    public function subordinadosRecursivos()
    {
        return $this->subordinados()->with('subordinadosRecursivos');
    }
}