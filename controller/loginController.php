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
        $error = "";
        $this->renderizado->render('/login');
    }

    public function validarLogin(){

        $correo=$_POST['correo'];
        $password=$_POST['password'];
        $error="";
        $busquedaMailExistente=$this->modelo->obtenerMail($correo);

        if($busquedaMailExistente){
            $busquedaClaveCoincidente=$this->modelo->obtenerClave($correo,$password);
            if($busquedaClaveCoincidente){
                $_SESSION['correo'] = $correo;
                header("location:/homeJuego");
                exit();
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