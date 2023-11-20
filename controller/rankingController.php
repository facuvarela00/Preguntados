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
            $idPersonal = $this->modelo->obtenerIdPersonal($correo);

            $data = array(
                'rankingPersonal' => $rankingPersonal,
                'rankingGlobal' => $rankingGlobal,
                'puntajeTotal' => $puntajeTotal,
                'idPersonal' => $idPersonal
            );

            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        } else {
            // Puedes enviar un código de error o redirigir a la página de inicio de sesión
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Usuario no autenticado']);
            exit();
        }

    }}