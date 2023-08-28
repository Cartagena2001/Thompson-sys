<?php

namespace App\Models;

use App\Models\Orden;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Producto extends Model
{

    protected $fillable = [
        'slug',
        'sku',
        'OEM',
        'lote',
        'nombre',
        'descripcion',
        'marca_id',
        'origen',
        'categoria_id',
        'ref_1',
        'ref_2',
        'ref_3',
        'existencia',
        'existencia_limite',
        'garantia',
        'unidad_por_caja',
        'volumen',
        'unidad_volumen',
        'peso',
        'unidad_peso',
        'precio_distribuidor',
        'precio_taller',
        'precio_1',
        'precio_2',
        'precio_3',
        'precio_oferta',
        'hoja_seguridad',
        'ficha_tecnica_href',
        'imagen_1_src',
        'imagen_2_src',
        'imagen_3_src',
        'imagen_4_src',
        'estado_producto_id',
        'etiqueta_destacado',
        'fecha_ingreso',
    ];

    protected $table='producto';

    public function Orden(){  return $this->belongsTo('App\Models\Orden', 'orden_id'); }
    public function Producto(){  return $this->belongsTo('App\Models\Producto', 'producto_id'); }

    public function Categoria(){  return $this->hasOne('App\Models\Categoria', 'id', 'categoria_id'); }
    public function Marca(){  return $this->hasOne('App\Models\Marca', 'id', 'marca_id'); }
    public function EstadoProducto(){  return $this->hasOne('App\Models\EstadoProducto', 'id', 'estado_producto_id'); }
    public function PrecioDetalle(){ return $this->hasOne('App\Models\PrecioDetalle', 'precio_id', 'id');}
    
    public function getSlugAttribute()
    {
        return Str::slug($this->nombre);
    }
    
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

}
