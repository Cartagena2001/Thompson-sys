<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\User;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class OrdenesController extends Controller
{


    public function index()
    {
        $ordenes = Orden::Paginate(1000000000);
        $users = User::all();

        return view('ordenes.index-oficina' , compact('ordenes' , 'users'));
    }

    
    public function show($id){

        $orden = Orden::find($id);

        //buscar el detalle de la orden
        $detalle = OrdenDetalle::where('orden_id' , $id)->get();

        $orden->visto = 'visto';
        $orden->update();
        
        //ahora buscar el producto de cada detalle
        foreach($detalle as $item){
            $item->producto = $item->Producto;
        }

        return view('ordenes.show-oficina' , compact('orden', 'detalle'));
    }


    public function upload(Request $request, $id){

        //validar los datos
        $request->validate([

            'corr' => 'string|min:1|max:24',
            'notas' => 'string|max:250',
            'ubicacion' => 'string|max:19'

        ]);

        $orden = Orden::find($id);

        //almacenar datos
        if ($request->hasFile('factura_href')) {
            $file = $request->file('factura_href');
            $file->move(public_path() . '/assets/img/cifs/', $file->getClientOriginalName());
            $orden->factura_href = '/assets/img/cifs/' . $file->getClientOriginalName();
        }

        $orden->corr = $request->get('corr');
        $orden->notas = $request->get('notas');
        $orden->ubicacion = $request->get('ubicacion');
        
        $orden->update();

        //buscar el detalle de la orden
        $detalle = OrdenDetalle::where('orden_id' , $id)->get();

        //$orden->save();
        
        //ahora buscar el producto de cada detalle
        foreach($detalle as $item){
            $item->producto = $item->Producto;
        }

        return view('ordenes.show-oficina' , compact('orden', 'detalle'))->with('toast', 'Información de órden actualizada.');
    }


    public function uploadBod(Request $request, $id){

        //validar los datos
        $request->validate([

            'notas_bodega' => 'string|max:250',
            'bulto' => 'string|max:9',
            'paleta' => 'string|max:9',

        ]);

        $orden = Orden::find($id);

        //almacenar datos
        if ($request->hasFile('hoja_salida_href')) {
            $file = $request->file('hoja_salida_href');
            $file->move(public_path() . '/assets/img/hojas_sal/', $file->getClientOriginalName());
            $orden->hoja_salida_href = '/assets/img/hojas_sal/' . $file->getClientOriginalName();
        }

        $orden->notas_bodega = $request->get('notas_bodega');
        $orden->bulto = $request->get('bulto');
        $orden->paleta = $request->get('paleta');
        
        $orden->update();

        //buscar el detalle de la orden
        $detalle = OrdenDetalle::where('orden_id' , $id)->get();

        //$orden->save();
        
        //ahora buscar el producto de cada detalle
        foreach($detalle as $item){
            $item->producto = $item->Producto;
        }

        return view('ordenes.show-bodega' , compact('orden', 'detalle'));
    }


    //crear una funcion para actualizar el estado de la orden a en proceso (solo oficina)
    public function enProceso($id){

        $orden = Orden::find($id);
        $ordenDetalle = OrdenDetalle::where('orden_id', $id);
        $orden->estado = 'Proceso';
        $orden->save();

        //$mailToClient = new PHPMailer(true);     // Passing `true` enables exceptions

        //$mailToOffice = new PHPMailer(true);     // Passing `true` enables exceptions


        //Envio de notificación por correo al cliente
        $emailRecipientClient = $orden->user->email;
        $emailSubjectClient = 'Actualización de Estado de Orden:'.$orden->id.' - RTElSalvador';
        $emailBodyClient = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/accumetric-slv-logo-mod.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>
                        <p><b>Sr./Sra.</b>: ".$orden->user->name." </p>
                        <br/>
                        <p>TU ORDEN: <b>".$orden->id."</b> HA CAMBIADO DE ESTADO: DE PENDIENTE A <b>EN PROCESO</b>.</p>
                        <br/>
                        <br/>
                        <p>Cualquier duda o consulta sobre tu orden de compra puedes escribir al correo electrónico <b>oficina@rtelsalvador.com</b> o simplemente respondiendo a este correo.</p>
                        ";
                        
        $replyToEmailClient = "oficina@rtelsalvador.com";
        $replyToNameClient = "Accumetric El Salvador - Oficina";

        //$estado1 = $this->sendMail($mailToClient, $emailRecipientClient ,$emailSubjectClient ,$emailBodyClient ,$replyToEmailClient ,$replyToNameClient);

        $estado1 = $this->notificarCliente($emailRecipientClient ,$emailSubjectClient ,$emailBodyClient ,$replyToEmailClient ,$replyToNameClient);


        //Envio de notificación por correo a oficina
        $emailRecipientOff = "oficina@rtelsalvador.com";
        
        $emailSubjectOff = 'Actualización de Estado de Orden:'.$orden->id.' completada';
        $emailBodyOff = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/accumetric-slv-logo-mod.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p>LA ORDEN: <b>".$orden->id."</b> HA CAMBIADO DE ESTADO: DE PENDIENTE A <b>EN PROCESO</b>.</p>
                        <br/>
                        <p><b>DATOS</b>:</p>
                        <p><b>Cliente</b>: ".$orden->user->name." <br/>
                           <b>Empresa</b>: ".$orden->user->nombre_empresa." <br/>
                           <b>Correo electrónico</b>: ".$orden->user->email." <br/>
                           <b>WhatsApp</b>: ".$orden->user->numero_whatsapp." <br/>
                           <b>Teléfono</b>: ".$orden->user->telefono." <br/>
                           <b>Dirección</b>: ".$orden->user->direccion.", ".$orden->user->municipio.", ".$orden->user->departamento."<br/>  
                           <b>Fecha/Hora</b>: ".$ordenFechaH." <br/>
                           <b>Estado: </b>".$orden->estado."
                        </p>
                        
                        <p><b>RESUMEN PEDIDO</b>:</p>
                        <br/>
                        <table>
                            <thead>
                                <tr>
                                    <th class='text-start'>Producto</th>
                                    <th class='text-center'>Cantidad (caja)</th>
                                    <th class='text-center'>Precio (caja)</th>
                                    <th class='text-cente'>Subtotal Parcial</th>
                                </tr>
                            </thead>
                            <tbody>";

        foreach ($ordenDetalle as $detalles) { 
            $emailBodyOff.= "<tr class='pb-5'>
                                    <td class='text-start'>".$detalles->producto->nombre ."</td>
                                    <td class='text-center'>".$detalles->cantidad."</td>
                                    <td class='text-center'>".number_format(($detalles->precio), 2, '.', ',')." $</td>
                                    <td class='text-center'>".number_format(($detalles->cantidad * $detalles->precio), 2, '.', ',')." $</td>
                                </tr>";
        }

            $emailBodyOff .= "<tr class='pt-5' style='border-top: solid 4px #979797;'>
                                    <td></td>
                                    <td></td> 
                                    <td class='text-start' style='font-weight: 600;'>Subtotal:</td> 
                                    <td class='text-end'>".number_format($subtotal, 2, '.', ',')." $</td> 
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td> 
                                    <td class='text-start' style='font-weight: 600;'>IVA (13%):</td> 
                                    <td class='text-end'>".number_format(($subtotal * $iva), 2, '.', ',')." $</td> 
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class='text-start' style='font-weight: 600;'>Total:</td> 
                                    <td class='text-end'>".number_format($total, 2, '.', ',')." $</td> 
                                </tr>
                            </tbody>
                        </table>

                        <br/>
                        
                        <p>...</p>
                        ";
                        
        $replyToEmailOff = $data['email'];
        $replyToNameOff = $data['name'];

        //$estado2 = $this->sendMail($mailToOffice, $emailRecipientOff ,$emailSubjectOff ,$emailBodyOff ,$replyToEmailOff ,$replyToNameOff);

        $estado2 = $this->notificarOficina($emailRecipientOff ,$emailSubjectOff ,$emailBodyOff ,$replyToEmailOff ,$replyToNameOff);


        return redirect('/dashboard/ordenes/oficina')->with('toast_success', 'Se actualizó el estado de la órden a En Proceso');
    }


    //crear una funcion para actualizar el estado de la orden a preparada
    public function preparada($id){
        
        $orden = Orden::find($id);
        $orden->estado = 'Preparada';
        $orden->save();

        return redirect('/dashboard/ordenes/oficina')->with('toast_success', 'Se actualizó el estado de la órden a Preparada');
    }


    //crear una funcion para actualizar el estado de la orden a en espera
    public function enEspera($id){
        
        $orden = Orden::find($id);
        $orden->estado = 'Espera';
        $orden->save();

        return redirect('/dashboard/ordenes/oficina')->with('toast_success', 'Se actualizó el estado de la órden a En Espera');
    }


    //crear una funcion para actualizar el estado de la orden a pagada
    public function pagada($id){
        $orden = Orden::find($id);
        $orden->estado = 'Pagada';
        $orden->save();
        return redirect('/dashboard/ordenes/oficina')->with('toast_success', 'Se actualizó el estado de la órden a Pagada');
    }


    //crear una funcion para actualizar el estado de la orden a finalizada
    public function finalizada($id){
        $orden = Orden::find($id);
        $orden->estado = 'Finalizada';
        $orden->save();
        return redirect('/dashboard/ordenes/oficina')->with('toast_success', 'Se actualizó el estado de la órden a Finalizada');
    }


    //crear una funcion para actualizar el estado de la orden a cancelada
    public function cancelada($id){
        $orden = Orden::find($id);
        $orden->estado = 'Cancelada';
        $orden->save();
        return redirect('/dashboard/ordenes/oficina')->with('toast_success', 'Se actualizó el estado de la orden a Cancelada');
    }


    private function notificarCliente($emailRecipient ,$emailSubject ,$emailBody ,$replyToEmail ,$replyToName ) 
    {

        require base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

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

            $mail->setFrom('notificaciones@rtelsalvador.com', 'Accumetric El Salvador');
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
                sleep(15);
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


    private function notificarOficina($emailRecipient ,$emailSubject ,$emailBody ,$replyToEmail ,$replyToName ) 
    {

        require base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

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

            $mail->setFrom('notificaciones@rtelsalvador.com', 'Accumetric El Salvador');
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
                sleep(15);
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
