<?php
class perfilController
{
    private $modelo;
    private $renderizado;

    public function __construct($modelo, $renderizado)
    {
        $this->modelo = $modelo;
        $this->renderizado = $renderizado;
    }

    public function execute(){
            if (isset($_GET['id'])) {
                $id=intval($_GET['id']);
                $usuario=$this->modelo->buscarUsuario($id);
                $user = $usuario['username'];
                $img = $usuario['imagen'];
                $genero = $usuario['genero'];
                $pais = $usuario['pais'];
                $nivel= $usuario['nivelUsuario'];
                $this -> generadorQR($id);

                $rutaImagenCompleta = $this->modelo->mostrarImagen($img);

                $data = array(

                    'username' => $user,
                    'img' => $img,
                    'id' => $id,
                    'genero' => $genero,
                    'pais' => $pais,
                    'nivel' => $nivel,
                );

                $this->renderizado->render('/perfil', $data);
            }
            else{
                $correo=$_SESSION['correo'];
                $usuario=$this->modelo->buscarUsuarioMail($correo);

                $nombreCompleto=$usuario['nombreCompleto'];
                $user=$usuario['username'];
                $fechaNac=$usuario['fechaNac'];
                $genero=$usuario['genero'];
                $mail=$usuario['mail'];
                $img=$usuario['imagen'];
                $pais=$usuario['pais'];
                $ciudad=$usuario['ciudad'];
                $nivel=$usuario['nivelUsuario'];
                $rutaImagenCompleta = $this->modelo->mostrarImagen($img);

                $data = [
                    'nombreCompleto'=>$nombreCompleto,
                    'username'=>$user,
                    'fechaNac'=>$fechaNac,
                    'genero'=>$genero,
                    'mail'=>$mail,
                    'img'=>$img,
                    'pais'=>$pais,
                    'ciudad'=>$ciudad,
                    'nivel'=>$nivel,
                    'img' => $rutaImagenCompleta,
                ];
                $this->renderizado->render('/perfilPersonal',$data);
             }
    }

    public function traerDatosUsuario(){
        $datos="";
        if (isset($_GET['id'])) {
            $datos = $this->modelo->buscarUsuario($_GET['id']);
            if($datos['rol']==3){
                return $datos;
            }
        }
        return $datos;
    }

    public function generadorQR($id){

        $url_perfil = "https://localhost/perfil?id=" . $id;

        $directorioActual = "C:/xampp/htdocs";
        $rutaCarpeta = $directorioActual . "/public/QR_Usuario/";

        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0777, true);
        }

        $rutaFinal = $rutaCarpeta . $id . ".png";
        if(!file_exists($rutaFinal)){
            QRcode::png($url_perfil, $rutaFinal);
        }

    }

    public function modificarUsuario() {

        $correo = $_SESSION['correo'];

            if (isset($_POST['name'], $_POST['username'],  $_POST['genero'], 
            $_FILES['imagen']["name"])) {
                $nombreCompleto = $_POST['name'];
                $username = $_POST['username'];
                $genero = $_POST['genero'];
                $imagen = $_FILES['imagen'];
                $nombreImagen = $correo . '.png';
                $rutaImagen = $_SERVER['DOCUMENT_ROOT'] . '/public/imagenesPerfil/' . $nombreImagen;

                $this->modelo->modificarPerfil($username, $nombreImagen, $nombreCompleto, $genero, 
                $correo); 

                move_uploaded_file($imagen['tmp_name'], $rutaImagen);
    
                header("Location: /sugerirPregunta/envioExitoso");
            } else {
                header("Location: /perfil");
            }
        
    }

    public function modificar(){

    if (isset($_SESSION['correo'])&&(isset($_SESSION['rolActual']))&&$_SESSION['rolActual']==3){
        if (isset($_POST['username'], $_POST['imagen'], $_POST['name'],
            $_POST['genero'])) {
        
        $username = $_POST['username'];
        $imagen = $_POST['imagen'];
        $nombreCompleto = $_POST['name'];
        $genero = $_POST['genero'];
        
        $data = ['username'=>$username, 'imagen' => $imagen, 'nombreCompleto' => $nombreCompleto, 
        'genero' => $genero];

        $this->renderizado->render('/modificarPerfil', $data);


} else{

    $this->renderizado->render('/login');
        
}

}

}

}
