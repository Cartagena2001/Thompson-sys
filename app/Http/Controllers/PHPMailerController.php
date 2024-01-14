<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Collection;

class PHPMailerController extends Controller {

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
        return view('sendemail');
    }


    // ========== [ Compose Email ] ================
    public function sendEmail(Request $request) {

        //validar los datos
        $request->validate([

            'g-recaptcha-response' => 'recaptcha'

        ]);
       /*
        $request->validate([

            'cif' => 'string|min:1|max:24',
            'notas' => 'string|max:250',
            'notas_bodega' => 'string|max:250',
            'bulto' => 'string|max:9',
            'paleta' => 'string|max:9',
            'ubicacion' => 'string|max:19',
            'g-recaptcha-response' => 'recaptcha'

        ]);
        /*/

        require base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            /* Email SMTP Settings */
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');                          // port - 587/465
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom('notificaciones@rtelsalvador.com', 'Representaciones Thompson');
            $mail->addAddress($request->email); /* NOTA: mandar a llamar email según config en la BD*/
            //$mail->addCC($request->emailCc);
            //$mail->addBCC($request->emailBcc);

            $mail->addReplyTo('oficina@rtelsalvador.com', 'Oficinas RT El Salvador');

            /*
            if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }
            */

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $request->subject;
            $mail->Body    = $request->body;

            if( !$mail->send() ) {

                dd($mail->ErrorInfo);

                return back()->with("error", "Email not sent.")->withErrors($mail->ErrorInfo);
            }
                
            else {

                return back()->with("success", "Email has been sent.");
            }
    
        } catch (Exception $e) {
                return back()->with('error','Message could not be sent.');
        }

    }


}//fin clase
