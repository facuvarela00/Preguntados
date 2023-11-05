<?php
class registroModel {
   private $database;

    public function __construct($database){
        $this-> database = $database;
    }

    public function agregarUsuario ($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password, $rol){

        $sql = "INSERT INTO usuarios (nombreCompleto, username, fechaNac, genero, mail, password, rol, imagen) VALUES ('$nombreCompleto','$username','$fechaNac','$genero','$mail', '$password', '$rol', '$rutaImagen')";
        $sql2= "INSERT INTO ranking (mail, puntajesPorPartida, puntajeTotal) VALUES ('$mail',0,0)";
        try {
            $this->database->execute($sql);
            $this->database->execute($sql2);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /* CON MAPA
     public function agregarUsuario ($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password, $rol,$lat,$lng){

        $sql = "INSERT INTO usuarios (nombreCompleto, username, fechaNac, genero, mail, password, rol, imagen,latitud, longitud) VALUES ('$nombreCompleto','$username','$fechaNac','$genero','$mail', '$password', '$rol', '$rutaImagen', '$lat', '$lng')";
        $sql2= "INSERT INTO ranking (mail, puntajesPorPartida, puntajeTotal) VALUES ('$mail',0,0)";
        try {
            $this->database->execute($sql);
            $this->database->execute($sql2);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }*/


}
?>


