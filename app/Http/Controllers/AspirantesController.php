<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AspirantesController extends Controller
{
    public function index()
    {
        $aspirantes = User::where('estatus', 'aspirante')->paginate();
        return view('aspirantes.index', compact('aspirantes'));
    }

    public function show($id)
    {
        $aspirante = User::find($id);
        return view('aspirantes.show', compact('aspirante'));
    }

    public function aprovado($id)
    {
        $aspirante = User::find($id);
        $aspirante->estatus = 'aprobado';
        $aspirante->save();
        return redirect('/dashboard/aspirantes')->with('toast_success', 'Se actualizo el estado del aspirante a Aprobado');
    }

    public function rechazado($id)
    {
        $aspirante = User::find($id);
        $aspirante->estatus = 'rechazado';
        $aspirante->save();
        return redirect('/dashboard/aspirantes')->with('toast_success', 'Se actualizo el estado del aspirante a Rechazado');
    }
}