<?php

class rankingModel{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerPuntajePersonal($correo){
        $sql = "SELECT puntajesPorPartida FROM Ranking WHERE mail = '$correo'";
        $result = $this->database->queryAssoc($sql);
        $puntajesPersonales = json_decode($result['puntajesPorPartida'], true);
        return $puntajesPersonales;
    }

    public function hacerRankingPersonal($correo)
    {
        $contador = 0;
        $puntajesPersonales = $this->obtenerPuntajePersonal($correo);
        rsort($puntajesPersonales);
        foreach ($puntajesPersonales as $puntaje) {
            $contador++;
            $rankingPersonalData[] = array(
                'posicion' => $contador,
                'puntaje' => $puntaje
            );
        }
        return $rankingPersonalData;
        
    }

    public function obtenerPuntajeTotalGlobal(){
        $sql = "SELECT puntajeTotal, mail FROM Ranking ";
        $puntajesTotales = $this->database->query($sql);
        return $puntajesTotales;
    }

    public function hacerRankingGlobal(){
        $contador = 0;
        $puntajesTotales = $this->obtenerPuntajeTotalGlobal();
        rsort($puntajesTotales);

        $rankingGlobalData = array();

        foreach ($puntajesTotales as $puntaje) {
            $contador++;
            $rankingGlobalData[] = array(
                'mail' => $puntaje['mail'], // Obtén el correo electrónico de la fila actual
                'posicion' => $contador,
                'puntaje' => $puntaje['puntajeTotal'] // Obtén el puntaje total de la fila actual
            );
        }

        return $rankingGlobalData;
    }



}