<?php
class juegoIniciadoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function cantidadTotalDeCategorias(){
        $total = 0;

        $sql = "SELECT COUNT(*) FROM categorias";
        $resultado = $this->database->query($sql);

        foreach($resultado as $result){
            $total++;
        }
            return $total;
    }

    public function buscarCategoria($numeroAleatorio){

    }

}

?>

