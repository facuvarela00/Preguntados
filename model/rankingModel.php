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

    public function obtenerIdPersonal($correo){
        $respuesta="";
        $sql = "SELECT * FROM usuarios WHERE mail like '$correo'";
        $respuesta = $this->database->queryID($sql);

        return $respuesta['id'];
    }

    public function hacerRankingPersonal($correo)
    {
        $contador = 0;
        $puntajesPersonales = $this->obtenerPuntajePersonal($correo);
        if($puntajesPersonales!=0){
            rsort($puntajesPersonales);
            foreach ($puntajesPersonales as $puntaje) {
                $contador++;
                $rankingPersonalData[] = array(
                    'posicion' => $contador,
                    'puntaje' => $puntaje
                );
            }
            return $rankingPersonalData;
        }else{
            return 0;
        }


    }
    public function obtenerPuntajeTotalPersonal($correo){
        $sql = "SELECT puntajeTotal FROM ranking WHERE mail='$correo' ";
        $puntajeTotal = $this->database->queryAssoc($sql);

        return $puntajeTotal['puntajeTotal'];
    }

    public function obtenerPuntajeTotalGlobal(){
        $sql = "SELECT puntajeTotal, mail FROM Ranking ";
        $puntajesTotales = $this->database->query($sql);
        return $puntajesTotales;
    }

    public function hacerRankingGlobal(){
        $contador = 0;
        $puntajesTotales = $this->obtenerPuntajeTotalGlobal();
        if($puntajesTotales){
        rsort($puntajesTotales);
        $rankingGlobalData = array();
        foreach ($puntajesTotales as $puntaje) {
            $contador++;
            $rankingGlobalData[] = array(
                'idPersonal'=>$this->buscarIDporCorreo($puntaje['mail']),
                'mail' => $puntaje['mail'], // Obtén el correo electrónico de la fila actual
                'posicion' => $contador,
                'puntaje' => $puntaje['puntajeTotal'] // Obtén el puntaje total de la fila actual
            );
        }
        return $rankingGlobalData;
        }else{
            return 0;
        }
    }

    public function buscarIDporCorreo($correo){

        $sql = "SELECT id FROM usuarios WHERE mail='$correo' ";
        $result=$this->database->queryAssoc($sql);
        return $result['id'];
    }

}