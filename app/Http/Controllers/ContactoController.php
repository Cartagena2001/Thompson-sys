<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PHPMailerController;
use Illuminate\Http\Request;
use App\Models\Contacto;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Collection;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        echo '<script> console.log("working... ¿?"); </script>';

        //almacenar datos
        $contact = new Contacto();
        $contact->nombre = $request->get('nomC');
        $contact->correo = $request->get('emailC');
        $contact->nombre_empresa = $request->get('nomEC');
        $contact->numero_whatsapp = $request->get('numWC');
        $contact->mensaje = $request->get('msjC');
        $contact->fecha_hora_form = \Carbon\Carbon::now()->toDateTimeString();
        echo '<script> console.log("fecha/hora: '.$contact->fecha_hora_form.' "); </script>';

        //echo '<script> console.log("boletin value: '.$request->get('boletin').' "); </script>';
         $boletinC = "";


        echo '<script> console.log("working... 1"); </script>';

        if ($request->get('boletin') == 'on') {
            
            $contact->boletin = 1;
            $boletinC = "si";
        } else {
            $contact->boletin = 0;
            $boletinC = "no";
        }

        $contact->save();

        $messageBody = " 
                        <div style='display: flex; justify-content: center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/rtthompson-logo.png'>
                        </div>

                        <br/>
                        <br/>

                        <p><b>¡TU MENSAJE HA SIDO RECIBIDO!</b></p>
                        
                        <br/>

                        <p><b>RESUMEN</b>:</p>
                        <p><b>Nombre</b>: ".$contact->nombre." <br/>
                           <b>Correo electrónico</b>: ".$contact->correo." <br/>
                           <b>Nombre Empresa/Negocio</b>: ".$contact->nombre_empresa." <br/>
                           <b>WhatsApp</b>: ".$contact->numero_whatsapp." <br/>
                           <b>Mensaje</b>: ".$contact->mensaje." <br/>
                           <b>Fecha/Hora</b>: ".$contact->fecha_hora_form." <br/>
                           <b>Suscrito a Boletín: ".$boletinC."
                        </p>

                        <br/>
                        
                        <p>Pronto nos pondremos en contacto.</p>
                        ";

        $message = collect(['emailRecipient'=>$contact->correo, 
                            'emailSubject'=>'Formulario de Contacto - RTElSalvador',
                            'emailBody'=>$messageBody]);

        $otherController = new PHPMailerController();
        $otherController->sendEmailNotif($message);

        echo '<script> console.log("working... 3"); </script>';
      
        //redireccionar
        return redirect()->route('inicio')->with('success', 'Tu mensaje ha sido enviado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contacto = Contacto::find($id);

        return view('contactos.show', compact('contacto'));
    }

}









