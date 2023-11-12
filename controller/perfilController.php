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

    public function execute()
    {
        if (isset($_GET['id'])) {

            $id=intval($_GET['id']);
            $usuario=$this->modelo->buscarUsuario($id);

            $correo = $usuario['mail'];
            $user = $usuario['username'];
            $img = $usuario['imagen'];
            $this -> generadorQR($id);

            $data = array(
                'correo' => $correo,
                'user' => $user,
                'img' => $img,
                'id' => $id,
            );

            $this->renderizado->render('/perfil', $data);

        } else {
            $this->renderizado->render('/ranking');
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
        /*
        $url_perfil = "https://localhost/perfil?id=" . $id;
        //QRcode::png($url_perfil,false,QR_ECLEVEL_L,8); otra funcion qr
        $rutaCarpeta = "/public/QR_Usuario/";

        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0777, true);
        }
        $rutaFinal= $rutaCarpeta . $id . ".png";
        QRcode::png($url_perfil, $rutaFinal);
        return $rutaFinal;
        */

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

}