<?php

class homeJuegoController{
    private $modelo;
    private $renderizado;

    public function __construct($modelo, $renderizado)
    {
        $this->modelo = $modelo;
        $this->renderizado = $renderizado;
    }

    public function execute()
    {


        if (isset($_SESSION['correo'])&&(isset($_SESSION['rolActual']))&&$_SESSION['rolActual']==3){
            $_SESSION['juegoIniciado']=0;
            $nombre = $_SESSION['nombre'];
            $data = [
                'nombre'=>$nombre,
            ];
            $this->renderizado->render('/homeJuego', $data);
        }
        else{

            $this->renderizado->render('/login');
        }

    }
    public function iniciarJuego(){
        header("Location:/juegoIniciado/iniciarJuego");
    }

    public function cerrarSesion(){
        session_destroy();
        header("Location:/login");
    }
}