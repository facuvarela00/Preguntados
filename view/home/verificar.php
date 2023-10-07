<?php

include_once('c://xampp/htdocs/Preguntados/controller/homeController.php');

$obj = new homeController ();

$correo = $_POST['correo'];
$contrasenia= $_POST['contraseña'];

$obj -> verificarUsuario($correo, $contrasenia);



?>


