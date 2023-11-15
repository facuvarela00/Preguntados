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
        $usuarios= $this->modelo->verUsuarios();
        $correos = array_column($usuarios, 'mail');
        $graficoPorcentajeAcertadasPorUsuario=$this->acertadasPorUsuario();

        $graficoCantidadUsuariosPorPais=$this->graficoCantidadUsuariosPorPais();

        $graficoCantidadUsuariosPorGenero=$this->graficoCantidadUsuariosPorGenero();

        $graficoCantidadUsuariosPorGrupoEdad=$this->graficoCantidadUsuariosPorGrupoEdad();

        $data = [
            'usuarios'=>$correos,
            'graficoCantidadUsuariosPorGrupoEdad'=>$graficoCantidadUsuariosPorGrupoEdad,
            'graficoCantidadUsuariosPorGenero'=>$graficoCantidadUsuariosPorGenero,
            'graficoCantidadUsuariosPorPais'=>$graficoCantidadUsuariosPorPais,
            'graficoPorcentajeAcertadasPorUsuario'=> $graficoPorcentajeAcertadasPorUsuario
        ];

        $this->renderizado->render('/usuariosDB',$data);
        exit();
    }
    public function preguntas(){

        /*$preguntas=$this->modelo->verPreguntas();*/

        $cantidadTotalPreguntas=$this->modelo->verCantidadPreguntas();

        $graficoPreguntasPorCategoria=$this->graficoPreguntasPorCategoria();

        $data = [
            'cantidadTotalPreguntas'=>$cantidadTotalPreguntas,
            'graficoPreguntasPorCategoria'=>$graficoPreguntasPorCategoria,

        ];

        $this->renderizado->render('/preguntasDB',$data);
    }

    public function acertadasPorUsuario(){
        if(!isset($_POST['correo'])){
            $usuario="admin@gmail.com";
        }else{
            $usuario=$_POST['correo'];
        }
        $usuarioEncontrado=$this->modelo->buscarUsuarioPorCorreo($usuario);
        $recibidas=intval($usuarioEncontrado['preguntasRecibidas']);
        $acertadas=intval($usuarioEncontrado['preguntasAcertadas']);
        $erradas=$recibidas-$acertadas;
        $datos = [
            'acertadas'=>$acertadas,
            'erradas'=>$erradas,

        ];
        return $this->graficoPorcentajeAcertadasPorUsuario($usuario,$datos);
    }
    public function graficoPorcentajeAcertadasPorUsuario($usuario,$datos){
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

    public function graficoCantidadUsuariosPorPais() {
        $resultado = $this->modelo->verCantidadUsuariosPorPais();

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

    public function graficoCantidadUsuariosPorGenero() {
        $resultado = $this->modelo->verCantidadUsuariosPorGenero();

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


    public function graficoCantidadUsuariosPorGrupoEdad() {
        $resultado = $this->modelo->verCantidadUsuariosPorGrupoEdad();

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

    public function graficoPreguntasPorCategoria() {
        $resultado = $this->modelo->verCantidadPreguntasPorCategoria();

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









}