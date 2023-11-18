<?php
class MustacheRender{
    private $mustache;

    public function __construct($partialsPathLoader){
        Mustache_Autoloader::register();
        $this->mustache = new Mustache_Engine(
            array(
                'partials_loader' => new Mustache_Loader_FilesystemLoader( $partialsPathLoader )
            ));
    }

    public function render($contentFile , $data = array() ){
        echo  $this->generateHtml($contentFile, $data);
    }

    public function generateHtml($contentFile, $data = array()) {
        if(!isset($_SESSION['correo'])){
            $contentAsString = file_get_contents('view/head/header.mustache');
        }else{
            if($_SESSION['correo']=="admin@gmail.com"){
                $contentAsString = file_get_contents('view/head/headerAdmin.mustache');
            }elseif($_SESSION['correo']=="editor@gmail.com"){
                $contentAsString = file_get_contents('view/head/headerEditor.mustache');
            }elseif(isset($_SESSION['juegoIniciado'])&&($_SESSION['juegoIniciado']==1)){
                $contentAsString = file_get_contents('view/head/headerIniciado.mustache');
            }else{
                $contentAsString = file_get_contents('view/head/headerLogged.mustache');
            }
        }

        $contentAsString .= file_get_contents('view/' . $contentFile . 'View.mustache');
        $contentAsString .= file_get_contents('view/head/footer.mustache');
        return $this->mustache->render($contentAsString, $data);
    }

    public function generateHtmlPDF($contentFile, $data = array()) {

       $main=file_get_contents('view/' . $contentFile . 'View.mustache');

        return $this->mustache->render($main);
    }
}

?>