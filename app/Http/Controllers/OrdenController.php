<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class OrdenController extends Controller
{


    public function index()
    {
        return view('orden.index');
    }


    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        $orden = new Orden();

        if ( $request->get('cliente_id_compra') != null ) { 

            $orden->user_id = $request->get('cliente_id_compra');  //se asigna la orden al usuario seleccionado por el admin
        } else {
            $orden->user_id = Auth::user()->id; //se asigna la orden al usuario en sesión
        }

        $orden->fecha_registro = \Carbon\Carbon::now()->toDateTimeString();
        $orden->estado = 'Pendiente'; //1er estado por defecto
        $orden->visto = 'nuevo'; //1er estado, antes de ser vista en el menú
        $orden->corr = '-'; //#factura
        $orden->notas = '-'; //notas
        $orden->notas_bodega = '-'; //notas bodega
        $orden->bulto = '-'; //total bultos
        $orden->paleta = '-'; //total paletas
        $orden->fecha_envio = \Carbon\Carbon::now()->addDays(1)->toDateTimeString();
        $orden->fecha_entrega = \Carbon\Carbon::now()->addDays(4)->toDateTimeString();
        $orden->total = 0;

        $orden->save();

        //guardar los productos de la orden detalle
        foreach ($cart as $producto) {
            
            $ordenDetalle = new OrdenDetalle();

            $ordenDetalle->orden_id = $orden->id;
            $ordenDetalle->producto_id = $producto['producto_id'];
            $ordenDetalle->cantidad = $producto['cantidad']; //cantidad de cajas de X producto ordenada
            $ordenDetalle->precio = $producto['precio_f'] * $producto['unidad_caja']; //guardar precio por caja
            $ordenDetalle->descuento = 0; //registro de algùn descuento aplicado

            $ordenDetalle->save();

            //actualiza el stock del producto restando la cantidad comprada
            $productostock = Producto::find($producto['producto_id']);
            $productostock->existencia = $productostock->existencia - $ordenDetalle->cantidad;

            $productostock->save();
        }

        //actualizar el total de la orden
        foreach ($cart as $producto) {
            $orden->total = $orden->total + ($producto['precio_f'] * $producto['cantidad'] * $producto['unidad_caja']);
        }
        
        $orden->save();

        //Para envio de correo 
        $ordenAux = Orden::find($orden->id);
        $detalleAUx = ordenDetalle::where('orden_id', $orden->id)->get();

        $ordenFechaH = \Carbon\Carbon::parse($ordenAux->created_at)->format('d/m/Y, h:m:s a');

        $subtotal = 0;
        $iva = 0.13;
        $total = 0;

        foreach ($detalleAUx as $detalles) {
            $subtotal += $detalles->cantidad * $detalles->precio;
        }

        $total = $subtotal + ($subtotal * $iva);



        $mailToClient = new PHPMailer(true);     // Passing `true` enables exceptions

        $mailToOffice = new PHPMailer(true);     // Passing `true` enables exceptions


        //Envio de notificación por correo a Cliente
        $emailRecipientClient = $ordenAux->user->email;
        $emailSubjectClient = 'Tu órden de compra # '.$orden->id;

        $emailBodyClient = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/rtthompson-logo.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p><b>RESUMEN ÓRDEN DE COMPRA # ".$orden->id."</b></p>
                        
                        <br/>

                        <p><b>DATOS</b>:</p>
                        <p><b>Cliente</b>: ".$ordenAux->user->name." <br/>
                           <b>Empresa</b>: ".$ordenAux->user->nombre_empresa." <br/>
                           <b>Correo electrónico</b>: ".$ordenAux->user->email." <br/>
                           <b>WhatsApp</b>: ".$ordenAux->user->numero_whatsapp." <br/>
                           <b>Teléfono</b>: ".$ordenAux->user->telefono." <br/>
                           <b>Dirección</b>: ".$ordenAux->user->direccion.", ".$ordenAux->user->municipio.", ".$ordenAux->user->departamento."<br/>  
                           <b>Fecha/Hora</b>: ".$ordenFechaH." <br/>
                           <b>Estado: ".$ordenAux->estado."
                        </p>

                        <br/>

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

        foreach ($detalleAUx as $detalles) { 
            $emailBodyClient.= "<tr class='pb-5'>
                                    <td class='text-start'>".$detalles->producto->nombre ."</td>
                                    <td class='text-center'>".$detalles->cantidad."</td>
                                    <td class='text-center'>".number_format(($detalles->precio), 2, '.', ',')." $</td>
                                    <td class='text-center'>".number_format(($detalles->cantidad * $detalles->precio), 2, '.', ',')." $</td>
                                </tr>";
        }

            $emailBodyClient .= "<tr class='pt-5' style='border-top: solid 4px #979797;'>
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
                        
                        <p>Pronto nos pondremos en contacto.</p>
                        ";

        $replyToEmailClient = "oficina@rtelsalvador.com";
        $replyToNameClient = "Representaciones Thompson - Oficina";

        $estado2 = $this->sendMail($mailToClient, $emailRecipientClient, $emailSubjectClient, $emailBodyClient, $replyToEmailClient, $replyToNameClient);

        
        //Envio de notificación por correo a Oficina
        $emailRecipientOff = "oficina@rtelsalvador.com";
        $emailSubjectOff = 'Nueva órden de compra # '.$orden->id;

        $emailBodyOff = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/rtthompson-logo.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p><b>NUEVA ÓRDEN DE COMPRA # ".$orden->id."</b></p>
                        
                        <br/>

                        <p><b>DATOS</b>:</p>
                        <p><b>Cliente</b>: ".$ordenAux->user->name." <br/>
                           <b>Empresa</b>: ".$ordenAux->user->nombre_empresa." <br/>
                           <b>Correo electrónico</b>: ".$ordenAux->user->email." <br/>
                           <b>WhatsApp</b>: ".$ordenAux->user->numero_whatsapp." <br/>
                           <b>Teléfono</b>: ".$ordenAux->user->telefono." <br/>
                           <b>Dirección</b>: ".$ordenAux->user->direccion.", ".$ordenAux->user->municipio.", ".$ordenAux->user->departamento."<br/>  
                           <b>Fecha/Hora</b>: ".$ordenFechaH." <br/>
                           <b>Estado: ".$ordenAux->estado."
                        </p>

                        <br/>

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

        foreach ($detalleAUx as $detalles) { 
                $emailBodyOff .= "<tr class='pb-5'>
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
                        
                        <p>Pronto nos pondremos en contacto.</p>
                        ";

                   
        $replyToEmailOff = $ordenAux->user->email;
        $replyToNameOff = $ordenAux->user->name;

        $estado1 = $this->sendMail($mailToOffice, $emailRecipientOff, $emailSubjectOff, $emailBodyOff, $replyToEmailOff, $replyToNameOff);


        if( !$estado1 && !$estado2 ) {

            session()->forget('cart');

            return view('orden.gracias');
        } 
        else {
            
            session()->forget('cart');

            return view('orden.gracias');
        }

    }


    private function sendMail(PHPMailer $mail, $emailRecipient ,$emailSubject ,$emailBody ,$replyToEmail ,$replyToName ) 
    {

        require base_path("vendor/autoload.php");

        //$mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 3;
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


}
