<?php

namespace App\Models;

use App\Models\Evento;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{ 
    protected $table='bitacora';

    public function Evento(){  return $this->belongsTo('App\Models\Evento', 'evento_id'); }
    public function User(){  return $this->belongsTo('App\Models\User', 'user_id'); }
}
