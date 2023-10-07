<?php

class homeController
{
    private $modelo;

    public function __construct()
    {
        include_once('c://xampp/htdocs/Login-MVC/model/homeModel.php');
        $this ->modelo = new homeModel ();
    }

    public function guardarUsuario($correo, $password)
    {
        $valor = $this ->modelo ->agregarUsuario($correo, $this ->encriptarPassword($password));
        return $valor;
    }

    //Encripta la contraseña
    public function encriptarPassword($password)  {
        return password_hash($password, PASSWORD_DEFAULT );
    }

    //Des encripta la contraseña - verifica usuario
    public function verificarUsuario($password)  {
       $llave = $this ->modelo->obtenerClave($password);
       die();
       return (password_verify($password, $llave)) ? true : false;
    }
}
?>