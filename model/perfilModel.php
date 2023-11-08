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

}