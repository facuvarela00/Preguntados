<?php

class db
{
    //agregar constructor

    public static function conexion()
    {
       $conexion = mysqli_connect(hostname: 'localhost', username: 'root', password: '', database: 'usuarios');
        return $conexion;
    }
}
?>









