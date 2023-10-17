<?php
class juegoIniciadoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function cantidadTotalDeCategorias(){
        $total = 0;

        $sql = "SELECT COUNT(*) FROM categorias";
        $resultado = $this->database->query($sql);

        foreach($resultado as $result){
            $total++;
        }
            return $total;
    }

    public function buscarCategoria($numeroAleatorio){
        $sql = "SELECT * FROM categorias WHERE id = '$numeroAleatorio'";
        $resultado = $this->database->queryID($sql);
        return $resultado;
    }

    public function buscarPregunta($idCategoria){
        $utilizada = 0;
        $sql = "SELECT * FROM preguntas WHERE id_categoria LIKE '$idCategoria' AND utilizada LIKE '$utilizada'";
        $result = $this->database->queryID($sql);

        /*$preguntaElegida = $this->fueUtilizada($result);*/

        return $result;
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

}

?>

