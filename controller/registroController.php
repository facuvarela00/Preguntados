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

            $hash = rand(0, 1000);

            if (!($this->guardarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password, $hash))) {
                $error = 'El correo ya está registrado';
            } else {
                move_uploaded_file($imagen['tmp_name'], $rutaImagen);
                $resultadoEmail = enviarEmailBienvenida($mailValido, $hash);
                echo'Por favor, revise su correo y valide su cuenta';
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


    public function guardarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password, $hash){

        $passwordHash=$this->encriptarPassword($password);

        $rol=3;
        $activo = "NO";

        return $this->modelo->agregarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail,$passwordHash,$rol, $hash, $activo);

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

    public function activarCuenta(){

        $correo = $_GET["correo"];

        $this->renderizado->render('/activarCuenta');

    }
    
    public function validarCuenta(){

        $correo = $_GET["correo"];

        var_dump($correo);
        exit();

        $hash = buscarHashUsuario($correo);

        $hashIngresado=$_POST["hashUsuario"];

        if(validarRegistro && $hashIngresado == $hash){

        $this->model->activarCuenta();

        }
    }


}
?>


