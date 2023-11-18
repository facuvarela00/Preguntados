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
        if (isset($_SESSION['correo'])&&(isset($_SESSION['rolActual']))&&$_SESSION['rolActual']==2){
            /*PREGUNTAS: (home) - LISTO
             * DAR DE ALTA
             * DAR DE BAJA
             * MODIFICAR
             * PREGUNTAS REPORTADAS:
             * APROBAR
             * DAR DE BAJA
             * PREGUNTAS SUGERIDAS:
             * APROBAR
             * RECHAZAR
             */
            //$registros =$this->modelo->tabla(); //XD Falla
            //$categorias =$this->modelo->traerCategorias();
            $preguntas =$this->modelo->traerPreguntas();
            $data = [
               'preguntas' => $preguntas,
            ];
            $this->renderizado->render('/homeEditor', $data);
        }
        else{
             $this->renderizado->render('/login');
        }
    }

    PUBLIC FUNCTION mostrarTabla(){
        $registros =$this->modelo->tabla();
        $html='';

        if(!empty($registros)){
            while($row = $registros){
                $html .= '<tr>';
                $html .= '<td>'. $row['id'] .'</td>';
                $html .= '<td>'. $row['categoria'] .'</td>';
                $html .= '<td>'. $row['pregunta'] .'</td>';
                $html .= '<td><a href="/editarPreguntaController">Editar</a></td>';
                $html .= '<td><a href="/homeEditor/Eliminar">Eliminar</a></td>';
                $html .= '</tr>';
            }
        }else{
            $html .= '<tr>';
            $html .= '<td colspan="7">Sin Resultados</td>';
            $html .= '</tr>';
        }
        echo json_encode($html, JSON_UNESCAPED_UNICODE);
    }

   public function editar(){
        if (isset($_SESSION['correo'])&&(isset($_SESSION['rolActual']))&&$_SESSION['rolActual']==2){
            $idPregunta = $_POST['editar'];
            $pregunta =$this->modelo->traerPregunta($idPregunta);
            $arrayRespuestas = $this->modelo->traerRespuestasDePregunta($idPregunta);
            $arrayIDS=$this->modelo->traerIDRespuestasDePregunta($idPregunta);;
            $respuestas= array_map(function($item) {return $item['respuesta'];}, $arrayRespuestas);
            $respuestasId= array_map(function($item) {return $item['id'];}, $arrayIDS);
            $data = [
                'pregunta' => $pregunta['pregunta'],
                'respuestas' => $respuestas,
                'respuestasId' => $respuestasId,
                'idPregunta' => $idPregunta,
            ];
            $this->renderizado->render("/editarPregunta", $data);
        }
        else{
            $this->renderizado->render('/login');
        }
    }

    public function eliminar(){
        if (isset($_SESSION['correo'])&&(isset($_SESSION['rolActual']))&&$_SESSION['rolActual']==2){
            $idPregunta = $_POST['eliminar'];
            $this->modelo->eliminarPregunta($idPregunta);
            header("Location:homeEditor");
        }
        else{
            $this->renderizado->render('/login');
        }
    }

    public function modificarPregunta()
    {
        if (isset($_POST['id']) && isset($_SESSION['correo'])&&(isset($_SESSION['rolActual']))&&$_SESSION['rolActual']==2) {
            $idPregunta = $_POST['id'];
            $idRespuestaCorrecta = $_POST["correcta"];
            $id_categoria = $_POST["id_categoria"];
            $pregunta = $_POST["pregunta"];
            $respuestaA = $_POST["respuestaA"];
            $respuestaB = $_POST["respuestaB"];
            $respuestaC = $_POST["respuestaC"];
            $respuestaD = $_POST["respuestaD"];

            $this->modelo->modificarPreguntaRespuestas($idPregunta,$idRespuestaCorrecta,$id_categoria,$pregunta,$respuestaA,$respuestaB,$respuestaC,$respuestaD);
            header("Location: /homeEditor");
        }else{
            $this->renderizado->render('/login');
        }

    }
}