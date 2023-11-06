<?php
class perderController
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
        $_SESSION['juegoIniciado']=0;
        $this->renderizado->render("/perder");

    }
}