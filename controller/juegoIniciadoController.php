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
        if(isset($_SESSION['correo'])) {
            $this->renderizado->render("/juegoIniciado");
        }else{
            $this->renderizado->render("/login");
        }
    }

    public function iniciarJuego(){
     $_SESSION['puntosPartida'] = 0;
     $this->modelo->reestablecerPreguntas();
     $this->mostrarPreguntaAleatoria();
     exit();
    }

    public function validarRespuesta()
    {
        if(isset($_POST['1'])){
            $_SESSION['puntosPartida']+=1;
            header("Location: mostrarPreguntaAleatoria");
        }else if(isset($_POST['0'])){
            $correo=$_SESSION['correo'];
            $puntajeDeLaPartida=$_SESSION['puntosPartida'];

            $this->modelo->agregarPuntajeAMiTablaRanking($correo,$puntajeDeLaPartida);
            /*$_SESSION['puntosTotalesPersonal']+=$_SESSION['puntosPartida'];*/
            header("Location: /perder");
        }
        exit();
    }

    public function mostrarPreguntaAleatoria()
    {
        $preguntasRealizadas=0;
        $min = 1;
        $max= $this->modelo->cantidadTotalDeCategorias();
        $totalPreguntasString= $this->modelo->cantidadTotalDePreguntas();
        $totalPreguntas = intval($totalPreguntasString);

        do{
        $numeroAleatorio = rand($min, $max);
        $categoria = $this->modelo->buscarCategoria($numeroAleatorio);
        $pregunta = $this->modelo->buscarPregunta($categoria['id']);

        if (!empty($categoria) && $pregunta!=""){
            $preguntasRealizadas+=1;

            $arrayRespuestas = $this->modelo->buscarRespuestas($pregunta['id']);
            $respuestas = array_map(function($item) {return $item['respuesta'];}, $arrayRespuestas);
            $respuestasCorrecta = array_map(function($item) {return $item['esCorrecta'];}, $arrayRespuestas);

            $puntosPartida= $_SESSION['puntosPartida'];
            $data = [
                'categoria' => $categoria['categoria'],
                'pregunta' => $pregunta['pregunta'],
                'respuestas' => $respuestas,
                'respuestasCorrecta' => $respuestasCorrecta,
                'puntosPartida' => $puntosPartida
            ];
            $this->renderizado->render('/juegoIniciado', $data);
            exit();
        }

        }while (($pregunta=="")&&($totalPreguntas!=$preguntasRealizadas));

        if ($totalPreguntas==$preguntasRealizadas){
            header("Location:/homeJuego");
        }
    }




}
?>


