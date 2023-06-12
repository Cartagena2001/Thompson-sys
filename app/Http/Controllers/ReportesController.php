<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ProductosExport;
use App\Exports\ClientesExport;
use App\Exports\MarcasExport;
use App\Exports\CategoriasExport;
use App\Exports\OrdenesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

class ReportesController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function productos()
    {
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }

    public function clientes(Request $request)
    {
        $request->validate([
            'estado' => 'required|in:aprobado,aspirante,rechazado',
        ]);

        $estado = $request->input('estado');
        $clientes = User::where('estatus', $estado)->get();
        $nombreArchivo = 'clientes_' . $estado . '.xlsx';

        return Excel::download(new ClientesExport($estado), $nombreArchivo);
    }

    public function marcas()
    {
        return Excel::download(new MarcasExport, 'marcas.xlsx');
    }

    public function categorias()
    {
        return Excel::download(new CategoriasExport, 'categorias.xlsx');
    }

    public function ordenes(Request $request)
    {
        $request->validate([
            'estadoOrden' => 'required|in:Pendiente,En Proceso,Finalizada,Cancelada',
        ]);
        $estadoOrden = $request->input('estadoOrden');
        $nombreArchivo = 'ordenes_' . $estadoOrden . '.xlsx';

        return Excel::download(new OrdenesExport($estadoOrden), $nombreArchivo);
    }


}
