<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ProductosExport;
use App\Exports\ClientesExport;
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
}
