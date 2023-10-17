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
        $error = "";
        $this->renderizado->render('/homeJuego');
    }

    public function iniciarJuego(){

        header("location:/juegoIniciado/iniciarJuego");
    }
}