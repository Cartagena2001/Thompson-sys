<?php

namespace App\Imports;

use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Producto;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Str;

class ProductoImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation, WithMultipleSheets 
{

    private $marca;
    private $categoria;

    public function __construct()
    {
        $this->marca = Marca::pluck('id', 'nombre');
        $this->categoria = Categoria::pluck('id', 'nombre');
    }

    private function generateSlug($value)
    {
        return Str::slug($value);
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Producto([
  
            'OEM' => $row['oem'],
            'lote' => $row['lote'],
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
            'caracteristicas' => $row['caracteristicas'],
            'marca_id' => $row['marca'],
            'origen' => $row['origen'],
            'categoria_id' => $row['categoria'],
            'ref_1' => $row['ref1'],
            'ref_2' => $row['ref2'],
            'ref_3' => $row['ref3'],
            'existencia' => $row['existencia'],
            'existencia_limite' => $row['existencia_limite'],
            'garantia' => $row['garantia'],
            'ubicacion_bodega' => $row['ubicacion_bodega'],
            'ubicacion_oficina' => $row['ubicacion_oficina'],
            'unidad_por_caja' => $row['unidad_por_caja'],
            'mod_venta' => $row['modalidad_venta'],
            'volumen' => $row['volumen'],
            'unidad_volumen' => $row['und_vol'],
            'peso' => $row['peso'],
            'unidad_peso' => $row['und_peso'],
            'precio_distribuidor' => $row['precio_distribuidor'],
            'precio_taller' => $row['precio_taller'],
            'precio_1' => $row['precio_costo'],
            'precio_2' => $row['precio_op'],
            'precio_oferta' => $row['precio_oferta'],
            'hoja_seguridad' => $row['hoja_de_seguridad'],
            'ficha_tecnica_href' => $row['ficha_tecnica'],
            'imagen_1_src' => $row['imagen1'],
            'imagen_2_src' => $row['imagen2'],
            'imagen_3_src' => $row['imagen3'],
            'imagen_4_src' => $row['imagen4'],
            'imagen_5_src' => $row['imagen5'],
            'imagen_6_src' => $row['imagen6'],
            
            //campos que no estan en el excel
            //'estado_producto_id' => 1,
            'slug' => $this->generateSlug($row['nombre']),
            'sku' => '-',
            'precio_3' => 0.00,
            'fecha_ingreso' => \Carbon\Carbon::now(),
            'etiqueta_destacado' => 0
        ]);
    }

    public function rules(): array
    {
        return [
            '*.oem' => 'required | unique:producto',
            '*.nombre' => 'required',
            '*.descripcion' => 'required',
            '*.marca' => 'required',
            '*.categoria' => 'required',
        ];
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
