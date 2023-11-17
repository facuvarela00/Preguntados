<?php

class homeEditorModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function traerPreguntas(){
        $sql = "SELECT * FROM preguntas";
        $arrayPreguntas = $this->database->query($sql);
        return $arrayPreguntas;
    }

    public function traerPregunta($id){
        $sql = "SELECT * FROM preguntas where id = $id";
        $pregunta = $this->database->queryID($sql);
        return $pregunta;
    }

    public function traerRespuestas(){
        $sql = "SELECT * FROM respuestas";
        $arrayRespuestas = $this->database->query($sql);
        return $arrayRespuestas;
    }

    public function traerCategorias(){
        $sql = "SELECT * FROM categorias";
        $arrayCategorias = $this->database->query($sql);
        return $arrayCategorias;
    }

    public function traerRespuestasDePregunta($id){
        $sql = "SELECT respuesta FROM respuestas WHERE id_pregunta = '$id'";
        $arrayRespuestas = $this->database->query($sql);
        return $arrayRespuestas;
    }

    public function traerPreguntaReportadas(){
        $sql = "SELECT * FROM preguntas_reportadas";
        $arrayPreguntas = $this->database->query($sql);
        return $arrayPreguntas;
    }

    public function tabla(){
        $campo = isset($_POST['buscar']) ? $_POST['buscar'] : null;
        $columns=['ID', 'Categorías', 'Preguntas'];

        $arrayTabla='';
        $where = '';
        if($campo != null){
            $where = "WHERE (";

            $cont = 3;//cantidad de columnas
            for($i=0; $i<$cont; $i++){
                $where .= $columns[$i] . "LIKE '%" . $campo . "%'OR ";
            }
            $where = substr_replace($where, "", -3);
            $where .= ")";
            $sql='Select ' . implode(", ", $columns) . 'FROM preguntas' . $where . ';';
            $arrayTabla = $this->database->queryAssoc($sql);
        }
        return $arrayTabla;
    }

}

?>
