<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => 'recaptcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    { 

        $mailToClient = new PHPMailer(true);     // Passing `true` enables exceptions

        $mailToOffice = new PHPMailer(true);     // Passing `true` enables exceptions
        
        //Envio de notificación por correo al cliente
        $emailRecipientClient = $data['email'];
        $emailSubjectClient = 'Registro de Usuario - RTElSalvador';
        $emailBodyClient = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/rtthompson-logo.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p><b>¡BIENVENIDO!</b></p>
                        
                        <br/>

                        <p><b>Sr./Sra.</b>: ".$data['name']." </p>
                        <p><b>Correo electrónico</b>: ".$data['email']."</p>

                        <br/>
                        
                        <p>Por favor completa el proceso de registro ingresando tus datos en el formulario.</p>
                        ";
                        
        $replyToEmailClient = "oficina@rtelsalvador.com";
        $replyToNameClient = "Representaciones Thompson";

        $estado1 = $this->sendMail($mailToClient, $emailRecipientClient ,$emailSubjectClient ,$emailBodyClient ,$replyToEmailClient ,$replyToNameClient);

        //Envio de notificación por correo a oficina
        $emailRecipientOff = "oficina@rtelsalvador.com";
        
        $emailSubjectOff = 'Registro de nuevo Usuario - RTElSalvador';
        $emailBodyOff = " 
                        <div style='display:flex;justify-content:center;' >
                            <img alt='rt-Logo' src='https://rtelsalvador.com/assets/img/rtthompson-logo.png' style='width:100%; max-width:250px;'>
                        </div>

                        <br/>
                        <br/>

                        <p><b>HAY UN NUEVO USUARIO REGISTRADO.</b></p>
                        
                        <br/>

                        <p><b>Sr./Sra.</b>: ".$data['name']." </p>
                        <p><b>Correo electrónico</b>: ".$data['email']."</p>

                        <br/>
                        
                        <p>Recuerda que por el momento es solo un aspirante, deberás autorizarle o no acceso desde el sistema RT una vez haya completado el formulario de registro.</p>
                        ";
                        
        $replyToEmailOff = $data['email'];
        $replyToNameOff = $data['name'];

        $estado2 = $this->sendMail($mailToOffice, $emailRecipientOff ,$emailSubjectOff ,$emailBodyOff ,$replyToEmailOff ,$replyToNameOff);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'estado' => 'activo',
            'rol_id' => 2, //cliente/aspirante
            'estatus' => 'aspirante', 
            'clasificacion' => 'precioOP',
            'imagen_perfil_src' => 'custom-img-user.png',
            'marcas' => '',
            'form_status' => 'none',
            'fecha_registro' => \Carbon\Carbon::now()->toDateTimeString(),
            'boletin' => 1,
            'visto' => 'nuevo'
        ]);
        
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
