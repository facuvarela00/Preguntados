<?php

include_once ('c://xampp/htdocs/Login-MVC/controller/homeController.php');

$obj = new homeController();

$correo =$_POST['correo'];
$cofirmarContrasenia =$_POST['cofirmarContraseña'];
$Contrasenia=$_POST['contraseña'];

//validar que sean iguales las contraseñas y los correos distintos
if ($Contrasenia == $cofirmarContrasenia){
    if($obj ->guardarUsuario($correo, $Contrasenia)==false){
        $error = '<p> El correo ya esta registrado</p>';
        header("location: SignUp.php?error=$error");
    }else{
        header("location: login.php");
    }
}else{
    $error = '<p> Las contraseñas son diferentes </p>';
    header("location: SignUp.php?error=$error");
}

