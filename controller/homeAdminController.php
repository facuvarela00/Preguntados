<?php

class homeAdminController
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
        if (isset($_SESSION['correo'])&&(isset($_SESSION['rolActual']))&&$_SESSION['rolActual']==1){
           $this->usuarios();
           exit();
        }
        else{
            $this->renderizado->render('/login');
        }
    }

    public function usuarios(){
        /*$usuarios= $this->modelo->verUsuarios();*/

        /*$graficoAcertadasPorUsuario=$this->graficoAcertadasPorUsuario();*/

        /*$graficoCantidadUsuariosPorPais=$this->graficoCantidadUsuariosPorPais()*/

        /*$graficoCantidadUsuariosPorGenero=$this->graficoCantidadUsuariosPorGenero()*/

        /*$graficoCantidadUsuariosPorGrupoEdad=$this->$graficoCantidadUsuariosPorGrupoEdad()*/

        $this->renderizado->render('/usuariosDB');
        exit();
    }
    public function preguntas(){

        /*$preguntas=$this->modelo->verPreguntas();*/

        /*$cantidadTotalPreguntas=$this->modelo->verCantidadPreguntas();*/

        /*$graficoPreguntasPorCategoria=$this->graficoPreguntasPorCategoria();*/ //ERROR

        $this->renderizado->render('/preguntasDB',['graficoPreguntasPorCategoria' => $graficoPreguntasPorCategoria]);
    }

    public function graficoAcertadasPorUsuario(){
        $usuario=$_POST['usuario'];
        // SI NO ESTA SETEADO RETORNAR EL ADMIN
        $this->modelo->verPorcentajePreguntasAcertadasPorUsuario($usuario);
    }
    public function graficoCantidadUsuariosPorPais(){
        $this->modelo->verCantidadUsuariosPorPais();
    }

    public function graficoCantidadUsuariosPorGenero(){
        $this->modelo->verCantidadUsuariosPorGenero();
    }

    public function graficoCantidadUsuariosPorGrupoEdad(){
        $this->modelo->verCantidadUsuariosPorGrupoEdad();
    }

    public function graficoPreguntasPorCategoria() {
        $resultado= $this->modelo->verCantidadPreguntasPorCategoria();

        $grafico = new PieGraph(600, 400);
        $grafico->title->Set("Preguntas por Categoría");

        $datosTorta = array_values($resultado);
        $etiquetas = array_keys($resultado);
        $torta = new PiePlot($datosTorta);
        $torta->SetLegends($etiquetas);

        $grafico->Add($torta);

        // Obtener los datos de la imagen como una cadena
        ob_start();
        $grafico->Stroke();
        $graficoData = ob_get_clean();

        return $graficoData;
    }



}