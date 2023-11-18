<?php
class juegoIniciadoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function buscarCategoria($numeroAleatorio){
        $sql = "SELECT * FROM categorias WHERE id = '$numeroAleatorio'";
        $resultado = $this->database->queryID($sql);
        return $resultado;
    }

    public function buscarPreguntaPorID($id){
        $sql = "SELECT * FROM preguntas WHERE id='$id'";
        $result=$this->database->queryID($sql);
        return $result;
    }

    public function buscarUsuarioPorCorreo($correo){
        $sql = "SELECT * FROM usuarios WHERE mail='$correo'";
        $result=$this->database->queryAssoc($sql);
        return $result;
    }
    public function buscarPreguntasPorNivelUsuario($nivelUsuario){

        if ($nivelUsuario=='Noob'){
            $sql = "SELECT * FROM preguntas WHERE utilizada = 0 AND nivelPregunta='Facil'";
        }elseif($nivelUsuario=='Pro'){
            $sql = "SELECT * FROM preguntas WHERE utilizada = 0 AND nivelPregunta='Dificil'";
        }else{
            $sql = "SELECT * FROM preguntas WHERE utilizada = 0 AND nivelPregunta='Medio'";
        }

        $result = $this->database->query($sql);
        return $result;

    }
    public function buscarPreguntasRestantes(){
        $sql = "SELECT * FROM preguntas WHERE utilizada = 0";
        $result = $this->database->queryID($sql);
        return $result;
    }


    public function fueUtilizada($preguntaSeleccionada){
            $utilizada=1;
            $idpregunta=$preguntaSeleccionada['id'];
            $sql = "UPDATE preguntas SET utilizada = '$utilizada' WHERE id = '$idpregunta'";
            $result = $this->database->execute($sql);
            $this->preguntaEntregada($preguntaSeleccionada);
            return $preguntaSeleccionada;
    }

    public function buscarRespuestas($idPregunta){

        $sql = 'SELECT * FROM respuestas WHERE id_pregunta =' . $idPregunta . ';';
        $resultado = $this->database->query($sql);

        return $resultado;
    }

    public function reestablecerPreguntas(){
        $sql = "SELECT * FROM preguntas WHERE utilizada=1";
        $result = $this->database->query($sql);
        foreach ($result as $preguntaSeleccionada){
            $this->noFueUtilizada($preguntaSeleccionada['id']);
        }
    }

    public function noFueUtilizada($idPregunta){
        $sql = "UPDATE preguntas SET utilizada = 0 WHERE id = '$idPregunta'";
        $result = $this->database->execute($sql);
    }
    public function agregarPuntajeAMiTablaRanking($correo,$puntajeDeLaPartida)
    {
        $sql = "SELECT puntajesPorPartida FROM Ranking WHERE mail = '$correo'";
        $result = $this->database->queryAssoc($sql);
        $puntajesActuales = json_decode($result['puntajesPorPartida'], true);
            if ($puntajesActuales === 0) {
                $puntajesActuales = [];
            }
        $puntajesActuales[] = $puntajeDeLaPartida;
        $puntajesActualizados = json_encode($puntajesActuales);
        $puntajeTotal = array_sum($puntajesActuales);

        $sqlUpdate = "UPDATE Ranking SET puntajesPorPartida = '$puntajesActualizados' WHERE mail = '$correo'";
        $sqlUpdate2 = "UPDATE Ranking SET puntajeTotal = '$puntajeTotal' WHERE mail = '$correo'";
        $this->database->execute($sqlUpdate);
        $this->database->execute($sqlUpdate2);
    }

    public function obtenerIdPregunta($pregunta) {
        $sql = "SELECT id FROM preguntas WHERE pregunta = '$pregunta' ";
        $result = $this->database->queryAssoc($sql);

        return $result;
    }

    public function buscarPreguntaAssoc($id) {
        $sql = "SELECT * FROM preguntas WHERE id = '$id'";
        $result = $this->database->queryAssoc($sql);

        return $result;
    }


    public function agregarReporte($textoPregunta, $usuarioCorreo)
    {
        $idPregunta = $this->obtenerIdPregunta($textoPregunta);
        $idPreguntaII = intval($idPregunta['id']);
        $pregunta=$this->buscarPreguntaAssoc($idPreguntaII);

        if ($pregunta['reportada']=='NO') {
            $sql = "UPDATE preguntas SET reportada = 'SI' WHERE id = '$idPreguntaII'";
            $this->database->execute($sql);
            return true;
        } else {
            return false;
        }
    }
        public function preguntaEntregada($pregunta){
            $id=$pregunta['id'];
            $cantidadEntregada=$pregunta['cantidadEntregada'];
            $cantidadEntregada ++;
            $sql= "UPDATE Preguntas SET cantidadEntregada = '$cantidadEntregada' WHERE id = '$id'";
            $this->database->execute($sql);
        }


      public function preguntaAcertada($id){
        $pregunta= $this->buscarPreguntaPorID($id);
        $acertada=$pregunta['cantidadAcertada'];
        $acertada++;
        $sql= "UPDATE Preguntas SET cantidadAcertada = '$acertada' WHERE id = '$id'";
        $this->database->execute($sql);
    }

    public function actualizarPreguntasUsuario($correo,$puntajeDeLaPartida){
        $usuario=$this->buscarUsuarioPorCorreo($correo);
        $preguntasRecibidas=$usuario['preguntasRecibidas']+$puntajeDeLaPartida+1;
        $preguntasAcertadas=$usuario['preguntasAcertadas']+$puntajeDeLaPartida;

        $sql= "UPDATE usuarios SET preguntasRecibidas = '$preguntasRecibidas', preguntasAcertadas='$preguntasAcertadas' WHERE mail = '$correo'";
        $this->database->execute($sql);

        $this->actualizarNivelUsuario($correo);
    }

    public function actualizarNivelUsuario($correo){
        $usuario=$this->buscarUsuarioPorCorreo($correo);
        $preguntasRecibidas=$usuario['preguntasRecibidas'];
        $preguntasAcertadas=$usuario['preguntasAcertadas'];

        $nivelUsuario=(100*$preguntasAcertadas)/$preguntasRecibidas;

        if($preguntasRecibidas>15){
            if($nivelUsuario>67&&$nivelUsuario<=100){
                $nivel="Pro";
            }elseif($nivelUsuario>33&&$nivelUsuario<=67){
                $nivel="Avanzado";
            }else{
                $nivel="Noob";
            }
        }else{
            $nivel="Noob";
        }


        $sql= "UPDATE usuarios SET nivelUsuario = '$nivel' WHERE mail = '$correo'";
        $this->database->execute($sql);
    }

    public function actualizarNivelPregunta($idPregunta){
        $pregunta= $this->buscarPreguntaPorID($idPregunta);
        $cantidadEntregada=$pregunta['cantidadEntregada'];
        $cantidadAcertada=$pregunta['cantidadAcertada'];

        $nivelPregunta=(100*$cantidadAcertada)/$cantidadEntregada;


            if($nivelPregunta>67&&$nivelPregunta<=100){
                $nivel="Facil";
            }elseif($nivelPregunta>33&&$nivelPregunta<=67){
                $nivel="Medio";
            }else{
                $nivel="Dificil";
            }

        $sql= "UPDATE preguntas SET nivelPregunta='$nivel' WHERE id='$idPregunta'";
        $this->database->execute($sql);

    }


}

?>

