<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'correo',
        'nombre_empresa',
        'numero_whatsapp',
        'mensaje',
        'boletin',
        'fecha_hora_form'
    ];

    protected $table='contacto';
}


