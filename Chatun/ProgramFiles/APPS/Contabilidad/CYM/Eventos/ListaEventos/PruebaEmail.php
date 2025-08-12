<?php //echo phpinfo(); ?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
 
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'notificacionesparquechatun@gmail.com';                     //SMTP username
    $mail->Password   = 'zjfgsebrppffemre';                               //SMTP password
    //$mail->Username   = 'desarrollo@parquechatun.com';                     //SMTP username
    //$mail->Password   = 'Dev.Chatun2023$';                               //SMTP password
    $mail->SMTPSecure =   'ssl';//PHPMailer::ENCRYPTION_SMTPS;           //Enable implicit TLS encryption
    $mail->Port       = 25;                                      //TCP port to connect to; use 587 or 465 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('notificacionesparquechatun@gmail.com', 'Notificaciones');
    $mail->addAddress('darvinguerra99@gmail.com');     //quien recibe              //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Prueba';
    $mail->Body    = 'Correo de Prueba';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Se fue';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}