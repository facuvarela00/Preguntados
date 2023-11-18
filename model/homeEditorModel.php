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
        $sql = "SELECT pregunta FROM preguntas where id = $id";
        $pregunta = $this->database->queryAssoc($sql);
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

    public function traerIDRespuestasDePregunta($id){
        $sql = "SELECT id FROM respuestas WHERE id_pregunta = '$id'";
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

    public function eliminarPregunta($idPregunta){
       //hay que borrar tambien la pregunta en la tabla de reportadas?
        $sql = "DELETE FROM respuestas WHERE id_pregunta='$idPregunta'";
        $sql2 = "DELETE FROM preguntas WHERE id='$idPregunta'";
        $this->database->execute($sql);
        $this->database->execute($sql2);
    }

    public function modificarPreguntaRespuestas($idPregunta,$idRespuestaCorrecta,$id_categoria,$pregunta,$respuestaA,$respuestaB,$respuestaC,$respuestaD){
        //Pregunta
        $sql1 = "UPDATE preguntas SET pregunta='$pregunta', id_categoria = $id_categoria WHERE id = $idPregunta";
        $this->database->execute($sql1);
        //Respuestas
        $arrayRespuetas = [$respuestaA,$respuestaB,$respuestaC,$respuestaD];
        $respusetasBD=$this->traerIDRespuestasDePregunta($idPregunta);
        for($i=0; $i<=3; $i++){
            $idRespuesta=$respusetasBD[$i]['id'];
            $sql2 = "UPDATE respuestas SET respuesta= '$arrayRespuetas[$i]', esCorrecta=0 WHERE id =  $idRespuesta";
            if($idRespuesta == $idRespuestaCorrecta){
                $sql2 = "UPDATE respuestas SET respuesta= '$arrayRespuetas[$i]', esCorrecta=1 WHERE id =  $idRespuesta";
            }
            $this->database->execute($sql2);
        }
    }

}


/*
         for($i=0; $i<=3; $i++){
            $idRespuesta=$respusetasBD[$i]['id'];
            $sql2 = "UPDATE respuestas";
            if($idRespuesta == $idRespuestaCorrecta){
                $sql2 .= " SET respuesta= '$arrayRespuetas[$i]', esCorrecta=1 WHERE id =  $idRespuesta";
                array_push($arraysql,$sql2);
            }else{
                $sql2 .= " SET respuesta='$arrayRespuetas[$i]', esCorrecta=0 WHERE id =  $idRespuesta";
                array_push($arraysql,$sql2);
            }
            var_dump($arraysql[$i]);
        }
 */
?>
