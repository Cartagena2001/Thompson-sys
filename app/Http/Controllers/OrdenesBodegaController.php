<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\Producto;
use App\Models\User;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

use Config;

class OrdenesBodegaController extends Controller
{

    public function index()
    {
        //$ordenes = Orden::Paginate(1000000000);
        //$ordenes = Orden::where('estado', 'Preparada')->orWhere('estado', 'Pagar')->paginate(1000000000);
        $ordenes = Orden::whereIn('estado', ['Proceso', 'Preparada', 'Pagar', 'Pagada'])->paginate(1000000000);
        $users = User::all();

        return view('ordenes.index-bodega' , compact('ordenes' , 'users'));
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

        return view('ordenes.show-bodega' , compact('orden', 'detalle'));
    }


    public function uploadBod(Request $request, $id){

        //validar los datos
        $request->validate([

            'notas_bodega' => 'string|max:250',
            'bulto' => 'string|max:9',
            'paleta' => 'string|max:9',
            'hoja_salida_href' => 'nullable|image|mimes:png,jpg,jpeg|max:5120|dimensions:min_width=400,min_height=400,max_width=1200,max_height=1200'
        ]);

        $orden = Orden::find($id);
        
        //buscar el detalle de la orden
        $detalle = OrdenDetalle::where('orden_id' , $id)->get();

        //almacenar datos
        //subir hoja de salida
        if ($request->hasFile('hoja_salida_href')) {
            
            if ($request->file('hoja_salida_href')->isValid()){

                $file = $request->file('hoja_salida_href');

                $nombreHojaSal =  $orden->id.'_hoja-sal_'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();

                //$path = $file->storeAs('/public/assets/', $nombreHojaSal);

                $path = $file->storeAs('/private/hojas_sal/', $nombreHojaSal);

                $orden->hoja_salida_href = $nombreHojaSal;  

            } else {

                return view('ordenes.show-bodega' , compact('orden', 'detalle'))->with('toast', 'Ha ocurrido un error al cargar la hoja de salida.');
            }

        }

        $orden->notas_bodega = $request->get('notas_bodega');
        $orden->bulto = $request->get('bulto');
        $orden->paleta = $request->get('paleta');
        
        $orden->update();

        
        /*ahora buscar el producto de cada detalle
        foreach($detalle as $item){
            $item->producto = $item->Producto;
        }
        */

        return view('ordenes.show-bodega' , compact('orden', 'detalle'));
    }


