<?php
include_once ('c://xampp/htdocs/Preguntados/view/head/header.php');
if (empty($_SESSION['usuario'])){
    header('location: ../../index.php');
}
?>
<h1 style="text-align: center"> Bievenido <?= $_SESSION ['usuario']?>  </h1>








