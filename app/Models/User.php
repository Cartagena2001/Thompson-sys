<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cliente_id_interno',
        'form_status',
        'direccion',
        'nombre_empresa',
        'razon_social',
        'giro',
        'municipio',
        'departamento',
        'telefono',
        'whatsapp',
        'website',
        'nit',
        'dui',
        'nrc',
        'rol_id',
        'estado',
        'cat_mod',
        'clasificacion',
        'boletin',
        'fecha_registro',
        'imagen_perfil_src',
        'marcas',
        'notas',
        'estatus',
        'visto',
        'usr_tipo'
    ];

    protected $table='users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function User(){  return $this->belongsTo('App\Models\User', 'users_id'); }
    public function Rol(){  return $this->hasOne('App\Models\Rol', 'id', 'rol_id'); }
}
