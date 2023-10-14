<?php
class registroModel {
   private $database;

    public function __construct($database){
        $this-> database = $database;
    }

    public function agregarUsuario ($correo, $password){
        $sql = "INSERT INTO usuarios (mail, password) VALUES ('$correo', '$password')";

        try {
            $this->database->execute($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


}
?>


