<?php

include_once("c:/xampp/htdocs/third-party/PHPMailler.php");
class registroController{
    private $modelo;
    private $renderizado;
    public function __construct($modelo,$renderizado){
        $this ->modelo = $modelo;
        $this->renderizado=$renderizado;
    }

    public function execute() {
        $error = "";
        $this->renderizado->render('/registro');
    }

    /////////////////////FUNCIONES DE REGISTRAR/////////////////////

    public function validarRegistro() {

        $mail = $_POST["correo"];
        $password = $_POST["password"];
        $confirmarPassword = $_POST["confirmarPassword"];
        $mailValido = $this->validarFormatoMail($mail);
        $error="";

        if ($password === $confirmarPassword && $mailValido!="") {
            if (!($this->guardarUsuario($mailValido,$password))) {
                $error = 'El correo ya está registrado';
            } else {
                enviarEmailBienvenida($mailValido);
                header("location:/login");
                exit();
            }
        } else if ($mailValido=="") {
            $error = 'Correo inválido';
        } else {
            $error = 'Las contraseñas son diferentes';
        }

        if ($error!=""){
            $this->renderizado->render('/registro', ['error' => $error]);
            exit();
        }

    }

    public function guardarUsuario($correo, $password){
        $passwordHash=$this->encriptarPassword($password);
        return $this->modelo->agregarUsuario($correo, $passwordHash);

    }

    ////////////////FUNCIONES DE VERIFICACION////////////////////
    public function encriptarPassword($password)  {
        return password_hash($password, PASSWORD_DEFAULT );
    }

    public function adaptarTexto($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function validarFormatoMail($correo){
            $email = $this->adaptarTexto($correo);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;}
            else{
                return "";
        }
    }


}
?>


