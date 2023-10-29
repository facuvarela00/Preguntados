<?php

class sugerirPreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function agregarSugerencia($preguntaSugerida, $respuestaSugeridaA, $respuestaSugeridaB, $respuestaSugeridaC, $respuestaSugeridaD, $id_categoria){

        $sql = "INSERT INTO sugeridas(preguntaSugerida, respuestaSugeridaA, respuestaSugeridaB, respuestaSugeridaC, respuestaSugeridaD, id_categoria) 
        VALUES ('$preguntaSugerida', '$respuestaSugeridaA', '$respuestaSugeridaB', '$respuestaSugeridaC', '$respuestaSugeridaD', '$id_categoria')";

        $pregunta = $this->database->execute($sql);

    }




}