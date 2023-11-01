<?php
class juegoIniciadoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function cantidadTotalDeCategorias(){

        $sql = "SELECT COUNT(*) as total_categorias FROM categorias";
        $result = $this->database->queryAssoc($sql);
        if ($result !== false) {
          $totalCategorias = $result['total_categorias'];
          return $totalCategorias;
        }else{
            return NULL;
        }

    }

    public function cantidadTotalDePreguntas(){

        $sql = "SELECT COUNT(*) as total_preguntas FROM preguntas";
        $result = $this->database->queryAssoc($sql);
        if ($result !== false) {
            $totalPreguntas = $result['total_preguntas'];
            return $totalPreguntas;
        }else{
            return NULL;
        }

    }
    public function buscarCategoria($numeroAleatorio){
        $sql = "SELECT * FROM categorias WHERE id = '$numeroAleatorio'";
        $resultado = $this->database->queryID($sql);
        return $resultado;
    }

    public function buscarPregunta($idCategoria){
        $sql = "SELECT * FROM preguntas WHERE id_categoria LIKE '$idCategoria' AND utilizada = 0";
        $result = $this->database->queryID($sql);

        if (isset($result)){
            $preguntaElegida = $this->fueUtilizada($result);
            return $preguntaElegida;
        }else{
            return "";
        }

    }


    public function fueUtilizada($preguntaSeleccionada){
            $utilizada=1;
            $idpregunta=$preguntaSeleccionada['id'];
            $sql = "UPDATE preguntas SET utilizada = '$utilizada' WHERE id = '$idpregunta'";
            $result = $this->database->execute($sql);
            return $preguntaSeleccionada;
    }

    public function buscarRespuestas($idPregunta){


        $sql = 'SELECT * FROM respuestas WHERE id_pregunta =' . $idPregunta . ';';
        $resultado = $this->database->query($sql);
        //$resultado es un arreglo multidimensional que contiene todas las filas seleccionadas de la base de datos.

        return $resultado;
    }

    public function reestablecerPreguntas(){
        $sql = "SELECT * FROM preguntas WHERE utilizada=1";
        $result = $this->database->query($sql);

        foreach ($result as $preguntaSeleccionada){
            $this->noFueUtilizada($preguntaSeleccionada['id']);
        }
    }

    public function noFueUtilizada($idPregunta){
        $sql = "UPDATE preguntas SET utilizada = 0 WHERE id = '$idPregunta'";
        $result = $this->database->execute($sql);
    }
    public function agregarPuntajeAMiTablaRanking($correo,$puntajeDeLaPartida)
    {

        $sql = "SELECT puntajesPorPartida FROM Ranking WHERE mail = '$correo'";
        $result = $this->database->queryAssoc($sql);
        $puntajesActuales = json_decode($result['puntajesPorPartida'], true);
            if ($puntajesActuales === 0) {
                $puntajesActuales = [];
            }
        $puntajesActuales[] = $puntajeDeLaPartida;
        $puntajesActualizados = json_encode($puntajesActuales);
        $puntajeTotal = array_sum($puntajesActuales);

        $sqlUpdate = "UPDATE Ranking SET puntajesPorPartida = '$puntajesActualizados' WHERE mail = '$correo'";
        $sqlUpdate2 = "UPDATE Ranking SET puntajeTotal = '$puntajeTotal' WHERE mail = '$correo'";
        $this->database->execute($sqlUpdate);
        $this->database->execute($sqlUpdate2);
    }
}

?>

