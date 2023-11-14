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
        if($_SESSION['reportada']==1){
            $idPreg=$_SESSION['idPreguntaReportada'];
        }else{
            $idPreg=$_POST['idPregunta'];
            $idPreg=intval($idPreg);
        }

        var_dump($idPreg);

        if(isset($_POST['1'])){
            $_SESSION['puntosPartida']+=1;
            $this->modelo->preguntaAcertada($idPreg);
            $this->modelo->actualizarNivelPregunta($idPreg);
            unset($_SESSION['preguntaActual']);
            header("Location: mostrarPreguntaAleatoria");

        }else if(isset($_POST['0'])){

            $correo=$_SESSION['correo'];
            $puntajeDeLaPartida=$_SESSION['puntosPartida'];
            $this->modelo->actualizarPreguntasUsuario($correo,$puntajeDeLaPartida);
            $this->modelo->actualizarNivelPregunta($idPreg);
            $this->modelo->agregarPuntajeAMiTablaRanking($correo,$puntajeDeLaPartida);
            if($_SESSION['reportada']==1){
                printf("holaaaaa");
                $_SESSION['reportada']=0;
                header("Location:/homeJuego");
                exit();
            }
            /*$_SESSION['puntosTotalesPersonal']+=$_SESSION['puntosPartida'];*/
            header("Location:perder");
        }
    }

    public function buscarPreguntaAleatoria()
    {
        if($_SESSION['juegoIniciado']==1){

            //VARIABLES Y CONSULTAS A LA BD
            $usuario=$this->modelo->buscarUsuarioPorCorreo($_SESSION['correo']);
            
            $arrayPreguntasNivelUsuario=$this->modelo->buscarPreguntasPorNivelUsuario($usuario['nivelUsuario']);

            if(!empty($arrayPreguntasNivelUsuario)){
                $cantidadPreguntasNivelUsuario=count($arrayPreguntasNivelUsuario);
                $min=0;
                $max=$cantidadPreguntasNivelUsuario-1;
                $numeroAleatorio = rand($min, $max);
                $preguntaSeleccionada=$arrayPreguntasNivelUsuario[$numeroAleatorio];
                $this->almacenarPreguntaActual($preguntaSeleccionada['id']);
                $this->modelo->fueUtilizada($preguntaSeleccionada);
                return $preguntaSeleccionada;
            }else{
                $arrayPreguntasRestantes=$this->modelo->buscarPreguntasRestantes();
                if(!empty($arrayPreguntasRestantes)){
                    $cantidadPreguntasRestantes=count($arrayPreguntasRestantes);
                    $min=0;
                    $max=$cantidadPreguntasRestantes-1;
                    $numeroAleatorio = rand($min, $max);
                    $preguntaSeleccionadaRestante=$arrayPreguntasRestantes[$numeroAleatorio];
                    $this->almacenarPreguntaActual($preguntaSeleccionadaRestante['id']);
                    $this->modelo->fueUtilizada($preguntaSeleccionadaRestante);
                    return $preguntaSeleccionadaRestante;
                }else{
                    header("Location:ganar");
                }
            }
        }else{
            header("Location:/homeJuego");
        }
        return "";
    }

    public function mostrarPreguntaAleatoria(){
        //CONTADOR
        $tiempo_finalizacion= $this->iniciarContador();
        $tiempo_restante = max($tiempo_finalizacion - time(), 0);

        $pregunta=$this->buscarPreguntaAleatoria();
        $idCategoria=$pregunta['id_categoria'];
        $categoria = $this->modelo->buscarCategoria($idCategoria);
        $arrayRespuestas=$this->modelo->buscarRespuestas($pregunta['id']);
        $respuestas = array_map(function($item) {return $item['respuesta'];}, $arrayRespuestas);
        $respuestasCorrecta = array_map(function($item) {return $item['esCorrecta'];}, $arrayRespuestas);
        $puntosPartida= $_SESSION['puntosPartida'];
        $data = [
            'categoria' => $categoria['categoria'],
            'pregunta' => $pregunta['pregunta'],
            'idPregunta'=>$pregunta['id'],
            'respuestas' => $respuestas,
            'respuestasCorrecta' => $respuestasCorrecta,
            'puntosPartida' => $puntosPartida,
            'contador'=>$tiempo_restante
        ];
        $this->renderizado->render('/juegoIniciado', $data);
    }


    public function ganar(){
        $_SESSION['juegoIniciado']=0;
        $correo=$_SESSION['correo'];
        $puntajeDeLaPartida=$_SESSION['puntosPartida'];
        $this->modelo->actualizarPreguntasUsuario($correo,$puntajeDeLaPartida);
        $this->modelo->actualizarNivelUsuario($correo);
        $this->modelo->agregarPuntajeAMiTablaRanking($correo,$puntajeDeLaPartida);
        $this->renderizado->render("/ganar");
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

    public function iniciarContador(){
        $tiempo_inicial = time();
        $duracion = 200;
        $tiempo_finalizacion = $tiempo_inicial + $duracion;
        return $tiempo_finalizacion;
    }
    public function reportarPregunta(){
        $_SESSION['idPreguntaReportada']="";
        $pregunta = $_POST['pregunta'];
        $correo = $_SESSION['correo'];
        $result = $this->modelo->agregarReporte($pregunta, $correo);
        $idPregunta=$this->modelo->obtenerIdPregunta($pregunta);
        $idPregunta=intval($idPregunta['id']);
        $_SESSION['reportada']=1;
        $_SESSION['idPreguntaReportada']=$idPregunta;
        if($result){
            header("Location:envioExitosoReporte");
        } else{
            header("Location:/homeJuego");
        }
    }

    public function envioExitosoReporte(){
        $this->renderizado->render('/envioExitosoReporte');
    }

}
?>


