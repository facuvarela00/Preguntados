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
            $cantidadUsuarios=$this->modelo->verCantidadUsuarios();
            $usuarios=$this->modelo->verUsuarios();
            $cantidadPreguntas=$this->modelo->verCantidadPreguntas();
            $preguntas=$this->modelo->verPreguntas();
            $data = [
                'cantidadUsuarios'=>$cantidadUsuarios,
                'usuarios'=>$usuarios,
                'cantidadPreguntas'=>$cantidadPreguntas,
                'preguntas'=>$preguntas,
            ];
            $this->renderizado->render('/homeAdmin',$data);
            exit();
        }
        else{
            $this->renderizado->render('/login');
        }
    }

    public function usuarios(){
        $usuarios= $this->modelo->verUsuarios();
        $correos = array_column($usuarios, 'mail');
            if(!isset($_POST['correo'])){
                $_SESSION['guardarUsuarioActual']="admin@gmail.com";
            }else{
                $_SESSION['guardarUsuarioActual']=$_POST['correo'];
            }

        if(!isset($_SESSION['filtro'])){
            $tipoDeFiltro='todo';
        }else{
            $tipoDeFiltro=$_SESSION['filtro'];
            if($tipoDeFiltro=='dia'){
                $usuariosNuevos=$this->modelo->buscarUsuariosNuevos();
            }
        }

        $graficoPorcentajeAcertadasPorUsuario=$this->modelo->acertadasPorUsuario($_SESSION['guardarUsuarioActual']);
        $graficoCantidadUsuariosPorPais=$this->modelo->graficoCantidadUsuariosPorPais($tipoDeFiltro);
        $graficoCantidadUsuariosPorGenero=$this->modelo->graficoCantidadUsuariosPorGenero($tipoDeFiltro);
        $graficoCantidadUsuariosPorGrupoEdad=$this->modelo->graficoCantidadUsuariosPorGrupoEdad($tipoDeFiltro);
        $data = [
            'usuarios' => $correos,
            'graficoCantidadUsuariosPorGrupoEdad' => $graficoCantidadUsuariosPorGrupoEdad,
            'graficoCantidadUsuariosPorGenero' => $graficoCantidadUsuariosPorGenero,
            'graficoCantidadUsuariosPorPais' => $graficoCantidadUsuariosPorPais,
            'graficoPorcentajeAcertadasPorUsuario' => $graficoPorcentajeAcertadasPorUsuario
        ];

        if (!empty($usuariosNuevos)) {
            $data['usuariosNuevos'] = $usuariosNuevos;
        }

        $this->renderizado->render('/usuariosDB', $data);
        if(!isset($_POST['correo'])){
            unset($_SESSION['guardarUsuarioActual']);
        }
        
        exit();
    }

    public function preguntas() {
        if(!isset($_SESSION['filtro'])){
            $tipoDeFiltro='todo';
        }else{
            $tipoDeFiltro=$_SESSION['filtro'];
        }
        $preguntasNuevas=$this->modelo->verPreguntasCreadasRecientemente();
        $cantidadPartidasJugadas = $this->modelo->verCantidadPartidasJugadas();
        $cantidadTotalPreguntas = $this->modelo->verCantidadPreguntas();
        $graficoPreguntasPorCategoria = $this->modelo->graficoPreguntasPorCategoria($tipoDeFiltro);

        $data = [
            'cantidadTotalPreguntas' => $cantidadTotalPreguntas,
            'graficoPreguntasPorCategoria' => $graficoPreguntasPorCategoria,
            'cantidadPartidasJugadas' => $cantidadPartidasJugadas,
        ];

        if (!empty($preguntasNuevas)) {
            $data['preguntasNuevas'] = $preguntasNuevas;
        }

        $this->renderizado->render('/preguntasDB', $data);
        exit();
    }

    public function desactivarCuenta(){
        $correo=$_POST['correo'];
        if($correo=="editor@gmail.com" || $correo=="admin@gmail.com"){
            header("Location:homeAdmin");
        }else{
            $this->modelo->desactivarCuenta($correo);
            header("Location:homeAdmin");
        }
    }

    public function filtrarGraficos(){
        /**RECIBE 1 O 2 Dependiendo de donde se ejecuta la funcion, si de Usuarios (1) o Preguntas (2)*/
        $filtrarEn=intval($_POST['ejecutadaDesde']);
        $_SESSION['filtrarEn']=$filtrarEn;
        $tipoDeFiltro=$_POST['filtro'];
        $_SESSION['filtro']=$tipoDeFiltro;
        $_SESSION['filtroPDF']=$tipoDeFiltro;
        if($filtrarEn==1){
            header("Location: usuarios",$tipoDeFiltro);

        }else{
            header("Location: preguntas",$tipoDeFiltro);
        }
        exit();
    }

    public function generarPDF(){
        $filtrarEn=intval($_POST['ejecutadoDesde']);
        if(!isset($_SESSION['filtroPDF'])){
            $tipoDeFiltro='todo';
        }else{
            $tipoDeFiltro=$_SESSION['filtroPDF'];
        }
        $this->modelo->generarPDF($tipoDeFiltro,$filtrarEn);
        exit();
    }



}


