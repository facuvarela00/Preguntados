<?php

class homeEditorController
{
    private $modelo;
    private $renderizado;

    public function __construct($modelo, $renderizado)
    {
        $this->modelo = $modelo;
        $this->renderizado = $renderizado;
    }

    public function execute()
    {
        if (isset($_SESSION['correo']) && (isset($_SESSION['rolActual'])) && $_SESSION['rolActual'] == 2) {
            /*
             * PREGUNTAS REPORTADAS:
             * APROBAR
             * DAR DE BAJA
             * PREGUNTAS SUGERIDAS:
             * APROBAR
             * RECHAZAR
             */
            $preguntas = $this->modelo->traerPreguntas();
            $data = [
                'preguntas' => $preguntas,
            ];
            $this->renderizado->render('/homeEditor', $data);
        } else {
            $this->renderizado->render('/login');
        }
    }

    public function editar()
    {
        if (isset($_SESSION['correo']) && (isset($_SESSION['rolActual'])) && $_SESSION['rolActual'] == 2) {
            $idPregunta = $_POST['editar'];
            $pregunta = $this->modelo->traerPregunta($idPregunta);

            $arrayRespuestas = $this->modelo->traerRespuestasDePregunta($idPregunta);
            $arrayIDS = $this->modelo->traerIDRespuestasDePregunta($idPregunta);;
            $respuestas = array_map(function ($item) {
                return $item['respuesta'];
            }, $arrayRespuestas);
            $respuestasId = array_map(function ($item) {
                return $item['id'];
            }, $arrayIDS);
            $data = [
                'pregunta' => $pregunta['pregunta'],
                'respuestas' => $respuestas,
                'respuestasId' => $respuestasId,
                'idPregunta' => $idPregunta,
            ];
            $this->renderizado->render("/editarPregunta", $data);
        } else {
            $this->renderizado->render('/login');
        }
    }

    public function eliminar()
    {
        if (isset($_SESSION['correo']) && (isset($_SESSION['rolActual'])) && $_SESSION['rolActual'] == 2) {
            $idPregunta = $_POST['eliminar'];
            $this->modelo->eliminarPregunta($idPregunta);
            header("Location:homeEditor");
        } else {
            $this->renderizado->render('/login');
        }
    }

    public function modificarPregunta()
    {
        if (isset($_POST['id']) && isset($_SESSION['correo']) && (isset($_SESSION['rolActual'])) && $_SESSION['rolActual'] == 2) {
            $idPregunta = $_POST['id'];
            $idRespuestaCorrecta = $_POST["correcta"];
            $id_categoria = $_POST["id_categoria"];
            $pregunta = $_POST["pregunta"];
            $respuestaA = $_POST["respuestaA"];
            $respuestaB = $_POST["respuestaB"];
            $respuestaC = $_POST["respuestaC"];
            $respuestaD = $_POST["respuestaD"];

            $this->modelo->modificarPreguntaRespuestas($idPregunta, $idRespuestaCorrecta, $id_categoria, $pregunta, $respuestaA, $respuestaB, $respuestaC, $respuestaD);
            header("Location: /homeEditor");
        } else {
            $this->renderizado->render('/login');
        }

    }

    public function mostrarAgregar()
    {
        if (isset($_SESSION['correo']) && (isset($_SESSION['rolActual'])) && $_SESSION['rolActual'] == 2) {
            $categorias = $this->modelo->traerCategorias();
            $dificultad = ["Facil", "Medio", "Dificil"];

            $data = [
                'categorias' => $categorias,
                'dificultad' => $dificultad,
            ];
            $this->renderizado->render("/agregarPregunta", $data);
        } else {
            $this->renderizado->render('/login');
        }
    }

    public function agregar()
    {
        if (isset($_POST['dificultad']) && isset($_SESSION['correo']) && (isset($_SESSION['rolActual'])) && $_SESSION['rolActual'] == 2) {
            $dificultad = $_POST["dificultad"];
            $id_categoria = $_POST["id_categoria"];
            $pregunta = $_POST["pregunta"];
            $respuestaA = $_POST["respuestaA"];
            $respuestaB = $_POST["respuestaB"];
            $respuestaC = $_POST["respuestaC"];
            $respuestaD = $_POST["respuestaD"];
            $correcta = $_POST["correcta"];

            $this->modelo->agregarPreguntaRespuestas($id_categoria, $pregunta, $respuestaA, $respuestaB, $respuestaC, $respuestaD, $dificultad, $correcta);
            header("Location: /homeEditor");
        } else {
            $this->renderizado->render('/login');
        }
    }

    public function mostrarPreguntasSugeridas()
    {
        if (isset($_POST['dificultad']) && isset($_SESSION['correo']) && (isset($_SESSION['rolActual'])) && $_SESSION['rolActual'] == 2) {
            /*
            $categorias = $this->modelo->traerCategorias();
            $dificultad = ["Facil", "Medio", "Dificil"];

            $data = [
                'categorias' => $categorias,
                'dificultad' => $dificultad,
            ];

            $this->renderizado->render("/preguntasReportadas", $data);
            */
        } else {
            $this->renderizado->render('/login');
        }

    }

    public function mostrarPreguntasReportadas()
    {
        if (isset($_POST['dificultad']) && isset($_SESSION['correo']) && (isset($_SESSION['rolActual'])) && $_SESSION['rolActual'] == 2) {
            /*
            $categorias = $this->modelo->traerCategorias();
            $dificultad = ["Facil", "Medio", "Dificil"];

            $data = [
                'categorias' => $categorias,
                'dificultad' => $dificultad,
            ];

            $this->renderizado->render("/preguntasReportadas", $data);
            */
        } else {
            $this->renderizado->render('/login');
        }

    }

}