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
            header ("Location:/homeJuego");
        }else{
            $this->renderizado->render("/login");
        }
    }

    public function iniciarJuego()
    {
        $_SESSION['juegoIniciado']=1;
        $_SESSION['puntosPartida'] = 0;
        unset($_SESSION['preguntaActual']);
        $this->modelo->reestablecerPreguntas();
        header("Location:mostrarPreguntaAleatoria");
        exit();
    }

    public function validarRespuesta()
    {
        if(isset($_POST['1'])){
            $_SESSION['puntosPartida']+=1;
            unset($_SESSION['preguntaActual']);
            header("Location: mostrarPreguntaAleatoria");
        }else if(isset($_POST['0'])){

            $correo=$_SESSION['correo'];
            $puntajeDeLaPartida=$_SESSION['puntosPartida'];
            $this->modelo->agregarPuntajeAMiTablaRanking($correo,$puntajeDeLaPartida);
            /*$_SESSION['puntosTotalesPersonal']+=$_SESSION['puntosPartida'];*/
            header("Location:perder");
        }
    }

    public function mostrarPreguntaAleatoria()
    {
        if($_SESSION['juegoIniciado']==1){
            $preguntasRealizadas=0;
            $min = 1;
            $max= $this->modelo->cantidadTotalDeCategorias();
            $totalPreguntasString= $this->modelo->cantidadTotalDePreguntas();
            $totalPreguntas = intval($totalPreguntasString);
            do{
                $numeroAleatorio = rand($min, $max);
                $categoria = $this->modelo->buscarCategoria($numeroAleatorio);
                $pregunta = $this->modelo->buscarPregunta($categoria['id']);
                if ($pregunta!=""){
                $this->almacenarPreguntaActual($pregunta['id']);
                }
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
        }else{
            header("Location:/homeJuego");
        }

    }
    public function perder(){
        $_SESSION['juegoIniciado']=0;
        $this->renderizado->render("/perder");
    }

    public function almacenarPreguntaActual($pregunta){
        if (isset($_SESSION['preguntaActual'])&&$_SESSION['preguntaActual']!=$pregunta){
            header("Location:perder");
        }elseif(!(isset($_SESSION['preguntaActual']))){
            $_SESSION['preguntaActual']=$pregunta;
        }
    }

}
?>


