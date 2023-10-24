<?php
class registroModel {
   private $database;

    public function __construct($database){
        $this-> database = $database;
    }

    public function agregarUsuario ($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password){


        $sql = "INSERT INTO usuarios (nombreCompleto, username, fechaNac, genero, mail, password, imagen) VALUES ('$nombreCompleto','$username','$fechaNac','$genero','$mail', '$password','$rutaImagen')";

        try {
            $this->database->execute($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


}
?>


