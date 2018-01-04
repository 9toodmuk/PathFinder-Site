<?php
namespace Controller\Utils;

use Config\Database;
use Controller\User\Profile;
use Controller\PHPMailer\PHPMailer;

class Email {

    public static function sendEmail($id, $type){
        $user = Profile::profileload($id);
        $user = mysqli_fetch_assoc($user);

        $emailTitle = Email::createTitle($type);
        $emailBody = Email::createEmail($type);

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'pathfinder.in.th';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'contact@pathfinder.in.th';                 // SMTP username
            $mail->Password = 'AemzaLanla159';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to
        
            //Recipients
            $mail->setFrom('contact@pathfinder.in.th', 'PathFinder');
            $mail->addAddress($user['email']);
        
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $emailTitle;
            $mail->Body    = $emailBody;
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function createEmail($type){
        return (include 'app/view/layouts/emails/register.confirmation.php');
    }

    public static function createTitle($type){
        return "Please confirm your email";
    }
}