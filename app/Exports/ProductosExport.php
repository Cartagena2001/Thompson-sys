<?php

namespace App\Exports;

use App\Models\Producto;
use App\Models\EstadoProducto;
use App\Models\Marca;
use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ProductosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $productos = Producto::all();
        //traer el estado del producto para cada producto
        $productos->map(function ($producto) {
            $estado = EstadoProducto::find($producto->estado_producto_id);
            $producto->estado = $estado->estado;
        });

        //traer la marca del producto para cada producto
        $productos->map(function ($producto) {
            $marca = Marca::find($producto->marca_id);
            $producto->marca = $marca->nombre;
        });

        //traer la categoria del producto para cada producto
        $productos->map(function ($producto) {
            $categoria = Categoria::find($producto->categoria_id);
            $producto->categoria = $categoria->nombre;
        });

        return $productos->map(function ($producto) {
            return [
                $producto->nombre,
                $producto->OEM,
                $producto->descripcion,
                $producto->origen,
                $producto->existencia,
                $producto->precio_1,
                $producto->marca,
                $producto->categoria,
                $producto->estado,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'OEM',
            'Descripción',
            'Origen',
            'Stock',
            'Precio',
            'Marca',
            'Categoría',
            'Estado',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('C')->setAutoSize(false); // Desactivar ajuste automático de ancho
        $sheet->getColumnDimension('C')->setWidth(90); // Establecer ancho de la columna B (descripción)

        $sheet->getStyle('C')->getAlignment()->setWrapText(true); // Activar ajuste de texto en la celda B

        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}