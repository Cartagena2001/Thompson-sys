<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table='categoria';

    public function Marca(){  return $this->belongsToMany('App\Models\Marca', 'marca_cat', 'categoria_id', 'marca_id'); } 

}
