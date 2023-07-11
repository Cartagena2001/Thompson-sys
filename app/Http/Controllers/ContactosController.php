<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;
use Illuminate\Support\Facades\Auth;

class ContactosController extends Controller
{
    public function index()
    {
        $contactos = Contacto::paginate(10);
        
        return view('contactos.index', compact('contactos'));
    }

    public function show($id)
    {
        $contacto = Contacto::find($id);

        return view('contactos.show', compact('contacto'));
    }

}