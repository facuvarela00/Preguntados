<?php

class homeAdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function buscarUsuarioPorCorreo($correo){
        $sql="SELECT * FROM usuarios WHERE mail='$correo'";
        $resultado=$this->database->queryAssoc($sql);
        return $resultado;
    }
    public function verUsuarios(){
        $sql="SELECT * FROM usuarios";
        $resultado=$this->database->query($sql);

        return $resultado;
    }
    public function verUsuariosNuevos(){
        //NOSE A QUE SE REFIERE//
    }
    public function verCantidadUsuarios(){
        $sql="SELECT COUNT(*) as total FROM usuarios";
        $resultado=$this->database->queryAssoc($sql);
        return intval($resultado['total']);
    }
    public function verCantidadUsuariosPorPais(){
        $sql="SELECT username,pais FROM usuarios";
        $resultado=$this->database->query($sql);
        $contadores = array();
        foreach ($resultado as $row) {
            $pais = $row['pais'];
            if (!isset($contadores[$pais])) {
                $contadores[$pais] = 1;
            } else {
                $contadores[$pais]++;
            }
        }
        return $contadores;
    }
    public function verCantidadUsuariosPorGenero(){
        $sql="SELECT username,genero FROM usuarios";
        $resultado=$this->database->query($sql);
        $contadores = array();
        foreach ($resultado as $row) {
            $genero= $row['genero'];
            if (!isset($contadores[$genero])) {
                $contadores[$genero] = 1;
            } else {
                $contadores[$genero]++;
            }
        }
        return $contadores;
    }
    public function verCantidadUsuariosPorGrupoEdad() {
        $sql = "SELECT fechaNac FROM usuarios";
        $resultado = $this->database->query($sql);

        $contadores = [
            'joven' => 0,
            'adulto' => 0,
            'anciano' => 0
        ];
        foreach ($resultado as $row) {
            $edad = $this->calcularEdad($row['fechaNac']);
            if ($edad <= 25) {
                $contadores['joven']++;
            } elseif ($edad <= 50) {
                $contadores['adulto']++;
            } else {
                $contadores['anciano']++;
            }
        }
        return $contadores;
    }

    private function calcularEdad($fechaNacimiento) {
        $fechaNacimiento = new DateTime($fechaNacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNacimiento);
        return $edad->y; // 'y' representa el número de años en la diferencia
    }
    public function verCantidadPartidasJugadas(){
        $sql = "SELECT puntajesPorPartida FROM ranking";
        $resultado = $this->database->query($sql);
        $totalPartidas = 0;

        foreach ($resultado as $fila) {
            $puntajes = json_decode($fila['puntajesPorPartida']);
            if (is_array($puntajes)) {
                $totalPartidas += count($puntajes);
            }
        }
        return $totalPartidas;
    }
    public function verPreguntas(){
        $sql="SELECT * FROM preguntas";
        $resultado=$this->database->query($sql);
        return $resultado;
    }
    public function verCantidadPreguntas(){
        $sql="SELECT COUNT(*) as total FROM preguntas";
        $resultado=$this->database->queryAssoc($sql);
        return intval($resultado['total']);
    }
    public function verCantidadPreguntasPorCategoria(){
        $sql = "SELECT categoria FROM preguntas P LEFT JOIN categorias C ON P.id_categoria = C.id";
        $resultado = $this->database->query($sql);

        $contadores = array();
        foreach ($resultado as $row) {
            $categoria = $row['categoria'];
            if (!isset($contadores[$categoria])) {
                $contadores[$categoria] = 1;
            } else {
                $contadores[$categoria]++;
            }
        }
        return $contadores;
    }

    public function verCantidadPreguntasCreadas(){
        /* NOSE A QUE SE REFIERE */
    }

}

?>
