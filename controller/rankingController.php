<?php

class rankingController
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
            $correo = $_SESSION['correo'];

            $rankingPersonal = $this->modelo->hacerRankingPersonal($correo);
            $rankingGlobal = $this->modelo->hacerRankingGlobal();
            $puntajeTotal = $this->modelo->obtenerPuntajeTotalPersonal($correo);
            $idPersonal = $this->modelo->obtenerIdPersonal($correo); //OBTENGO ID DEL USUARIO

            $data = array(
                'rankingPersonal' => $rankingPersonal,
                'rankingGlobal' => $rankingGlobal,
                'puntajeTotal' => $puntajeTotal,
                'idPersonal' => $idPersonal,//LO GUARDO EN EL ARRAY
            );

            if ($rankingPersonal != 0 && $rankingGlobal != 0) {
                $this->renderizado->render('/ranking', $data);
            } else {
                $this->renderizado->render('/ranking',$data);
            }

        } else {
            $this->renderizado->render("/login");
        }
    }
}