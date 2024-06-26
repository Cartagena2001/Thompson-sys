<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\CMS;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

use Config;

class PerfilController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //capturar la informacion del usuario logeado
        $user = auth()->User();
        $cmsVars = CMS::get()->toArray();

        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento

        return view('perfil.configuracion.index', compact('user', 'cat_mod', 'mant_mod'));
    }

    // funcion para actualizar la informacion del usuario
    public function update(Request $request, User $user)
    {
        //capturar la informacion del usuario logeado
        $usuarioLogIn = auth()->User();

        $user = User::find($usuarioLogIn->id);
        
        if ( $user->rol_id == 2 || $user->rol_id == 3 ) {

            //validar los datos si es cliente o bodega
            $request->validate([
                //'name' => 'required|max:100',
                //'dui' => 'required|unique:users,dui,'.$user->id.'|min:10|max:10',
                'whatsapp' => 'required|min:8|max:9',
                //'nrc' => 'required|unique:users,nrc,'.$user->id.'|min:8|max:10',
                //'nit' => 'required|unique:users,nit,'.$user->id.'|min:17|max:17',
                //'razon_social' => 'required|max:34',
                //'direccion' => 'required|max:75',
                //'municipio' => 'required|max:25',
                //'departamento' => 'required|max:15',
                //'giro' => 'required|max:180',
                //'nombre_empresa' => 'required|max:34',
                'website' => 'required|max:34',
                'telefono' => 'required|string|min:8|max:9'
            ]);

        } elseif ( $user->rol_id == 0 || $user->rol_id == 1 ) {

            //validar los datos si es superAdmin o Admin
            $request->validate([
                'name' => 'required|max:100',
                'dui' => 'required|unique:users,dui,'.$user->id.'|min:9|max:10',
                //'email' => 'required|email|unique:users,email,'.$user->email.'|max:100',
                //'email' => 'required|email|max:100|unique:users',
                'whatsapp' => 'required|min:8|max:9',
                'nrc' => 'required|unique:users,nrc,'.$user->id.'|min:8|max:10',
                'nit' => 'required|unique:users,nit,'.$user->id.'|min:17|max:17',
                'razon_social' => 'required|max:34',
                'direccion' => 'required|max:75',
                'municipio' => 'required|max:25',
                'departamento' => 'required|max:15',
                'giro' => 'required|max:180',
                'nombre_empresa' => 'required|max:34',
                'website' => 'required|max:34',
                'telefono' => 'required|string|min:8|max:9'
            ]);

            $user->name = $request->get('name');
            //$user->email = $request->get('email');
            $user->dui = $request->get('dui');
            $user->nrc = $request->get('nrc');
            $user->nit = $request->get('nit');
            $user->razon_social = $request->get('razon_social');
            $user->direccion = $request->get('direccion');
            $user->municipio = $request->get('municipio');
            $user->departamento = $request->get('departamento');
            $user->giro = $request->get('giro');
            $user->nombre_empresa = $request->get('nombre_empresa');

        }


        //almacenar datos
        if ($request->hasFile('imagen_perfil_src')) {
            $file = $request->file('imagen_perfil_src');
            $file->move(public_path() . '/assets/img/perfil-user/', $file->getClientOriginalName());
            $user->imagen_perfil_src = '/assets/img/perfil-user/' . $file->getClientOriginalName();
        }

        //$user->email = $request->get('email');
        $user->whatsapp = $request->get('whatsapp');
        $user->website = $request->get('website');
        $user->telefono = $request->get('telefono');

        $user->update();

        //redireccionar
        return redirect()->route('perfil.index')->with('toast_success', 'Información actualizada correctamente');
    }


    // funcion para actualizar la contraseña del usuario
    public function passwordUpdate(Request $request)
    {

        //validar los datos si es cliente o bodega
        $this->validate($request, [
            'password' => 'required|confirmed|min:6'
        ]);

        //capturar la informacion del usuario logeado
        $usuarioLogIn = auth()->User();
        $user = User::find($usuarioLogIn->id);
        
        $user->password = bcrypt($request->get('password'));
        $user->save();

        //$user->password = bcrypt($request->get('password'));
        //$user->update();

        //redireccionar
        return redirect()->route('perfil.index')->with('toast_success', 'Información actualizada correctamente');
    }


    public function indexInfoSent()
    {
        //capturar la informacion del usuario logeado
        $user = auth()->User();

        if ( $user->estatus == 'aspirante' || $user->estatus == 'rechazado' ) {

            return view('aspirantes.form-inscripcion', compact('user'));
        } else {
            //return view('home', compact('user'));
            return redirect()->route('home')->with('toast_success', 'BIENVENIDO');
        }
  
    }


    // método para cargar la información del aspirante a cliente
    public function loadInfo(Request $request)
    {
        //capturar la información del usuario logeado
        $user = auth()->User();

        if ( $request->get('negTipo') == 'persona') {
            
            //persona natural no inscrita en CNR
            //validar los datos
            $request->validate([
                'dui' => 'required|unique:users,dui,'.$user->id.'|min:9|max:10',
                'whatsapp' => 'required|min:8|max:9',
                'direccion' => 'required|string|max:75',
                'municipio' => 'required|string|max:25',
                'departamento' => 'required|string|max:15',
                'website' => 'string|max:34',
                'telefono' => 'string|min:8|max:9',
                'g-recaptcha-response' => 'recaptcha'    
            ]);

            $user->nrc = null;
            $user->nit = null;
            $user->razon_social = null;
            $user->giro = null;
            $user->nombre_empresa = null;

        } else {
            //negocio/empresa inscrita en CNR
            //validar los datos
            $request->validate([
                'dui' => 'required|unique:users,dui,'.$user->id.'|min:9|max:10',
                'whatsapp' => 'required|min:8|max:9',
                'nrc' => 'required|unique:users,nrc,'.$user->id.'|min:8|max:10',
                'nit' => 'required|unique:users,nit,'.$user->id.'|min:17|max:17',
                'razon_social' => 'required|string|max:34',
                'direccion' => 'required|string|max:75',
                'municipio' => 'required|string|max:25',
                'departamento' => 'required|string|max:15',
                'giro' => 'required|string|max:180',
                'nombre_empresa' => 'required|string|max:34',
                'website' => 'string|max:34',
                'telefono' => 'string|min:8|max:9',
                'g-recaptcha-response' => 'recaptcha'     
            ]);

            $user->nrc = $request->get('nrc');
            $user->nit = $request->get('nit');
            $user->razon_social = $request->get('razon_social');
            $user->giro = $request->get('giro');
            $user->nombre_empresa = $request->get('nombre_empresa');
        }



        //almacenar datos
        if ($request->hasFile('imagen_perfil_src')) {
            
            if ($request->file('imagen_perfil_src')->isValid()){
                
                $file = $request->file('imagen_perfil_src');

                $imgPerfil = $request->get('dui').'_img-perfil-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/private/perfil-user/', $imgPerfil);

                $user->imagen_perfil_src = $imgPerfil;  

            } else {

                return redirect()->route('info.enviada')->with('toast_success', 'Ha ocurrido un error al cargar la imagen de perfil');
            }

        }

        $user->form_status = 'sent'; //bandera para controlar el estado del llenado del formulario

        //$user->name = $request->get('name');
        //$user->email = $request->get('email');
        $user->usr_tipo = $request->get('negTipo');
        $user->dui = $request->get('dui');
        $user->whatsapp = $request->get('whatsapp');
        $user->direccion = $request->get('direccion');
        $user->municipio = $request->get('municipio');
        $user->departamento = $request->get('departamento');
        $user->website = $request->get('website');
        $user->telefono = $request->get('telefono');
        
        $user->update();

        $mailToClient = new PHPMailer(true);     // Passing `true` enables exceptions
        
        $mailToOffice = new PHPMailer(true);     // Passing `true` enables exceptions


        //Envio de notificación por correo al cliente
        $emailRecipientClient = $request->get('email');
        $emailSubjectClient = 'Formulario de Registro de Usuario - Tienda Accumetric El Salvador';
        $emailBodyClient = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/accumetric-slv-logo-mod.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p><b>¡TUS DATOS HAN SIDO ENVIADOS CON ÉXITO!</b></p>
                        
                        <br/>

                        <p><b>RESUMEN</b>:</p>
                        <p><b>Nombre</b>: ".$request->get('name')." <br/>
                           <b>Correo electrónico</b>: ".$request->get('email')." <br/>
                           <b>DUI</b>: ".$request->get('dui'). ", <b>NRC:</b> ".$request->get('nrc'). ", <b>NIT:</b> ".$request->get('nit')." <br/>
                           <b>Nombre/Razón o denominación social</b>: ".$request->get('razon_social')." <br/>
                           <b>Dirección</b>: ".$request->get('direccion').", ".$request->get('municipio').", ".$request->get('departamento')." <br/>
                           <b>Giro ó actividad económica</b>: ".$request->get('giro')." <br/>
                           <b>Nombre Comercial</b>: ".$request->get('nombre_empresa')." <br/>
                           <b>WebSite</b>: ".$request->get('website')."
                           <b>Teléfono</b>: ".$request->get('telefono')."
                        </p>

                        <br/>
                        
                        <p>Pronto nos pondremos en contacto contigo.</p>
                        ";
                        
        $replyToEmailClient = "oficina@rtelsalvador.com";
        $replyToNameClient = "Accumetric El Salvador - Oficina";

        $estado1 = $this->sendMail($mailToClient, $emailRecipientClient ,$emailSubjectClient ,$emailBodyClient ,$replyToEmailClient ,$replyToNameClient);

        //Envio de notificación por correo a oficina
        $emailRecipientOffice = "oficina@rtelsalvador.com";
        $emailSubjectOffice = 'Nuevo Aspirante - Formulario de Registro - Accumetric El Salvador';
        $emailBodyOffice = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/accumetric-slv-logo-mod.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p><b>Un aspirante ha completado el formulario de registro, estos son sus datos:</b></p>
                        
                        <br/>

                        <p><b>RESUMEN</b>:</p>
                        <p><b>Nombre</b>: ".$request->get('name')." <br/>
                           <b>Correo electrónico</b>: ".$request->get('email')." <br/>
                           <b>DUI</b>: ".$request->get('dui'). ", <b>NRC:</b> ".$request->get('nrc'). ", <b>NIT:</b> ".$request->get('nit')." <br/>
                           <b>Nombre/Razón o denominación social</b>: ".$request->get('razon_social')." <br/>
                           <b>Dirección</b>: ".$request->get('direccion').", ".$request->get('municipio').", ".$request->get('departamento')." <br/>
                           <b>Giro ó actividad económica</b>: ".$request->get('giro')." <br/>
                           <b>Nombre Comercial</b>: ".$request->get('nombre_empresa')." <br/>
                           <b>WebSite</b>: ".$request->get('website')."
                           <b>Teléfono</b>: ".$request->get('telefono')."
                        </p>

                        <br/>
                        
                        <p>Revisa el sistema RT para tomar acciones.</p>
                        ";
                        
        $replyToEmailOffice = $request->get('email');
        $replyToNameOffice = $request->get('name');

        $estado2 = $this->sendMail($mailToOffice, $emailRecipientOffice, $emailSubjectOffice ,$emailBodyOffice ,$replyToEmailOffice ,$replyToNameOffice);

        if( !$estado1 && !$estado2 ) {

            return redirect()->route('info.enviada')->with('toast_success', '¡Información enviada con éxito!');
        } 
        else {
            
            return redirect()->route('info.enviada')->with('toast_success', '¡Información enviada con éxito!');
        }


        //redireccionar
        //return redirect()->route('info.enviada')->with('toast_success', '¡Información enviada con éxito!');
    }

    public function ordenes()
    {
        //capturar la informacion del usuario logeado
        $user = auth()->user();
        //capturar las ordenes del usuario logeado
        $ordenes = Orden::where('user_id', $user->id)->get();
        //capturar el detalle de cada orden
        foreach ($ordenes as $orden) {
            $orden->detalle = OrdenDetalle::where('orden_id', $orden->id)->get();
            //ahora buscar el producto de cada detalle
            foreach ($orden->detalle as $item) {
                $item->producto = $item->Producto;
            }
        }
        return view('perfil.ordenes.index', compact('user', 'ordenes'));
    }

    public function ordenes_detalle($id)
    {
        $orden = Orden::find($id);
        $detalle = OrdenDetalle::where('orden_id', $id)->get();
        foreach ($detalle as $item) {
            $item->producto = $item->Producto;
        }
        return view('perfil.ordenes.detalle', compact('orden', 'detalle'));
    }


    private function sendMail(PHPMailer $mail, $emailRecipient ,$emailSubject ,$emailBody ,$replyToEmail ,$replyToName ) 
    {

        require base_path("vendor/autoload.php");

        //$mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 1;
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
