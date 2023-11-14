<?php

class sugerirPreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function agregarSugerencia($preguntaSugerida, $respuestaSugeridaA, $respuestaSugeridaB, $respuestaSugeridaC, $respuestaSugeridaD, $id_categoria, $id_dificultad){

        $sql = "INSERT INTO sugeridas(preguntaSugerida, respuestaSugeridaA, respuestaSugeridaB, respuestaSugeridaC, respuestaSugeridaD, id_categoria, id_dificultad) 
        VALUES ('$preguntaSugerida', '$respuestaSugeridaA', '$respuestaSugeridaB', '$respuestaSugeridaC', '$respuestaSugeridaD', '$id_categoria', '$id_dificultad')";

        $pregunta = $this->database->execute($sql);

    }




}