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
        $latitud=$_POST["latitud"];
        $longitud=$_POST["longitud"];
        $pais=$_POST["pais"];
        $ciudad=$_POST["ciudad"];
        $error="";

        if ($password === $confirmarPassword && $mailValido!="") {

            $hash = rand(0, 1000);

            if (!($this->guardarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password, $hash,$latitud,$longitud,$pais,$ciudad))) {
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



    public function guardarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail, $password, $hash,$latitud,$longitud,$pais,$ciudad){

        $passwordHash=$this->encriptarPassword($password);
        $rol=3;
        $activo = "NO";

        return $this->modelo->agregarUsuario($nombreCompleto,$username,$fechaNac,$genero,$rutaImagen,$mail,$passwordHash,$rol, $hash, $activo,$latitud,$longitud,$pais,$ciudad);

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

    public function activarCuenta(){
        $correo = $_GET["correo"];
        $_SESSION['correoAValidar']=$correo;

        if (!$this->modelo->cuentaActivada($correo)){
            $this->renderizado->render('/activarCuenta');
        }else{
            header("Location:/login");
        }

    }
    
    public function validarCuenta(){
        $correo =  $_SESSION['correoAValidar'];
        $hash = $this->modelo->buscarHashUsuario($correo);
        $hashIngresado=$_POST["hashUsuario"];


        if($hashIngresado == $hash){
        $this->modelo->activarCuenta($correo);
        header("Location:/login");
        }else{
            header("Location:activarCuenta?correo=$correo");
        }
    }


}
?>


