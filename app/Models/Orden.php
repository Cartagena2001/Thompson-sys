<?php

namespace App\Models;

use App\Models\Cliente;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
  protected $table='orden';

  protected $fillable = [
      'fecha_registro', 
      'user_id', 
      'estado', 
      'fecha_envio', 
      'fecha_entrega', 
      'total', 
      'notas', 
      'notas_bodega', 
      'visto', 
      'corr', 
      'ubicacion', 
      'bulto', 
      'paleta', 
      'factura_href',
      'hoja_salida_href',
      'comprobante_pago_href',
      'tipo_pago',
      'periodicidad'
  ];

  public function User(){  return $this->belongsTo('App\Models\User', 'user_id'); }
}
