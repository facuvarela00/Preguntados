<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function enviarEmailBienvenida($correo, $hash) {

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2;      
    $mail->isSMTP();           
    $mail->Host       = 'outlook.office365.com';
    $mail->SMTPAuth   = true;                   
    $mail->Username   = 'unlamprueba1@outlook.com';
    $mail->Password   = 'Unlam2023';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('unlamprueba1@outlook.com');
    $mail->addAddress($correo);
    
    //$mail->addAttachment('preguntados.png');

    $username=$_POST["username"];
    $passwordUsuario = $_POST["password"];
    $emailUsuario = $_POST["correo"];
    /*$hashObtenido = $_POST["hash"];*/

    $mail->isHTML(true);
    $mail->Subject = 'Registro - Anime Test';
    $mail->Body ='¡Bienvenido!
    Valida tu cuenta a través del siguiente <a href="http://localhost/registro/activarCuenta?correo='.$emailUsuario.'">LINK</a>. 
    <h2>Tu código de validación es '.$hash.'</h2>.';
    
    $mail->send();
    return true; //'El correo se envió correctamente'
} catch (Exception $e) {
    return "Se produjo un error al enviar el correo. {$mail->ErrorInfo}";
}
}