<?php

class homeAdminController
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
        if (isset($_SESSION['correo'])&&(isset($_SESSION['rolActual']))&&$_SESSION['rolActual']==1){
            $this->renderizado->render('/homeAdmin');
        }
        else{
            $this->renderizado->render('/login');
        }
    }


}