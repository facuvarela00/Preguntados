<?php
include_once('helper/MySqlDatabase.php');
include_once("helper/MustacheRender.php");
include_once("helper/Router.php");


include_once('model/registroModel.php');
include_once('model/loginModel.php');
include_once('model/homeJuegoModel.php');
include_once('model/juegoIniciadoModel.php');
include_once('model/rankingModel.php');
include_once('model/sugerirPreguntaModel.php');
include_once('model/perfilModel.php');
include_once('model/homeAdminModel.php');
include_once('model/homeEditorModel.php');



include_once('controller/registroController.php');
include_once('controller/loginController.php');
include_once('controller/homeJuegoController.php');
include_once('controller/juegoIniciadoController.php');
include_once('controller/rankingController.php');
include_once('controller/sugerirPreguntaController.php');
include_once('controller/perfilController.php');
include_once('controller/homeEditorController.php');
include_once('controller/homeAdminController.php');


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

    public function getRankingModel(){
        return new rankingModel($this->getDatabase());
    }
    public function getRankingController(){
        return new rankingController($this->getrankingModel(), $this->getRenderer());
    }

    public function getSugerirPreguntaModel(){
        return new sugerirPreguntaModel($this->getDatabase());
    }
    public function getSugerirPreguntaController(){
        return new sugerirPreguntaController($this->getSugerirPreguntaModel(), $this->getRenderer());
    }

    public function getPerfilModel(){
        return new perfilModel($this->getDatabase());
    }
    public function getPerfilController(){
        return new perfilController($this->getPerfilModel(), $this->getRenderer());
    }

    public function getHomeAdminModel(){
        return new homeAdminModel($this->getDatabase());
    }

    public function getHomeAdminController(){
        return new homeAdminController($this->getHomeAdminModel(), $this->getRenderer());
    }
    public function getHomeEditorModel(){
        return new homeEditorModel($this->getDatabase());
    }

    public function getHomeEditorController(){
        return new homeEditorController($this->getHomeEditorModel(), $this->getRenderer());
    }

}
?>