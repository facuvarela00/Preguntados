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
            /*PREGUNTAS: (home)
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
            $registros =$this->modelo->tabla();
            $categorias =$this->modelo->traerCategorias();
            $arrayPreguntas =$this->modelo->traerPreguntas();

            $data = array(
                'arrayPreguntas' => $arrayPreguntas,
            );
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
                $html .= '<td><a href="">Editar</a></td>';
                $html .= '<td><a href="">Eliminar</a></td>';
                $html .= '</tr>';
            }
        }else{
            $html .= '<tr>';
            $html .= '<td colspan="7">Sin Resultados</td>';
            $html .= '</tr>';
        }
        echo json_encode($html, JSON_UNESCAPED_UNICODE);
    }
}