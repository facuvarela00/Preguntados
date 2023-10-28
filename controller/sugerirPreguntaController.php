<?php

class sugerirPreguntaController {
    private $modelo;
    private $renderizado;

    public function __construct($modelo, $renderizado) {
        $this->modelo = $modelo;
        $this->renderizado = $renderizado;
    }

    public function execute() {

        if(isset($_SESSION['correo'])) {
            $this->renderizado->render("/sugerirPregunta");
        }else{
            $this->renderizado->render("/login");
        }
    }
    

    public function sugerirPreguntaUsuario() {
        if (isset($_POST['preguntaSugerida'], $_POST['respuestaSugeridaA'], $_POST['respuestaSugeridaB'], $_POST['respuestaSugeridaC'], $_POST['respuestaSugeridaD'], $_POST['id_categoria'])) {
            $preguntaSugerida = $_POST['preguntaSugerida'];
            $respuestaSugeridaA = $_POST['respuestaSugeridaA'];
            $respuestaSugeridaB = $_POST['respuestaSugeridaB'];
            $respuestaSugeridaC = $_POST['respuestaSugeridaC'];
            $respuestaSugeridaD = $_POST['respuestaSugeridaD'];
            $categoria = $_POST['id_categoria'];
            $id_categoria = intval($categoria);
    
            $this->modelo->agregarSugerencia($preguntaSugerida, $respuestaSugeridaA, $respuestaSugeridaB, $respuestaSugeridaC, $respuestaSugeridaD, $id_categoria);

            header("Location: /envioExitoso");

        } else{

            header("Location: /sugerirPregunta");

        }

    
    }

}