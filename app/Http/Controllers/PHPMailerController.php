<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Collection;

class PHPMailerController extends Controller {

    // =============== [ Email ] ===================
    public function email() {

        return view("email");
    }


    // ========== [ Compose Email ] ================
    public function sendEmailNotif(Collection $message) {

        require base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'p3plmcpnl492651.prod.phx3.secureserver.net';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'notificaciones@rtelsalvador.com';   //  sender username
            $mail->Password = '24fm2l$PX_5(';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 465;                          // port - 587/465

            $mail->setFrom('notificaciones@rtelsalvador.com', 'Representaciones Thompson');
            $mail->addAddress($message->get('emailRecipient')); /* NOTA: mandar a llamar email según config en la BD*/
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

            $mail->Subject = $message->get('emailSubject');
            $mail->Body    = $message->get('emailBody');

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {

                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            } 
            else {

                return back()->with("success", "Email has been sent.");
            }

        } catch (Exception $e) {
             return back()->with('error','Message could not be sent.');
        }
    }
}
