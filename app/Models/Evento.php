<?php

namespace App\Models;

use App\Models\Bitacora;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table='evento';

    public function Bitacora(){  return $this->hasOne('App\Models\Bitacora', 'id', 'evento_id'); }
}
