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
        if (isset($_SESSION['correo'])) {

            $this->renderizado->render('/perfil');
        } else {
            $this->renderizado->render('/login');
        }

    }

    public function mostrarUsuario(){
        $correo=$_SESSION['correo'];
        $resultado=$this->modelo->buscarUsuario($correo);
    }

}