<?php
include_once ('c://xampp/htdocs/Preguntados/controller/homeController.php');

$obj = new homeController();

$correo =$_POST['correo'];
$cofirmarContrasenia =$_POST['cofirmarContraseña'];
$Contrasenia=$_POST['contraseña'];
$mailValido=false;

//distintas validaciones espacio caracteres especiales etc
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//validar formato valido de mail
if (!empty($correo)) {
      $email = test_input($correo);
    // checkea si el formato es correcto
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mailValido=true;
    }
}

//validar que sean iguales las contraseñas
// y los mail distintos
// (tiene un campo unique en la base, si le mandamos mails iguales, la funcion devuelve false)
if (($Contrasenia == $cofirmarContrasenia) && $mailValido){
    if($obj ->guardarUsuario($correo, $Contrasenia)==false){
        $error = '<p> El email ya esta registrado</p>';
        header("location: SignUp.php?error=".$error);
    }else{
        require 'c://xampp/htdocs/Preguntados/PHPMailler.php';
        enviarEmailBienvenida($correo);
        //var_dump(enviarEmailBienvenida($correo));
        header("location: login.php");
    }
}else if ($mailValido == false) {$error = '<p> email invalido</p>';
    header("location: SignUp.php?error=".$error);
}else{
    $error = '<p> Las contraseñas son diferentes </p>';
    header("location: SignUp.php?error=".$error);
}





