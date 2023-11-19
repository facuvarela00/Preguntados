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

    public function traerIDNuevaPregunta($pregunta){
        $sql = "SELECT id FROM preguntas where pregunta like '$pregunta'";
        $pregunta = $this->database->queryAssoc($sql);
        return $pregunta;
    }

    public function traerPreguntasSugeridas(){
        $sql = "SELECT * FROM sugeridas";
        $arrayPreguntas = $this->database->query($sql);
        return $arrayPreguntas;
    }

    public function traerPreguntaSugeridaID($id){
        $sql = "SELECT * FROM sugeridas where id = $id";
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

    public function traerCategoriasID($cat){
        $sql = "SELECT categoria FROM categorias where id=$cat";
        $categorias = $this->database->queryAssoc($sql);
        return $categorias['categoria'];
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
        $sql = "DELETE FROM respuestas WHERE id_pregunta='$idPregunta'";
        $sql2 = "DELETE FROM preguntas WHERE id='$idPregunta'";
        $this->database->execute($sql);
        $this->database->execute($sql2);
    }

    public function eliminarPreguntSugerida($idPregunta){
        $sql = "DELETE FROM sugeridas WHERE id='$idPregunta'";
        $this->database->execute($sql);
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

    public function agregarPreguntaRespuestas($id_categoria,$pregunta,$respuestaA,$respuestaB,$respuestaC,$respuestaD,$dificultad, $correcta){
        //Pregunta
        $horaDeCreacion=date("Y-m-d H:i:s");

        $cantidadEntregada=15;
        if($dificultad=='Facil'){
            $cantidadAcertada=12;
        }else if($dificultad=='Medio'){
            $cantidadAcertada=7;
        }else{
            $cantidadAcertada=3;
        }
        $sql1="INSERT INTO preguntas (pregunta, utilizada, id_categoria, nivelPregunta, cantidadEntregada,cantidadAcertada, reportada, horaCreacion) VALUES ('$pregunta',0,$id_categoria,'$dificultad',$cantidadEntregada,$cantidadAcertada,'NO','$horaDeCreacion')";
        $this->database->execute($sql1);

        //Respuestas
        $arrayRespuetas = [$respuestaA,$respuestaB,$respuestaC,$respuestaD];
        $idPreg=$this->traerIDNuevaPregunta($pregunta)['id'];
        if(!empty($idPreg)){
            for($i=0; $i<=3; $i++){
                $sql2 = "INSERT INTO respuestas (id_pregunta, respuesta, esCorrecta) VALUES ($idPreg,'$arrayRespuetas[$i]',0)";
                if($correcta == $i){
                    $sql2 = "INSERT INTO respuestas (id_pregunta, respuesta, esCorrecta) VALUES ($idPreg,'$arrayRespuetas[$i]',1)";
                }
                $this->database->execute($sql2);
            }
        }else{
            var_dump("ERROR");
            exit();
        }

    }

}
?>