    //crear una funcion para actualizar el estado de la orden a preparada
    public function preparada($id){
        
        $orden = Orden::find($id);
        $ordenDetalle = OrdenDetalle::where('orden_id', $id)->get();
        $orden->estado = 'Preparada';

        $ordenFechaH = \Carbon\Carbon::parse($orden->fecha_registro)->isoFormat('DD/MM/Y, h:mm:ss a');

        $subtotal = 0;
        $iva = 0.13;
        $total = 0;

        foreach ($ordenDetalle as $deta) {

            $subtotal += (($deta->cantidad * $deta->precio)/$deta->cantidad_solicitada)*$deta->cantidad_despachada;
        }

        $orden->total = $subtotal;

        $orden->update();
        $total = $subtotal + ($subtotal * $iva);

        /*
        //Envio de notificación por correo al cliente
        $emailRecipientClient = $orden->user->email;
        $emailSubjectClient = 'Actualización de estado de orden de compra #: '.$orden->id.' - Accumetric El Salvador';
        $emailBodyClient = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='acc-Logo' src='https://rtelsalvador.com/assets/img/accumetric-slv-logo-mod.png' style='width:100%; max-width:250px;'> 
                        </div>

                        <br/>
                        <br/>
                        <p><b>Sr./Sra.</b>: ".$orden->user->name." </p>
                        <br/>
                        <p>SU ORDEN DE COMPRA: <b># ".$orden->id."</b> HA CAMBIADO DE ESTADO: DE <b>EN PROCESO</b> A <span style='font-weight:bold; color:#21d735;'>PREPARADA</span>.</p>
                        <br/>
                        <br/>
                        <p>Cualquier duda o consulta sobre tu orden de compra puedes escribir al correo electrónico <b>oficina@rtelsalvador.com</b> o simplemente respondiendo a este correo.</p>
                        ";
                        
        $replyToEmailClient = "oficina@rtelsalvador.com";
        $replyToNameClient = "Accumetric El Salvador - Oficina";
        */
        //$estado1 = $this->notificarCliente($emailRecipientClient ,$emailSubjectClient ,$emailBodyClient ,$replyToEmailClient ,$replyToNameClient);
        //dd($estado1);


        //Envio de notificación por correo a oficina
        $emailRecipientOff = "oficina@rtelsalvador.com";
        
        $emailSubjectOff = 'Actualización de estado de orden de compra # '.$orden->id.' a En Proceso';
        $emailBodyOff = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='acc-Logo' src='https://rtelsalvador.com/assets/img/accumetric-slv-logo-mod.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p>LA ORDEN DE COMPRA: <b># ".$orden->id."</b> HA CAMBIADO DE ESTADO: DE <b>EN PROCESO</b> A <span style='font-weight:bold; color:#21d735;'>PREPARADA</span>.</p>
                        <br/>
                        <p><b>DATOS</b>:</p>
                        <p><b>Cliente</b>: ".$orden->user->name." <br/>
                           <b>NRC</b>: ".($orden->user->nrc != null ? $orden->user->nrc : '-')." | <b>NIT</b>: ".($orden->user->nit != null ? $orden->user->nit : '-')." | <b>DUI</b>: ".($orden->user->dui != null ? $orden->user->dui : '-')." <br/>
                           <b>Empresa</b>: ".$orden->user->nombre_empresa." <br/>
                           <b>Correo electrónico</b>: ".$orden->user->email." <br/>
                           <b>WhatsApp</b>: ".$orden->user->whatsapp." <br/>
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
                                    <th style='text-align: left;'>Producto</th>
                                    <th style='text-align: center;'>Cantidad (caja)</th>
                                    <th style='text-align: center;'>Cantidad Solicitada (unds)</th>
                                    <th style='text-align: center;'>Cantidad a Despachar (unds)</th>
                                    <th style='text-align: center;'>Precio (caja)</th>
                                    <th style='text-align: center;'>Subtotal Parcial</th>
                                </tr>
                            </thead>
                            <tbody>";
  
            foreach ($ordenDetalle as $detalles) {

                $emailBodyOff.= "<tr style='padding-bottom: 20px;'>
                                    <td style='text-align: left;'>".$detalles->producto->nombre ."</td>
                                    <td style='text-align: center;'>".$detalles->cantidad."</td>
                                    <td style='text-align: center;'>".$detalles->cantidad_solicitada."</td>
                                    <td style='text-align: center;'>".$detalles->cantidad_despachada."</td>
                                    <td style='text-align: center;'>".number_format(($detalles->precio), 2, '.', ',')." $</td>
                                    <td style='text-align: center;'>".number_format( ((($detalles->cantidad * $detalles->precio)/$detalles->cantidad_solicitada)*$detalles->cantidad_despachada), 2, '.', ',')." $</td>
                                 </tr>";
            }

        $emailBodyOff .= "<tr style='padding-top: 20px; border-top: solid 4px #979797;'>
                                <td></td>
                                <td></td> 
                                <td style='text-align: left; font-weight: 600;'>Subtotal:</td> 
                                <td style='text-align: right;'>".number_format($subtotal, 2, '.', ',')." $</td> 
                            </tr>
                            <tr>
                                <td></td>
                                <td></td> 
                                <td style='text-align: left; font-weight: 600;'>IVA (13%):</td> 
                                <td style='text-align: right;'>".number_format(($subtotal * $iva), 2, '.', ',')." $</td> 
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style='text-align: left; font-weight: 600;'>Total:</td> 
                                <td style='text-align: right;'>".number_format($total, 2, '.', ',')." $</td> 
                            </tr>
                        </tbody>
                    </table>

                    <br/>
                    
                    <p>...</p>
                    ";
                        
        $replyToEmailOff = $orden->user->email;
        $replyToNameOff = $orden->user->name;

        $estado2 = $this->notificarOficina($emailRecipientOff ,$emailSubjectOff ,$emailBodyOff ,$replyToEmailOff ,$replyToNameOff);
        //dd($estado2);

        //return redirect('/dashboard/ordenes/oficina')->with('toast_success', 'Se actualizó el estado de la órden a Preparada');
        return redirect()->route('bodega.index')->with('success', 'Se actualizó el estado de la orden a Preparada');
    }



