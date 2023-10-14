<?php
class juegoIniciadoController{
    private $modelo;
    private $renderizado;

    public function __construct($modelo, $renderizado)
    {
        $this->modelo = $modelo;
        $this->renderizado = $renderizado;
    }

    public function execute(){
        $error = "";
        $this->renderizado->render("/juegoIniciado");
    }

    public function iniciarJuego(){
     $this->mostrarPreguntaAleatoria();
    }

    public function validarRespuesta(){
        $respuesta=$_POST['name_respuesta'];
        $respuestas=$this->modelo->buscarSiEsCorrecta($respuesta);

        if(buscarSiEsCorrecta){
            return true;
        }else{
            return false;
        }
    }

    public function mostrarPreguntaAleatoria(){
        $random=N;
        $categoria=$this->modelo->buscarCategoria($random);
        $primeraPregunta=$this->modelo->buscarPreguntas($categoria);
        $primeraPregunta=$this->modelo->buscarRespuestas($primeraPregunta);
    }


}
?>


