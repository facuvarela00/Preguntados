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
        $correo=$_SESSION['correo'] ;
        $this->renderizado->render('/homeJuego', ['correo' => $correo]);
    }

    public function iniciarJuego(){

        header("location:/juegoIniciado/iniciarJuego");
    }

    public function cerrarSesion(){
        session_destroy();
        header("Location:/login");
    }
}