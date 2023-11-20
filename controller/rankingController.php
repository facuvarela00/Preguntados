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
            $rankingGlobal = $this->modelo->hacerRankingGlobal();
            $puntajeTotal = $this->modelo->obtenerPuntajeTotalPersonal($correo);
            $idPersonal = $this->modelo->obtenerIdPersonal($correo); //OBTENGO ID DEL USUARIO
            $data = array(
                'rankingGlobal' => $rankingGlobal,
                'puntajeTotal' => $puntajeTotal,
                'idPersonal' => $idPersonal
            );

            $this->renderizado->render('/ranking', $data);

        } else {
            $this->renderizado->render("/login");
        }
    }

    public function generarRankingPersonal()
    {
        $data=$this->modelo->hacerRankingPersonal($_SESSION['correo']);
        echo json_encode($data);
    }

    public function generarRankingGlobal()
    {
        $data=$this->modelo->hacerRankingGlobal();
        echo json_encode($data);
    }
}