<?php

class homeController
{
    private $modelo;

    public function __construct()
    {
        include_once('c://xampp/htdocs/Preguntados/model/homeModel.php');
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

    //compara la DB con lo que ingreso el usuario
    public function verificarUsuario($correo, $password)  {
        $llave = $this ->modelo->obtenerClave($correo);
        return (password_verify($password, $llave)) ? true : false;

/*
        if ((password_verify($password, $llave))) {
            echo '¡La contraseña es válida!';
        } else {
            echo 'La contraseña no es válida.';
        };
*/

    }
}
?>


