<?php

include_once('c://xampp/htdocs/Preguntados/controller/homeController.php');
session_start();

$obj = new homeController ();
$correo = $_POST['correo'];
$contrasenia = $_POST['contraseña'];

$bandera = $obj -> verificarUsuario($correo, $contrasenia);

if ($bandera) {
    $_SESSION['usuario'] = $correo;
    header("location: panel_control.php");
} else {
    $error = '<p> Usuario o Contraseña incorrecto </p>';
    header("location: login.php?error=".$error);
};

?>


