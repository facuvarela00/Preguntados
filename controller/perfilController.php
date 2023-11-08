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

            $usuario=$this->modelo->buscarUsuario($_GET['id']);

            $correo = $usuario['mail'];
            $user = $usuario['username'];
            $img = $usuario['imagen'];
            $qr = $this -> generadorQR();
            
            $data = array(
                'correo' => $correo,
                'user' => $user,
                'img' => $img,
                'qr' => $qr
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

    public function generadorQR(){
        $datos = $this->traerDatosUsuario();
        if(!empty($datos)){
            $url_perfil = "https://localhost/perfil?id=" . $_GET['id'];
            QRcode::png($url_perfil,false,QR_ECLEVEL_L,8);

            $qrData = ob_get_clean();
            return base64_encode($qrData);
        }
    }

}