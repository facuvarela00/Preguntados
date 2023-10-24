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
     exit();
    }

    public function validarRespuesta(){
        $respuesta=$_POST['name'];
        $respuestas=$this->modelo->buscarSiEsCorrecta($respuesta);

        if(buscarSiEsCorrecta){
            return true;
        }else{
            return false;
        }
    }


    public function mostrarPreguntaAleatoria()
    {
        $min = 1;
        $max = $this->modelo->cantidadTotalDeCategorias();
        $numeroAleatorio = rand($min, $max);

        $categoria = $this->modelo->buscarCategoria($numeroAleatorio);

        $pregunta = $this->modelo->buscarPregunta($categoria['id']);

        $arrayRespuestas = $this->modelo->buscarRespuestas($pregunta['id']);
        $respuestas = array_map(function($item) {return $item['respuesta'];}, $arrayRespuestas);

        if (!empty($categoria) && !empty($pregunta) && !empty($respuestas)){
            $data = [
                'categoria' => $categoria['categoria'],
                'pregunta' => $pregunta['pregunta'],
                'respuestas' => $respuestas
            ];

            $this->renderizado->render('/juegoIniciado', $data);
            exit();

        }
    }


}
?>


