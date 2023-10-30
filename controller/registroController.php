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

        $nombreCompleto=$_POST["name"];
        $username=$_POST["username"];
        $fechaNac=$_POST["year"];
        $genero=$_POST["genero"];
        $mail = $_POST["correo"];
        $password = $_POST["password"];
        $confirmarPassword = $_POST["confirmarPassword"];
        $mailValido = $this->validarFormatoMail($mail);
        $imagen = $_FILES['imagen'];
        $nombreImagen = $mail;
        $rutaImagen = $_SERVER['DOCUMENT_ROOT'] . '/public/imagenesPerfil/' . $nombreImagen . '.png';
        $error="";
    
        if ($password === $confirmarPassword && $mailValido!="") {
            if (!($this->guardarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password))) {
                $error = 'El correo ya está registrado';
            } else {
                move_uploaded_file($imagen['tmp_name'], $rutaImagen);
                
                $resultadoEmail = enviarEmailBienvenida($mailValido);
                if ($resultadoEmail != true) {
                    $error = $resultadoEmail;
                } else {
                    header("location:/login");
                    exit();
                }
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

    /* ORIGINAL SIN CONTROL DE ROLES
    public function validarRegistro() {

        $nombreCompleto=$_POST["name"];
        $username=$_POST["username"];
        $fechaNac=$_POST["year"];
        $genero=$_POST["genero"];
        $mail = $_POST["correo"];
        $password = $_POST["password"];
        $confirmarPassword = $_POST["confirmarPassword"];
        $mailValido = $this->validarFormatoMail($mail);
        $imagen = $_FILES['imagen'];
        $nombreImagen = $mail;
        $rutaImagen = $_SERVER['DOCUMENT_ROOT'] . '/public/imagenesPerfil/' . $nombreImagen . '.png';
        $error="";

        if ($password === $confirmarPassword && $mailValido!="") {
            if (!($this->guardarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password))) {
                $error = 'El correo ya está registrado';
            } else {
                move_uploaded_file($imagen['tmp_name'], $rutaImagen);

                $resultadoEmail = enviarEmailBienvenida($mailValido);
                if ($resultadoEmail != true) {
                    $error = $resultadoEmail;
                } else {
                    header("location:/login");
                    exit();
                }
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
    }*/


    public function guardarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password){
        $passwordHash=$this->encriptarPassword($password);
        $rol=3;
        return $this->modelo->agregarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail,$passwordHash,$rol);

    }
    /*ORIGINAL SIN CONTROL DE ROLES
    public function guardarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password){
        $passwordHash=$this->encriptarPassword($password);
        return $this->modelo->agregarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $passwordHash);

    }
    */
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


