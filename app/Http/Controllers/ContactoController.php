<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Http\Request;
use App\Models\Contacto;
use RealRashid\SweetAlert\Facades\Alert;


class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactos = Contacto::paginate(1000000000);
        
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

    private function sendMail($emailRecipient ,$emailSubject ,$emailBody ,$replyToEmail ,$replyToName ) 
    {

        require base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = env('SMTP_HOST', "");             //  smtp host p3plmcpnl492651.prod.phx3.secureserver.ne
            $mail->SMTPAuth = true;
            $mail->Username = env('SMTP_USERNAME', "");   //  sender username
            $mail->Password = env('SMTP_PASS', "");       // sender password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                  // encryption - ssl/tls
            $mail->Port = env('SMTP_PORT', "");                          // port - 587/465
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom('notificaciones@rtelsalvador.com', 'Representaciones Thompson');
            $mail->addAddress($emailRecipient); /* NOTA: mandar a llamar email según config en la BD*/
            //$mail->addCC($request->emailCc);
            //$mail->addBCC($request->emailBcc);

            $mail->addReplyTo($replyToEmail, $replyToName);

            /*
            if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }
            */

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $emailSubject;
            $mail->Body    = $emailBody;

            // $mail->AltBody = plain text version of email body;

            return $mail;
        
        } catch (Exception $e) {
             return redirect()->route('inicio')->with('error','Ha ocurrido algún error al enviar.');
        } 

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
        $contact->visto = 'nuevo';
        
        //echo '<script> console.log("fecha/hora: '.$contact->fecha_hora_form.' "); </script>';
        //echo '<script> console.log("boletin value: '.$request->get('boletin').' "); </script>';
        $boletinC = "";

        if ($request->get('boletin') == 'on') {
            
            $contact->boletin = 1;
            $boletinC = "si";
        } else {
            $contact->boletin = 0;
            $boletinC = "no";
        }

        $contact->save();


        //Envio de notificación por correo al cliente
        $emailRecipientClient = $request->get('emailC');
        $emailSubjectClient = 'Formulario de Contacto - RTElSalvador';
        $emailBodyClient = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/rtthompson-logo.png' style='width:100%; max-width:250px;'>
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
                        
        $replyToEmailClient = "oficina@rtelsalvador.com";
        $replyToNameClient = "Representaciones Thompson";

        $mailToClient = $this->sendMail($emailRecipientClient ,$emailSubjectClient ,$emailBodyClient ,$replyToEmailClient ,$replyToNameClient);

        //Envio de notificación por correo a oficina
        $emailRecipientOffice = "oficina@rtelsalvador.com";
        $emailSubjectOffice = 'Formulario de Contacto - RTElSalvador';
        $emailBodyOffice = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/rtthompson-logo.png' style='width:100%; max-width:250px;'>
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
                        
        $replyToEmailOffice = "oficina@rtelsalvador.com";
        $replyToNameOffice = "Representaciones Thompson";

        $mailToOffice = $this->sendMail($emailRecipientOffice ,$emailSubjectOffice ,$emailBodyOffice ,$replyToEmailOffice ,$replyToNameOffice);


        if( $mailToOffice->send() == null ) {

            return redirect()->route('inicio')->with('failed', 'Tu mensaje no ha podido ser enviado.');
        } 
        else {

            if ( $mailToClient->send() ){
                return redirect()->route('inicio')->with('success', 'Tu correo ha sido enviado con éxito.');
            } else {
                return redirect()->route('inicio')->with('success', 'Tu correo ha sido enviado con éxito.');
            }      
        }
                    
    }


    /**
     * 
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









