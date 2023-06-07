<?php

namespace App\Exports;

use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithStyles;

class OrdenesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $estadoOrden;

    public function __construct($estadoOrden)
    {
        $this->estadoOrden = $estadoOrden;
    }

    public function collection()
    {
        $ordenes = Orden::where('estado', $this->estadoOrden)->get();

        return $ordenes->map(function ($orden) {
            return [
                $orden->fecha_registro,
                $orden->user->name,
                $orden->total,
                $orden->estado,
            ];
        });

    }

    public function headings(): array
    {
        return [
            'Fecha Registro',
            'Cliente',
            'Total',
            'Estado',
        ];
    }

    public function styles(Worksheet $sheet)
    {

        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
