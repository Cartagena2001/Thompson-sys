<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;

class AspirantesController extends Controller
{
    public function index()
    {
        $aspirantes = User::where('estatus', 'aspirante')->orWhere('estatus', 'rechazado')->paginate();
        
        return view('aspirantes.index', compact('aspirantes'));
    }

    public function show($id)
    {
        $aspirante = User::find($id);
        $marcas = Marca::all();

        return view('aspirantes.show', compact('aspirante', 'marcas'));
    }

    public function aprobado($id)
    {
        $aspirante = User::find($id);
        $aspirante->estatus = 'aprobado';
        $aspirante->clasificacion = 'Cobre';
        $aspirante->form_status = 'none';
        $aspirante->save();

        return redirect('/dashboard/aspirantes')->with('toast_success', 'Se actualizó el estado del aspirante a Aprobado');
    }

    public function rechazado($id)
    {
        $aspirante = User::find($id);
        $aspirante->estatus = 'rechazado';
        $aspirante->form_status = 'pending';
        $aspirante->save();

        return redirect('/dashboard/aspirantes')->with('toast_success', 'Se actualizó el estado del aspirante a Rechazado');
    }
}