<?php
class juegoIniciadoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function cantidadTotalDeCategorias(){

        $sql = "SELECT COUNT(*) as total_categorias FROM categorias";
        $result = $this->database->queryAssoc($sql);
        if ($result !== false) {
          $totalCategorias = $result['total_categorias'];
          return $totalCategorias;
        }else{
            return NULL;
        }

    }

    public function cantidadTotalDePreguntas(){

        $sql = "SELECT COUNT(*) as total_preguntas FROM preguntas";
        $result = $this->database->queryAssoc($sql);
        if ($result !== false) {
            $totalPreguntas = $result['total_preguntas'];
            return $totalPreguntas;
        }else{
            return NULL;
        }

    }
    public function buscarCategoria($numeroAleatorio){
        $sql = "SELECT * FROM categorias WHERE id = '$numeroAleatorio'";
        $resultado = $this->database->queryID($sql);
        return $resultado;
    }

    public function buscarPregunta($idCategoria){
        $sql = "SELECT * FROM preguntas WHERE id_categoria LIKE '$idCategoria' AND utilizada = 0";
        $result = $this->database->queryID($sql);

        if (isset($result)){
            $preguntaElegida = $this->fueUtilizada($result);
            return $preguntaElegida;
        }else{
            return "";
        }

    }


    public function fueUtilizada($preguntaSeleccionada){
            $utilizada=1;
            $idpregunta=$preguntaSeleccionada['id'];
            $sql = "UPDATE preguntas SET utilizada = '$utilizada' WHERE id = '$idpregunta'";
            $result = $this->database->execute($sql);
            return $preguntaSeleccionada;
    }

    public function buscarRespuestas($idPregunta){


        $sql = 'SELECT * FROM respuestas WHERE id_pregunta =' . $idPregunta . ';';
        $resultado = $this->database->query($sql);
        //$resultado es un arreglo multidimensional que contiene todas las filas seleccionadas de la base de datos.

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


    public function agregarReporte($textoPregunta, $usuarioCorreo)
    {
        $idPregunta = $this->obtenerIdPregunta($textoPregunta);
        $idPreguntaII = intval($idPregunta['id']);
        if (!empty($idPreguntaII) && !empty($textoPregunta) && !empty($usuarioCorreo)) {
            $sql = "INSERT INTO preguntas_reportadas (id_pregunta, mail, pregunta_reportada) VALUES ('$idPreguntaII', '$usuarioCorreo', '$textoPregunta')";
            $pregunta = $this->database->execute($sql);
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

        public function buscarPreguntaPorID($id){
            $sql = "SELECT * FROM preguntas WHERE id='$id'";
            $result=$this->database->queryID($sql);
            return $result;
        }
      public function preguntaAcertada($id){
        $pregunta= $this->buscarPreguntaPorID($id);
        $acertada=$pregunta['cantidadAcertada'];
        $acertada++;
        $sql= "UPDATE Preguntas SET cantidadAcertada = '$acertada' WHERE id = '$id'";
          $this->database->execute($sql);
    }

    public function buscarUsuarioPorCorreo($correo){
        $sql = "SELECT * FROM usuarios WHERE mail='$correo'";
        $result=$this->database->queryAssoc($sql);
        return $result;
    }
    public function actualizarPreguntasUsuario($correo,$puntajeDeLaPartida){
        $usuario=$this->buscarUsuarioPorCorreo($correo);
        $preguntasRecibidas=$usuario['preguntasRecibidas']+$puntajeDeLaPartida+1;
        $preguntasAcertadas=$usuario['preguntasAcertadas']+$puntajeDeLaPartida;

        $sql= "UPDATE usuarios SET preguntasRecibidas = '$preguntasRecibidas', preguntasAcertadas='$preguntasAcertadas' WHERE mail = '$correo'";
        $this->database->execute($sql);


    }

   /* public function actualizarDificultadPregunta($pregunta){
        $usuario=$this->buscarUsuarioPorCorreo($correo);
        $preguntasRecibidas=$usuario['preguntasRecibidas'];
        $preguntasAcertadas=$usuario['preguntasAcertadas'];

        $nivelUsuario=(100*$preguntasAcertadas)/$preguntasRecibidas;

        if($nivelUsuario>=0&&$nivelUsuario<=33){
            $nivel="poser";
        }elseif($nivelUsuario>=33&&$nivelUsuario<=66){
            $nivel="papulince";
        }else{
            $nivel="otaku";
        }
        /* 0-33 dificil / 33-66 medio /66-100 facil*/
       /* if($usuario['preguntasRecibidas']<10){
            $min=0;
            $max=10;
        }

        $sql= "UPDATE usuarios SET nivelUsuario = '$nivel' WHERE mail = '$correo'";
        $this->database->execute($sql);

    }*/
    public function actualizarNivelUsuario($correo){
        $usuario=$this->buscarUsuarioPorCorreo($correo);
        $preguntasRecibidas=$usuario['preguntasRecibidas'];
        $preguntasAcertadas=$usuario['preguntasAcertadas'];

        $nivelUsuario=(100*$preguntasAcertadas)/$preguntasRecibidas;

        if($nivelUsuario>=0&&$nivelUsuario<=33){
            $nivel="poser";
        }elseif($nivelUsuario>=33&&$nivelUsuario<=66){
            $nivel="papulince";
        }else{
            $nivel="otaku";
        }
       /* 0-33 dificil / 33-66 medio /66-100 facil*/
        if($usuario['preguntasRecibidas']<10){
            $min=0;
            $max=10;
        }





        $sql= "UPDATE usuarios SET nivelUsuario = '$nivel' WHERE mail = '$correo'";
        $this->database->execute($sql);

    }
}

?>

