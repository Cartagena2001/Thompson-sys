<?php

namespace App\Imports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductoImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
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
            'marca_id' => 1,
            'origen' => $row['origen'],
            'categoria_id' => 1,
            'ref_1' => $row['ref1'],
            'ref_2' => $row['ref2'],
            'ref_3' => $row['ref3'],
            'existencia' => $row['existencia'],
            'garantia' => $row['garantia'],
            'unidad_por_caja' => $row['unidad_por_caja'],
            'volumen' => $row['volumen'],
            'unidad_volumen' => $row['und_vol'],
            'peso' => $row['peso'],
            'unidad_peso' => $row['und_peso'],
            'precio_distribuidor' => $row['precio_distribuidor'],
            'precio_taller' => $row['precio_taller'],
            'precio_1' => $row['precio_a'],
            'precio_2' => $row['precio_b'],
            'precio_3' => $row['precio_c'],
            'precio_oferta' => $row['precio_d'],
            'hoja_seguridad' => $row['hoja_de_seguridad'],
            'ficha_tecnica_href' => $row['ficha_tecnica'],
            'imagen_1_src' => $row['imagen1'],
            'imagen_2_src' => $row['imagen2'],
            'imagen_3_src' => $row['imagen3'],
            'imagen_4_src' => $row['imagen4'],
        ]);
    }

    public function batchSize(): int
    {
        return 4000;
    }

    public function chunkSize(): int
    {
        return 4000;
    }
}
