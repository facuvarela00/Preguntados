<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function enviarEmailBienvenida($correo) {

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2;      
    $mail->isSMTP();           
    $mail->Host       = 'outlook.office365.com';
    $mail->SMTPAuth   = true;                   
    $mail->Username   = 'animetestunlam@outlook.com';
    $mail->Password   = 'Unlam2023';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('animetestunlam@outlook.com');
    $mail->addAddress($correo);
    
    //$mail->addAttachment('preguntados.png');

    $mail->isHTML(true);
    $mail->Subject = 'Registro - Preguntados UNLaM';
    $mail->Body ='¡Tu registro fue exitoso!';
    
    $mail->send();
    return true; //'El correo se envió correctamente'
} catch (Exception $e) {
    return "Se produjo un error al enviar el correo. {$mail->ErrorInfo}";
}
}