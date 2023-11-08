<?php
class registroModel {
   private $database;

    public function __construct($database){
        $this-> database = $database;
    }

    public function agregarUsuario ($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password, $rol, $hash, $activo){

        $sql = "INSERT INTO usuarios (nombreCompleto, username, fechaNac, genero, mail, password, rol, imagen, hash, activo) VALUES ('$nombreCompleto','$username','$fechaNac','$genero','$mail', '$password', '$rol', '$rutaImagen', '$hash', '$activo')";
        $sql2= "INSERT INTO ranking (mail, puntajesPorPartida, puntajeTotal) VALUES ('$mail',0,0)";
        try {
            $this->database->execute($sql);
            $this->database->execute($sql2);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function activarCuenta($correo){

        $query = ("UPDATE INTO usuarios (activo) VALUES ('SI')");

        $result = $this->database->execute($query);

    }

    public function buscarHashUsuario($correo){

        $sql = "SELECT hash FROM usuarios WHERE mail = '$correo'";

        $result = $this->database->queryAssoc($sql);

        var_dump($result);
        
        exit();


    }

}
?>


