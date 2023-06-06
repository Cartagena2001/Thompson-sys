<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class ClientesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $estado;

    public function __construct($estado)
    {
        $this->estado = $estado;
    }

    public function collection()
    {
        $clientes = User::where('estatus', $this->estado)->get();

        return $clientes->map(function ($cliente) {
            return [
                $cliente->name,
                $cliente->apellido,
                $cliente->telefono,
                $cliente->direccion,
                $cliente->email,
                $cliente->nombre_empresa,
                $cliente->website,
                $cliente->nit,
                $cliente->nrc,
                $cliente->clasificacion,
            ];
        }); 
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'Apellido',
            'Telefono',
            'Direccion',
            'Correo',
            'Nombre de la empresa',
            'Website',
            'NIT',
            'NRC',
            'Clasificacion',
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
