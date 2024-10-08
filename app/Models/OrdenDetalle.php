<?php

namespace App\Models;

use App\Models\Orden;
use App\Models\Producto;

use Illuminate\Database\Eloquent\Model;

class OrdenDetalle extends Model
{
    protected $table='orden_detalle';

    protected $fillable = [
        'orden_id', 
        'producto_id', 
        'cantidad',
        'cantidad_solicitada',  
        'cantidad_despachada', 
        'n_bulto',
        'precio',
        'descuento'
    ];

    public function Orden(){  return $this->belongsTo('App\Models\Orden', 'orden_id'); }
    public function Producto(){  return $this->belongsTo('App\Models\Producto', 'producto_id'); }
}
