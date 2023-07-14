<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacto;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ContactosController extends Controller
{
    public function index()
    {
        $contactos = Contacto::paginate(10);
        
        return view('contactos.index', compact('contactos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //SIN USAR AÚN
        $contacto = new Contacto();

        return view('contacto.create', compact('contacto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validar campos
        $request->validate([
            'nomC' => 'required',
            'emailC' => 'required',
            'nomEC' => 'required',
            'numWC' => 'required',
        ]);

        //almacenar datos
        $contact = new Contacto();
        $contact->nombre = $request->get('nomC');
        $contact->correo = $request->get('emailC');
        $contact->nombre_empresa = $request->get('nomEC');
        $contact->numero_whatsapp = $request->get('numWC');
        $contact->mensaje = $request->get('msjC');
        $contact->fecha_hora_form = \Carbon\Carbon::now()->toDateTimeString();
        $contact->boletin = $request->get('boletin');

        $contact->save();
      
        //redireccionar
        return redirect()->route('/')->with('success', 'Tu mensaje ha sido enviado con éxito');
    }

    public function show($id)
    {
        $contacto = Contacto::find($id);

        return view('contactos.show', compact('contacto'));
    }

}









