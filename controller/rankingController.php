<?php

class rankingController{
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
            $correo = $_SESSION['correo'];
            $rankingPersonal = $this->modelo->hacerRankingPersonal($correo);
            $rankingGlobal=$this->modelo->hacerRankingGlobal();
            $puntajeTotal=$this->modelo->obtenerPuntajeTotalPersonal($correo);
            $error="";

            $data = array(
                'rankingPersonal' => $rankingPersonal,
                'rankingGlobal' => $rankingGlobal,
                'puntajeTotal' =>$puntajeTotal,
            );


            if (isset($rankingPersonal)&&isset($rankingGlobal)){
                $this->renderizado->render('/ranking', $data);
            }elseif (!isset($rankingPersonal)){
                $error="No tiene partidas jugadas.";
                $this->renderizado->render('/ranking', $error);
            }else{
                $error="No existe ranking global aún.";
                $this->renderizado->render('/ranking', $error);
            }

        }else{
            $this->renderizado->render("/login");
        }
    }
}