<?php

class sugerirPreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function agregarSugerencia($preguntaSugerida, $respuestaSugeridaA, $respuestaSugeridaB, $respuestaSugeridaC, $respuestaSugeridaD, $id_categoria,$nivelPregunta){

        if($nivelPregunta=='FACIL'){
            $dificultadEnviar=20;
        }elseif($nivelPregunta=='MEDIO'){
            $dificultadEnviar=47;
        }else{
            $dificultadEnviar=80;
        }

        $sql = "INSERT INTO sugeridas(preguntaSugerida, respuestaSugeridaA, respuestaSugeridaB, respuestaSugeridaC, respuestaSugeridaD, id_categoria, nivelPregunta) 
        VALUES ('$preguntaSugerida', '$respuestaSugeridaA', '$respuestaSugeridaB', '$respuestaSugeridaC', '$respuestaSugeridaD', '$id_categoria', '$$dificultadEnviar')";

        $pregunta = $this->database->execute($sql);

    }






}