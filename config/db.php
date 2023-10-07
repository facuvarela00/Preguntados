<?php

class db
{
    //agregar constructor

    public static function conexion()
    {
        $conexion = mysqli_connect(hostname: 'localhost:3308', username: 'root', password: '', database: 'login');
        return $conexion;
    }
}
?>





