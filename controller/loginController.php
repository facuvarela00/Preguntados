<?php

class loginController
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
        session_destroy();
        $this->renderizado->render('/login');
    }

    public function validarLogin(){

        $correo=$_POST['correo'];
        $password=$_POST['password'];
        $error="";
        $busquedaMailExistente=$this->modelo->obtenerMail($correo);

        if($busquedaMailExistente){
            $busquedaClaveCoincidente=$this->modelo->obtenerClave($correo,$password);

            if($busquedaClaveCoincidente&&$this->modelo->cuentaActivada($correo)){
                $rol=$this-> modelo-> obtenerRol($correo);
                $_SESSION['rolActual']=$rol;
                $_SESSION['correo']=$correo;
                $_SESSION['nombre'] = $this->modelo->buscarNombre($correo);
                if($rol==3){
                    header("location:/homeJuego");
                    exit();
                }else if($rol==2){
                    header("location:/homeEditor");
                    exit();
                }else if($rol==1){
                    header("location:/homeAdmin");
                    exit();
                }else{
                    header("location:/login");
                    exit();
                }
            }
            else{
                $error= 'El Correo o Contraseña es Incorrecto';
            }
        }
            else{
            $error= 'El Correo o Contraseña es Incorrecto';

        }
        if ($error!=""){
            $this->renderizado->render('/login', ['error' => $error]);
            exit();
        }

    }


}