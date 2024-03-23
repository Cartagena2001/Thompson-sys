<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class AspirantesController extends Controller
{
    public function index()
    {
        $aspirantes = User::where('estatus', 'aspirante')->orWhere('estatus', 'rechazado')->paginate(1000000000);
        
        return view('aspirantes.index', compact('aspirantes'));
    }

    public function show($id)
    {
        $aspirante = User::find($id);
        $marcas = Marca::all();

        $aspirante->visto = 'visto';
        $aspirante->update();

        return view('aspirantes.show', compact('aspirante', 'marcas'));
    }

    public function aprobado($id)
    {
        $aspirante = User::find($id);
        $aspirante->estatus = 'aprobado';
        //$aspirante->clasificacion = 'precioOp';
        $aspirante->form_status = 'none';
        $aspirante->save();

        $mailToClient = new PHPMailer(true);     // Passing `true` enables exceptions

        $mailToOffice = new PHPMailer(true);     // Passing `true` enables exceptions
        
        //Envio de notificación por correo al aspirante ahora cliente
        $emailRecipientClient = $aspirante->email;
        $emailSubjectClient = 'Bienvenido'.$aspirante->name.' - Tienda RTElSalvador';
        $emailBodyClient = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/rtthompson-logo.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p><b>BIENVENIDO</b></p>
                        
                        <br/>

                        <p><b>Sr./Sra.</b>: ".$aspirante->name." </p>
                        <p><b>Correo electrónico</b>: ".$aspirante->email."</p>

                        <br/>
                        
                        <p>Reciba una cordial bienvenida a nuestra tienda en línea, ya puedes navegar en nuestro catálogo en línea y realizar tus pedidos.</p>
                        ";
                        
        $replyToEmailClient = "oficina@rtelsalvador.com";
        $replyToNameClient = "Representaciones Thompson";

        $estado1 = $this->sendMail($mailToClient, $emailRecipientClient ,$emailSubjectClient ,$emailBodyClient ,$replyToEmailClient ,$replyToNameClient);

        //Envio de notificación por correo a oficina, respaldo de aprobación de un aspirante a cliente
        $emailRecipientOff = "oficina@rtelsalvador.com";
        
        $boletinEstado = '';

        if ($aspirante->boletin == 1 ) {
            $boletinEstado = "si";
        } else {
            $boletinEstado = "no";
        }

        $marcasDisp = Marca::all();
        $marcasAsig = "";

        foreach ($marcasDisp as $marca) { 
            
            if ( str_contains($marca->id, $aspirante->marcas) ) {
                $marcasAsig = $marca->nombre.", ".$marcasAsig;
            } 
        } 

        $emailSubjectOff = 'Confirmación de aprobación de aspirante a cliente - RTElSalvador';
        $emailBodyOff = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/rtthompson-logo.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p><b>HAS APROBADO A UN ASPIRANTE A CLIENTE.</b></p>
                        
                        <br/>

                        <p><b>ID Usuario</b>: ".$aspirante->id."</p>
                        <p><b>Nombre</b>: ".$aspirante->name." </p>
                        <p><b>Correo electrónico</b>: ".$aspirante->email."</p>
                        <p><b>Dirección</b>: ".$aspirante->direccion.", ".$aspirante->municipio.", ".$aspirante->departamento."</p>
                        <p><b>Teléfono</b>: ".$aspirante->telefono."</p>
                        <p><b>Celular/Núm. WhatsApp</b>: ".$aspirante->whatsapp."</p>
                        <p><b>WebSite</b>: ".$aspirante->website."</p>

                        <br/>

                        <h5>-Datos Empresa/Negocio</h5>

                        <br/>
                        
                        <p><b>N° de registro (NRC)</b>: ".$aspirante->nrc."</p>
                        <p><b>NIT</b>: ".$aspirante->nit."</p>
                        <p><b>DUI</b>: ".$aspirante->dui."</p>
                        <p><b>Nombre Comercial</b>: ".$aspirante->nombre_empresa."</p>
                        <p><b>Nombre/razón ó denominación social</b>: ".$aspirante->razon_social."</p>
                        <p><b>Giro ó actividad económica</b>: ".$aspirante->giro."</p>

                        <br/>

                        <h5>-Otros datos</h5>

                        <br/>

                        <p><b>Marcas aprobadas</b>: ".$marcasAsig."</p>
                        <p><b>Lista de precios asignada</b>: ".$aspirante->clasificacion."</p>
                        <p><b>Estado</b>: ".$aspirante->estado."</p>
                        <p><b>Estatus</b>: ".$aspirante->estatus."</p>
                        <p><b>Fecha de registro</b>: ".$aspirante->fecha_registro."</p>
                        <p><b>Suscrito a boletín</b>: ".$boletinEstado."</p>

                        
                        <p>Este es un correo autoenviado por el sistema RT, favor no contestar.</p>
                        ";
                        
        $replyToEmailOff = "notificaciones@rtelsalvador.com";
        $replyToNameOff = "RT El Salvador - Centro de Notificaciones";

        $estado2 = $this->sendMail($mailToOffice, $emailRecipientOff ,$emailSubjectOff ,$emailBodyOff ,$replyToEmailOff ,$replyToNameOff);

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


    public function updateMarcas(Request $request, $id)
    {

/*
        $request->validate([
            'marca' => 'required|string',
            'cliente' => 'required|numeric',
        ]);
*/

        $clienteID = $request->cliente; //1 2 o 3...
        //$clienteID = trim(strstr( $request->cliente, "_" ), "_");
        //$clienteUptM = User::find($clienteID);

        $clienteUptM = User::find($id);

        $marcasUDT = "";

        $marcasInput = strval($request->marca); 
        $marcasBD = strval($clienteUptM->marcas);

        //return response()->json('id marca check: '.$marcasInput.' ids marcas en bd: '.$marcasBD);

        //return response()->json(str_contains($marcasBD, $marcasInput)); 
        //$flag = str_contains($marcasBD, $marcasInput);

        if ( strpos($marcasBD, $marcasInput) == true ) {

            $marcasUDT = str_replace($marcasInput, '', $marcasBD);  

            $clienteUptM->marcas = $marcasUDT;
            $clienteUptM->update();

           //return response()->json($clienteUptM->marcas);
           return response()->json('found: '.str_replace($marcasInput, '', $marcasBD));

        } else {

            $clienteUptM->marcas = $marcasBD.$marcasInput;

            $clienteUptM->update();

            //return response()->json($clienteUptM->marcas);
            return response()->json('not found: '.$marcasBD.$marcasInput);
        }

    }


    //actualizar lista de precios a taller
    public function taller($id){

        $aspirante = User::find($id);
        $aspirante->clasificacion = 'taller';
        $aspirante->save();

        return redirect('/dashboard/aspirantes/'.$id)->with('toast_success', 'Se actualizó la lista de precios del aspirante a Taller');
    }


    //actualizar la lista de precios a distribuidor
    public function distribuidor($id){

        $aspirante = User::find($id);
        $aspirante->clasificacion = 'distribuidor';
        $aspirante->save();

        return redirect('/dashboard/aspirantes/'.$id)->with('toast_success', 'Se actualizó la lista de precios del aspirante a Distribuidor');
    }


    //actualizar la lista de precios a precio costo
    public function precioCosto($id){

        $aspirante = User::find($id);
        $aspirante->clasificacion = 'precioCosto';
        $aspirante->save();

        return redirect('/dashboard/aspirantes/'.$id)->with('toast_success', 'Se actualizó la lista de precios del aspirante a Precio Costo');
    }


    //actualizar la lista de precios a precio op
    public function precioOP($id){

        $aspirante = User::find($id);
        $aspirante->clasificacion = 'precioOp';
        $aspirante->save();

        return redirect('/dashboard/aspirantes/'.$id)->with('toast_success', 'Se actualizó la lista de precios del aspirante a Precio OP');
    }


    private function sendMail(PHPMailer $mail, $emailRecipient ,$emailSubject ,$emailBody ,$replyToEmail ,$replyToName ) 
    {

        require base_path("vendor/autoload.php");

        //$mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = env('SMTP_HOST', "");             //  smtp host p3plmcpnl492651.prod.phx3.secureserver.ne
            $mail->SMTPAuth = true;
            $mail->Username = env('SMTP_USERNAME', "");   //  sender username
            $mail->Password = env('SMTP_PASS', "");       // sender password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                  // encryption - ssl/tls
            $mail->Port = env('SMTP_PORT', "");                          // port - 587/465
            $mail->SMTPKeepAlive = true;
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

            /* Se envia el mensaje, si no ha habido problemas la variable $exito tendra el valor true */
            $exito = $mail->Send();
            /* 
            Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho para intentar 
            enviar el mensaje, cada intento se hara 5 segundos despues del anterior, para ello se usa la 
            funcion sleep
            */  
            $intentos=1; 
            
            while ((!$exito) && ($intentos < 5)) {
                sleep(5);
                /*echo $mail->ErrorInfo;*/
                $exito = $mail->Send();
                $intentos=$intentos+1;  
            }

            $mail->getSMTPInstance()->reset();
            $mail->clearAddresses();
            $mail->smtpClose();

            return $exito;
        
        } catch (Exception $e) {
             return redirect()->route('inicio')->with('error','Ha ocurrido algún error al enviar.');
        } 

    }


//fin clase
}


