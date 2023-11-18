<?php

class perfilModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }

    public function buscarUsuario($id){
        $resultado = "";
        $sql = "Select * from usuarios where id = ('$id')";
        $resultado = $this->database->queryID($sql);
        return $resultado;
    }

    public function buscarUsuarioMail($correo){
        $resultado = "";
        $sql = "Select * from usuarios where mail = ('$correo')";
        $resultado = $this->database->queryAssoc($sql);
        return $resultado;
    }

}