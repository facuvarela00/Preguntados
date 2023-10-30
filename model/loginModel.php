<?php

class loginModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerClave($correo,$password)
    {
        $sql1 = "SELECT password FROM usuarios WHERE mail = '$correo'";
        $resultado = $this->database->queryAssoc($sql1);

        if (!empty($resultado) && $this->obtenerRol($correo)==3){

            if (password_verify($password, $resultado['password'])) {
                return true;
            }
            else{
                return false;
            }
        }else if(!empty($resultado) && $this->obtenerRol($correo)!=3){
            if ($password == $resultado['password']) {
                return true;
            }
            else{
                return false;
            }
        }else{
            return false;
        }

    }

    public function obtenerRol($correo)
    {
        $sql1 = "SELECT rol FROM usuarios WHERE mail = '$correo'";
        $resultado = $this->database->queryAssoc($sql1);

        if (empty($resultado)){
                return -1;
        }else{
            return $resultado['rol'];
        }

    }

    public function obtenerMail($correo)
    {
        $sql1 = "SELECT mail FROM usuarios WHERE mail = '$correo'";
        $resultado = $this->database->query($sql1);
        if(!empty($resultado)){
            return true;
        }else{
            return false;
        }
    }

    public function buscarNombre($correo){
        $sql1 = "SELECT nombreCompleto FROM usuarios WHERE mail = '$correo'";
        $resultado = $this->database->queryAssoc($sql1);
        if (!empty($resultado)) {
            if (isset($resultado['nombreCompleto']) && is_string($resultado['nombreCompleto'])) {
                return $resultado['nombreCompleto'];
            } else {
                return "";
            }
        } else {
            return "";
        }
    }
}

?>
