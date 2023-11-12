<?php
class registroModel {
   private $database;

    public function __construct($database){
        $this-> database = $database;
    }

    public function agregarUsuario ($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password, $rol, $hash, $activo,$latitud,$longitud,$pais,$ciudad){
        $nivelUsuario=0;
        $preguntasRecibidas=0;
        $preguntasAcertadas=0;
        $sql = "INSERT INTO usuarios (nombreCompleto, username, fechaNac, genero, mail, password, rol, imagen, hash, activo, latitud, longitud, pais, ciudad, nivelUsuario, preguntasRecibidas, preguntasAcertadas) VALUES ('$nombreCompleto','$username','$fechaNac','$genero','$mail', '$password', '$rol', '$rutaImagen', '$hash', '$activo','$latitud','$longitud','$pais','$ciudad','$nivelUsuario','$preguntasRecibidas','$preguntasAcertadas')";
        $sql2= "INSERT INTO ranking (mail, puntajesPorPartida, puntajeTotal) VALUES ('$mail',0,0)";
        try {
            $this->database->execute($sql);
            $this->database->execute($sql2);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function cuentaActivada($correo){
        $sql = "SELECT activo FROM usuarios WHERE mail= '$correo'";
        $result = $this->database->queryAssoc($sql);

        if ($result['activo']=='SI'){
            return true;
        }else{
            return false;
        }
    }

    public function activarCuenta($correo){
        $sql = "UPDATE usuarios SET activo = 'SI' WHERE mail= '$correo'";
        $result = $this->database->execute($sql);
    }

    public function buscarHashUsuario($correo){
        $sql = "SELECT hash FROM usuarios WHERE mail = '$correo'";
        $result = $this->database->queryAssoc($sql);
        return $result['hash'];
    }



}
?>


