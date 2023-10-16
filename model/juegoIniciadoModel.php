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

        $sql = "SELECT id FROM categorias WHERE id = '$numeroAleatorio'";
        $resultado = $this->database->queryAssoc($sql);

        return $resultado;
    }

    public function buscarRespuestas($idPregunta){


        $sql = 'SELECT * FROM respuestas where id_pregunta =' . $idPregunta . ';';
        $resultado = $this->database->query($sql);
        //$resultado es un arreglo multidimensional que contiene todas las filas seleccionadas de la base de datos.

        return $resultado;
    }

}

?>

