<?php

class homeAdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    ////////////////////////////////BUSQUEDA Y VER USUARIOS///////////////////////////////////////
    public function buscarUsuarioPorCorreo($correo)
    {
        $sql = "SELECT * FROM usuarios WHERE mail='$correo'";
        $resultado = $this->database->queryAssoc($sql);
        return $resultado;
    }

    public function verUsuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $resultado = $this->database->query($sql);

        return $resultado;
    }

    public function verUsuariosNuevos()
    {
        //NOSE A QUE SE REFIERE//
    }

    public function verCantidadUsuarios()
    {
        $sql = "SELECT COUNT(*) as total FROM usuarios";
        $resultado = $this->database->queryAssoc($sql);
        return intval($resultado['total']);
    }

    public function verCantidadUsuariosPorPais($tipoDeFiltro)
    {
        if ($tipoDeFiltro != "todo") {
            $sql = $this->filtroPais($tipoDeFiltro);
        } else {
            $sql = "SELECT username,pais FROM usuarios";
        }
        $resultado = $this->database->query($sql);
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

    public function verCantidadUsuariosPorGenero($tipoDeFiltro)
    {
        if ($tipoDeFiltro != "todo") {
            $sql = $this->filtroGenero($tipoDeFiltro);
        } else {
            $sql = "SELECT username,genero FROM usuarios";
        }

        $resultado = $this->database->query($sql);
        $contadores = array();
        foreach ($resultado as $row) {
            $genero = $row['genero'];
            if (!isset($contadores[$genero])) {
                $contadores[$genero] = 1;
            } else {
                $contadores[$genero]++;
            }
        }
        return $contadores;
    }

    public function verCantidadUsuariosPorGrupoEdad($tipoDeFiltro)
    {
        if ($tipoDeFiltro != "todo") {
            $sql = $this->filtroGrupoEdad($tipoDeFiltro);
        } else {
            $sql = "SELECT fechaNac FROM usuarios";
        }

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

    private function calcularEdad($fechaNacimiento)
    {
        $fechaNacimiento = new DateTime($fechaNacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNacimiento);
        return $edad->y; // 'y' representa el número de años en la diferencia
    }

    public function verCantidadPartidasJugadas()
    {
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

    public function desactivarCuenta($correo)
    {
        $sql = "UPDATE usuarios SET activo = 'NO' WHERE mail = '$correo'";
        $resultado = $this->database->execute($sql);
    }

    ////////////////////////////////BUSQUEDA Y VER PREGUNTAS///////////////////////////////////////
    public function verPreguntas()
    {
        $sql = "SELECT * FROM preguntas";
        $resultado = $this->database->query($sql);
        return $resultado;
    }

    public function verCantidadPreguntas()
    {
        $sql = "SELECT COUNT(*) as total FROM preguntas";
        $resultado = $this->database->queryAssoc($sql);
        return intval($resultado['total']);
    }

    public function verCantidadPreguntasPorCategoria($tipoDeFiltro)
    {
        if ($tipoDeFiltro != "todo") {
            $sql = $this->filtroPreguntasPorCategoria($tipoDeFiltro);
        } else {
            $sql = "SELECT categoria FROM preguntas P LEFT JOIN categorias C ON P.id_categoria = C.id";
        }

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

    ////////////////////////////////GRAFICOS USUARIO///////////////////////////////////////

    public function acertadasPorUsuario($usuario)
    {
        $usuarioEncontrado = $this->buscarUsuarioPorCorreo($usuario);
        $recibidas = intval($usuarioEncontrado['preguntasRecibidas']);
        $acertadas = intval($usuarioEncontrado['preguntasAcertadas']);
        $erradas = $recibidas - $acertadas;
        $datos = [
            'acertadas' => $acertadas,
            'erradas' => $erradas,
        ];
        if ($recibidas == 0) {
            return "no-data.png";
        }
        return $this->graficoPorcentajeAcertadasPorUsuario($usuario, $datos);
    }

    public function graficoPorcentajeAcertadasPorUsuario($usuario, $datos)
    {
        $resultado = $datos;

        $grafico = new PieGraph(600, 400);
        $grafico->title->Set($usuario);
        $datosTorta = array_values($resultado);
        $etiquetas = array_keys($resultado);
        $torta = new PiePlot($datosTorta);
        $torta->SetLegends($etiquetas);
        $grafico->Add($torta);

        $rutaCarpeta = "C:/xampp/htdocs/public/graficos/";
        $nombreArchivo = 'grafico_porcentaje_acertadas_por_usuario.png';
        $rutaFinal = $rutaCarpeta . $nombreArchivo;

        if (file_exists($rutaFinal)) {
            unlink($rutaFinal);
        }
        $grafico->Stroke($rutaFinal);

        return $nombreArchivo;
    }

    public function graficoCantidadUsuariosPorPais($tipoDeFiltro)
    {
        $resultado = $this->verCantidadUsuariosPorPais($tipoDeFiltro);

        if (empty($resultado)) {
            return "no-data.png";
        }
        $grafico = new PieGraph(600, 400);
        $grafico->title->Set("Usuarios por Pais");
        $datosTorta = array_values($resultado);
        $etiquetas = array_keys($resultado);
        $torta = new PiePlot($datosTorta);
        $torta->SetLegends($etiquetas);
        $grafico->Add($torta);

        $rutaCarpeta = "C:/xampp/htdocs/public/graficos/";
        $nombreArchivo = 'grafico_usuarios_por_pais.png';
        $rutaFinal = $rutaCarpeta . $nombreArchivo;

        if (file_exists($rutaFinal)) {
            unlink($rutaFinal);
        }

        $grafico->Stroke($rutaFinal);

        return $nombreArchivo;
    }

    public function graficoCantidadUsuariosPorGenero($tipoDeFiltro)
    {
        $resultado = $this->verCantidadUsuariosPorGenero($tipoDeFiltro);

        if (empty($resultado)) {
            return "no-data.png";
        }
        $grafico = new PieGraph(600, 400);
        $grafico->title->Set("Usuarios por Genero");
        $datosTorta = array_values($resultado);
        $etiquetas = array_keys($resultado);
        $torta = new PiePlot($datosTorta);
        $torta->SetLegends($etiquetas);
        $grafico->Add($torta);

        $rutaCarpeta = "C:/xampp/htdocs/public/graficos/";
        $nombreArchivo = 'grafico_usuarios_por_genero.png';
        $rutaFinal = $rutaCarpeta . $nombreArchivo;

        if (file_exists($rutaFinal)) {
            unlink($rutaFinal);
        }

        $grafico->Stroke($rutaFinal);

        return $nombreArchivo;
    }

    public function graficoCantidadUsuariosPorGrupoEdad($tipoDeFiltro)
    {
        $resultado = $this->verCantidadUsuariosPorGrupoEdad($tipoDeFiltro);

        if (empty($resultado)) {
            return "no-data.png";
        }
        $grafico = new PieGraph(600, 400);
        $grafico->title->Set("Usuarios por Grupo Edad");
        $datosTorta = array_values($resultado);
        $etiquetas = array_keys($resultado);
        $torta = new PiePlot($datosTorta);
        $torta->SetLegends($etiquetas);
        $grafico->Add($torta);

        $rutaCarpeta = "C:/xampp/htdocs/public/graficos/";
        $nombreArchivo = 'grafico_usuarios_por_grupo_edad.png';
        $rutaFinal = $rutaCarpeta . $nombreArchivo;

        if (file_exists($rutaFinal)) {
            unlink($rutaFinal);
        }

        $grafico->Stroke($rutaFinal);

        return $nombreArchivo;
    }

    ////////////////////////////////GRAFICOS PREGUNTAS///////////////////////////////////////

    public function graficoPreguntasPorCategoria($tipoDeFiltro)
    {
        $resultado = $this->verCantidadPreguntasPorCategoria($tipoDeFiltro);

        if (empty($resultado)) {
            return "no-data.png";
        }

        $grafico = new PieGraph(600, 400);
        $grafico->title->Set("Preguntas por Categoría");
        $datosTorta = array_values($resultado);
        $etiquetas = array_keys($resultado);
        $torta = new PiePlot($datosTorta);
        $torta->SetLegends($etiquetas);
        $grafico->Add($torta);

        $rutaCarpeta = "C:/xampp/htdocs/public/graficos/";
        $nombreArchivo = 'grafico_preguntas_por_categoria.png';
        $rutaFinal = $rutaCarpeta . $nombreArchivo;

        if (file_exists($rutaFinal)) {
            unlink($rutaFinal);
        }

        $grafico->Stroke($rutaFinal);

        return $nombreArchivo;
    }

////////////////////////////////FILTROS USUARIO///////////////////////////////////////

    public function filtroGrupoEdad($tipoDeFiltro)
    {
        $fechaActual = date("Y-m-d");
        switch ($tipoDeFiltro) {
            case 'dia':
                $sql = "SELECT fechaNac FROM usuarios WHERE DATE(horaRegistro) = '$fechaActual'";
                break;
            case 'semana':
                $fechaInicioSemana = date("Y-m-d", strtotime('last Monday', strtotime($fechaActual)));
                $sql = "SELECT fechaNac FROM usuarios WHERE DATE(horaRegistro) >= '$fechaInicioSemana'";
                break;
            case 'mes':
                $fechaInicioMes = date("Y-m-01");
                $sql = "SELECT fechaNac FROM usuarios WHERE DATE(horaRegistro) >= '$fechaInicioMes'";
                break;
            case 'año':
                $añoActual = date("Y");
                $sql = "SELECT fechaNac FROM usuarios WHERE YEAR(horaRegistro) = '$añoActual'";
                break;
            default:
                $sql = "SELECT fechaNac FROM usuarios";
                break;
        }
        return $sql;

    }
    public function filtroGenero($tipoDeFiltro)
    {
        $fechaActual = date("Y-m-d");
        switch ($tipoDeFiltro) {
            case 'dia':
                $sql = "SELECT username,genero FROM usuarios WHERE DATE(horaRegistro) = '$fechaActual'";
                break;
            case 'semana':
                $fechaInicioSemana = date("Y-m-d", strtotime('last Monday', strtotime($fechaActual)));
                $sql = "SELECT username,genero FROM usuarios WHERE DATE(horaRegistro) >= '$fechaInicioSemana'";
                break;
            case 'mes':
                $fechaInicioMes = date("Y-m-01");
                $sql = "SELECT username,genero FROM usuarios WHERE DATE(horaRegistro) >= '$fechaInicioMes'";
                break;
            case 'año':
                $añoActual = date("Y");
                $sql = "SELECT username,genero FROM usuarios WHERE YEAR(horaRegistro) = '$añoActual'";
                break;
            default:
                $sql = "SELECT username,genero FROM usuarios";
                break;
        }
        return $sql;

    }
    public function filtroPais($tipoDeFiltro)
    {
        $fechaActual = date("Y-m-d");
        switch ($tipoDeFiltro) {
            case 'dia':
                $sql = "SELECT username,pais FROM usuarios WHERE DATE(horaRegistro) = '$fechaActual'";
                break;
            case 'semana':
                $fechaInicioSemana = date("Y-m-d", strtotime('last Monday', strtotime($fechaActual)));
                $sql = "SELECT username,pais FROM usuarios WHERE DATE(horaRegistro) >= '$fechaInicioSemana'";
                break;
            case 'mes':
                $fechaInicioMes = date("Y-m-01");
                $sql = "SELECT username,pais FROM usuarios WHERE DATE(horaRegistro) >= '$fechaInicioMes'";
                break;
            case 'año':
                $añoActual = date("Y");
                $sql = "SELECT username,pais FROM usuarios WHERE YEAR(horaRegistro) = '$añoActual'";
                break;
            default:
                $sql = "SELECT username,pais FROM usuarios";
                break;
        }
        return $sql;

    }

    public function buscarUsuariosNuevos(){
        $fechaActual = date("Y-m-d");
        $sql = "SELECT id,mail FROM usuarios WHERE DATE(horaRegistro) = '$fechaActual'";
        $resultado = $this->database->query($sql);

        return $resultado;
    }
////////////////////////////////FILTROS PREGUNTAS///////////////////////////////////////

    public function filtroPreguntasPorCategoria($tipoDeFiltro)
    {
        $fechaActual = date("Y-m-d");
        switch ($tipoDeFiltro) {
            case 'dia':
                $sql = "SELECT categoria FROM preguntas P LEFT JOIN categorias C ON P.id_categoria = C.id WHERE DATE(horaCreacion) = '$fechaActual'";
                break;
            case 'semana':
                $fechaInicioSemana = date("Y-m-d", strtotime('last Monday', strtotime($fechaActual)));
                $sql = "SELECT categoria FROM preguntas P LEFT JOIN categorias C ON P.id_categoria = C.id WHERE DATE(horaCreacion) >= '$fechaInicioSemana'";
                break;
            case 'mes':
                $fechaInicioMes = date("Y-m-01");
                $sql = "SELECT categoria FROM preguntas P LEFT JOIN categorias C ON P.id_categoria = C.id WHERE DATE(horaCreacion) >= '$fechaInicioMes'";
                break;
            case 'año':
                $añoActual = date("Y");
                $sql = "SELECT categoria FROM preguntas P LEFT JOIN categorias C ON P.id_categoria = C.id WHERE YEAR(horaCreacion) = '$añoActual'";
                break;
            default:
                $sql = "SELECT categoria FROM preguntas P LEFT JOIN categorias C ON P.id_categoria = C.id";
                break;
        }
        return $sql;

    }

    public function verPreguntasCreadasRecientemente()
    {
        $fechaCreacion ='2023-11-15 12:20:51';

        $sql = "SELECT * FROM preguntas WHERE DATE(horaCreacion) >= '$fechaCreacion'";
        $resultado = $this->database->query($sql);

        return $resultado;
    }

}
?>
