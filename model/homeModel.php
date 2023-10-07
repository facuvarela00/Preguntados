<?php
class homeModel {

   private $conection;

    public function __construct()
    {
        include_once ('c://xampp/htdocs/Preguntados/config/db.php');
        $conn = new db();
       $this-> $conection = $conn -> conexion();
    }

    public function agregarUsuario ($correo, $password)  {
        $sql = "INSERT INTO usuarios (mail, password) VALUES ('$correo', '$password')";

        //maneja la excepcion cuando el correo es duplicado
        try {
            mysqli_query( $this-> $conection, $sql);
            return true;
        }catch (Exception $e){
            return false;
        }
    }

    public function obtenerClave ($correo)
    {
        $encontrada= "";

        $sql1 = " SELECT password FROM usuarios WHERE mail LIKE '$correo' ";

        $resultado = mysqli_query($this-> $conection, $sql1);

        while ($row = mysqli_fetch_assoc($resultado)) {
            $encontrada= $row['password'];
        }
        var_dump($encontrada);
        return $encontrada;
    }
}

?>


