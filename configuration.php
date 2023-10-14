<?php
include_once('helper/MySqlDatabase.php');
include_once("helper/MustacheRender.php");
include_once("helper/Router.php");


include_once('model/registroModel.php');
include_once('model/loginModel.php');
include_once('model/homeJuegoModel.php');
include_once('model/juegoIniciadoModel.php');


include_once('controller/registroController.php');
include_once('controller/loginController.php');
include_once('controller/homeJuegoController.php');
include_once('controller/juegoIniciadoController.php');

include_once('third-party/mustache/src/Mustache/Autoloader.php');
class Configuration{
    private $configFile = 'config/config.ini';

    public function __construct(){
    }
    private function getArrayConfig(){
        return parse_ini_file($this->configFile);
    }
    public function getDatabase(){
        $config = $this->getArrayConfig();
        return new MySqlDatabase(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['database']);
    }
    public function getRenderer() {
        return new MustacheRender('view/');
    }
    public function getRouter() {
        $view="Registro";
        return new Router($this, "get".$view."Controller", "execute");
    }

    public function getRegistroModel(){
        return new registroModel($this->getDatabase());
    }
    public function getRegistroController(){
        return new registroController($this->getRegistroModel(), $this->getRenderer());
     }

    public function getLoginModel(){
        return new loginModel($this->getDatabase());
    }
    public function getLoginController(){
        return new loginController($this->getLoginModel(), $this->getRenderer());
    }
    public function getHomeJuegoModel(){
        return new homeJuegoModel($this->getDatabase());
    }
    public function getHomeJuegoController(){
        return new homeJuegoController($this->getHomeJuegoModel(), $this->getRenderer());
    }

    public function getJuegoIniciadoModel(){
        return new JuegoIniciadoModel($this->getDatabase());
    }
    public function getJuegoIniciadoController(){
        return new JuegoIniciadoController($this->getJuegoIniciadoModel(), $this->getRenderer());
    }


}
?>