    //crear una funcion para actualizar el estado de la orden a finalizada
    public function finalizada($id){

        $orden = Orden::find($id);
        $ordenDetalle = OrdenDetalle::where('orden_id', $id)->get();
        $orden->estado = 'Finalizada';

        $ordenFechaH = \Carbon\Carbon::parse($orden->fecha_registro)->isoFormat('DD/MM/Y, h:mm:ss a');

        //$orden->fecha_entrega = \Carbon\Carbon::now()->isoFormat('DD/MM/Y, h:mm:ss a');
        $orden->fecha_entrega = \Carbon\Carbon::now();

        $orden->update();

        $subtotal = 0;
        $iva = 0.13;
        $total = 0;

        foreach ($ordenDetalle as $deta) {

            $subtotal += (($deta->cantidad * $deta->precio)/$deta->cantidad_solicitada)*$deta->cantidad_despachada;
        }
        
        $total = $subtotal + ($subtotal * $iva);

        //Envio de notificación por correo al cliente
        $emailRecipientClient = $orden->user->email;
        $emailSubjectClient = 'Actualización de estado de orden de compra # '.$orden->id.' - Accumetric El Salvador';
        $emailBodyClient = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='acc-Logo' src='https://rtelsalvador.com/assets/img/accumetric-slv-logo-mod.png' style='width:100%; max-width:250px;'> 
                        </div>

                        <br/>
                        <br/>
                        <p><b>Sr./Sra.</b>: ".$orden->user->name." </p>
                        <br/>
                        <p>SU ORDEN DE COMPRA: <b># ".$orden->id."</b> HA CAMBIADO DE ESTADO: DE <b>PAGADA</b> A <span style='font-weight:bold; color:#607d8b;'>FINALIZADA (DESPACHADA)</span>.</p>
                        <br/>
                        <br/>
                        <p><b>MUCHAS GRACIAS POR TU COMPRA</b>:</p>
                        <br/>
                        <table>
                            <thead>
                                <tr>
                                    <th style='text-align: left;'>Producto</th>
                                    <th style='text-align: center;'>Cantidad (caja)</th>
                                    <th style='text-align: center;'>Cantidad Solicitada (unds)</th>
                                    <th style='text-align: center;'>Cantidad a Despachar (unds)</th>
                                    <th style='text-align: center;'>Precio (caja)</th>
                                    <th style='text-align: center;'>Subtotal Parcial</th>
                                </tr>
                            </thead>
                            <tbody>";

            foreach ($ordenDetalle as $detalles) {

             $emailBodyClient.= "<tr style='padding-bottom: 20px;'>
                                    <td style='text-align: left;'>".$detalles->producto->nombre ."</td>
                                    <td style='text-align: center;'>".$detalles->cantidad."</td>
                                    <td style='text-align: center;'>".$detalles->cantidad_solicitada."</td>
                                    <td style='text-align: center;'>".$detalles->cantidad_despachada."</td>
                                    <td style='text-align: center;'>".number_format(($detalles->precio), 2, '.', ',')." $</td>
                                    <td style='text-align: center;'>".number_format( ((($detalles->cantidad * $detalles->precio)/$detalles->cantidad_solicitada)*$detalles->cantidad_despachada), 2, '.', ',')." $</td>
                                 </tr>";
            }


        $emailBodyClient .= "<tr style='padding-top: 20px; border-top: solid 4px #979797;'>
                                <td></td>
                                <td></td> 
                                <td style='text-align: left; font-weight: 600;'>Subtotal:</td> 
                                <td style='text-align: right;'>".number_format($subtotal, 2, '.', ',')." $</td> 
                            </tr>
                            <tr>
                                <td></td>
                                <td></td> 
                                <td style='text-align: left; font-weight: 600;'>IVA (13%):</td> 
                                <td style='text-align: right;'>".number_format(($subtotal * $iva), 2, '.', ',')." $</td> 
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style='text-align: left; font-weight: 600;'>Total:</td> 
                                <td style='text-align: right;'>".number_format($total, 2, '.', ',')." $</td> 
                            </tr>
                        </tbody>
                    </table>

                    <br/>

                    <p>Cualquier duda o consulta sobre tu orden de compra puedes escribir al correo electrónico <b>oficina@rtelsalvador.com</b> o simplemente respondiendo a este correo.</p>

                    <br/>
                    
                    <p>...</p>
                    ";
                        
        $replyToEmailClient = "oficina@rtelsalvador.com";
        $replyToNameClient = "Accumetric El Salvador - Oficina";

        $estado1 = $this->notificarCliente($emailRecipientClient ,$emailSubjectClient ,$emailBodyClient ,$replyToEmailClient ,$replyToNameClient);
        //dd($estado1);


        //Envio de notificación por correo a oficina
        $emailRecipientOff = "oficina@rtelsalvador.com";
        
        $emailSubjectOff = 'Actualización de estado de orden de compra # '.$orden->id.' a En Proceso';
        $emailBodyOff = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='acc-Logo' src='https://rtelsalvador.com/assets/img/accumetric-slv-logo-mod.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p>LA ORDEN DE COMPRA: <b># ".$orden->id."</b> HA CAMBIADO DE ESTADO: DE <b>PAGADA</b> A <span style='font-weight:bold; color:#607d8b;'>FINALIZADA (DESPACHADA)</span>.</p>
                        <br/>
                        <p><b>DATOS</b>:</p>
                        <p><b>Cliente</b>: ".$orden->user->name." <br/>
                           <b>NRC</b>: ".($orden->user->nrc != null ? $orden->user->nrc : '-')." | <b>NIT</b>: ".($orden->user->nit != null ? $orden->user->nit : '-')." | <b>DUI</b>: ".($orden->user->dui != null ? $orden->user->dui : '-')." <br/>
                           <b>Empresa</b>: ".$orden->user->nombre_empresa." <br/>
                           <b>Correo electrónico</b>: ".$orden->user->email." <br/>
                           <b>WhatsApp</b>: ".$orden->user->whatsapp." <br/>
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
                                    <th style='text-align: left;'>Producto</th>
                                    <th style='text-align: center;'>Cantidad (caja)</th>
                                    <th style='text-align: center;'>Cantidad Solicitada (unds)</th>
                                    <th style='text-align: center;'>Cantidad a Despachar (unds)</th>
                                    <th style='text-align: center;'>Precio (caja)</th>
                                    <th style='text-align: center;'>Subtotal Parcial</th>h>
                                </tr>
                            </thead>
                            <tbody>";
  
            foreach ($ordenDetalle as $detalles) {

                $emailBodyOff.= "<tr style='padding-bottom: 20px;'>
                                    <td style='text-align: left;'>".$detalles->producto->nombre ."</td>
                                    <td style='text-align: center;'>".$detalles->cantidad."</td>
                                    <td style='text-align: center;'>".$detalles->cantidad_solicitada."</td>
                                    <td style='text-align: center;'>".$detalles->cantidad_despachada."</td>
                                    <td style='text-align: center;'>".number_format(($detalles->precio), 2, '.', ',')." $</td>
                                    <td style='text-align: center;'>".number_format( ((($detalles->cantidad * $detalles->precio)/$detalles->cantidad_solicitada)*$detalles->cantidad_despachada), 2, '.', ',')." $</td>
                                 </tr>";
            }

        $emailBodyOff .= "<tr style='padding-top: 20px; border-top: solid 4px #979797;'>
                                <td></td>
                                <td></td> 
                                <td style='text-align: left; font-weight: 600;'>Subtotal:</td> 
                                <td style='text-align: right;'>".number_format($subtotal, 2, '.', ',')." $</td> 
                            </tr>
                            <tr>
                                <td></td>
                                <td></td> 
                                <td style='text-align: left; font-weight: 600;'>IVA (13%):</td> 
                                <td style='text-align: right;'>".number_format(($subtotal * $iva), 2, '.', ',')." $</td> 
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style='text-align: left; font-weight: 600;'>Total:</td> 
                                <td style='text-align: right;'>".number_format($total, 2, '.', ',')." $</td> 
                            </tr>
                        </tbody>
                    </table>

                    <br/>
                    
                    <p>...</p>
                    ";
                        
        $replyToEmailOff = $orden->user->email;
        $replyToNameOff = $orden->user->name;

        $estado2 = $this->notificarOficina($emailRecipientOff ,$emailSubjectOff ,$emailBodyOff ,$replyToEmailOff ,$replyToNameOff);
        //dd($estado2);

        //return redirect('/dashboard/ordenes/oficina')->with('toast_success', 'Se actualizó el estado de la órden a Finalizada');
        return redirect()->route('bodega.index')->with('success', 'Se actualizó el estado de la orden a Finalizada');
    }



public function notificarCliente($emailRecipient ,$emailSubject ,$emailBody ,$replyToEmail ,$replyToName) 
    {

        require base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            //$mail->SMTPDebug = 1; // 1 | 2 | 3 | 4
            $mail->isSMTP();

            $mail->Host = config('phpmailerconf.host'); //env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = config('phpmailerconf.username'); //env('MAIL_USERNAME');
            $mail->Password = config('phpmailerconf.password'); //env('MAIL_PASSWORD');
            $mail->SMTPSecure = config('phpmailerconf.encryption'); //env('MAIL_ENCRYPTION');
            $mail->Port = config('phpmailerconf.port'); //env('MAIL_PORT');                          // port - 587/465
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

            $mail->Subject = $emailSubject; //.' '.rand();
            $mail->Body    = $emailBody;

            // $mail->AltBody = plain text version of email body;

            /* Se envia el mensaje, si no ha habido problemas la variable $exito tendrá el valor true */
            $exito = $mail->Send();
            /* 
            Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho para intentar 
            enviar el mensaje, cada intento se hara 5 segundos despues del anterior, para ello se usa la 
            funcion sleep
            */  
            $intentos=1; 
            
            if ($exito != true) {

                while (($exito != true) && ($intentos < 5)) {
                    sleep(5);
                    /*echo $mail->ErrorInfo;*/
                    $exito = $mail->Send();
                    $intentos=$intentos+1;  
                }
            }

            $mail->getSMTPInstance()->reset();
            $mail->clearAllRecipients();
            $mail->clearAddresses();
            $mail->clearReplyTos();
            $mail->smtpClose();

            return $exito;
        
        } catch (Exception $e) {
             return $mail->ErrorInfo;
        } 

    }


    public function notificarOficina($emailRecipient ,$emailSubject ,$emailBody ,$replyToEmail ,$replyToName ) 
    {

        require base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            //$mail->SMTPDebug = 1; // 1 | 2 | 3 | 4
            $mail->isSMTP();
            
            $mail->Host = config('phpmailerconf.host'); //env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = config('phpmailerconf.username'); //env('MAIL_USERNAME');
            $mail->Password = config('phpmailerconf.password'); //env('MAIL_PASSWORD');
            $mail->SMTPSecure = config('phpmailerconf.encryption'); //env('MAIL_ENCRYPTION');
            $mail->Port = config('phpmailerconf.port'); //env('MAIL_PORT');                          // port - 587/465
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
                    $mail2->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }
            */

             $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $emailSubject; //.' '.rand();
            $mail->Body    = $emailBody;

            // $mail2->AltBody = plain text version of email body;

            /* Se envia el mensaje, si no ha habido problemas la variable $exito tendrá el valor true */
            $exito = $mail->Send();
            /* 
            Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho para intentar 
            enviar el mensaje, cada intento se hara 5 segundos despues del anterior, para ello se usa la 
            funcion sleep
            */  
            $intentos=1; 
            
            if ($exito != true) {

                while (($exito != true) && ($intentos < 5)) {
                    sleep(5);
                    /*echo $mail->ErrorInfo;*/
                    $exito = $mail->Send();
                    $intentos=$intentos+1;  
                }
            }

            $mail->getSMTPInstance()->reset();
            $mail->clearAllRecipients();
            $mail->clearAddresses();
            $mail->clearReplyTos();
            $mail->smtpClose();

            return $exito;
        
        } catch (Exception $e) {
              return $mail->ErrorInfo;
        } 

    }


//fin clase
}
