<?php
include_once ('c://xampp/htdocs/Preguntados/view/head/head.php');
?>

<?php
//usuario logueado
if(isset($_SESSION["usuario"])){
echo '
    <header >         
        <div class="topnav">
              <a class="active" href="/Preguntados/index.php">Home</a>                        
              <a href="/Preguntados/view/home/logout.php" class="cerrarSesion">Cerrar sesion</a>              
          </div>       
      </header>';
}

//usuario sin loguear
if(!isset($_SESSION["usuario"])){
echo '
    <header > 
         <div class="topnav">
              <a class="active" href="/Preguntados/index.php">Home</a>
              <a href="/Preguntados/view/home/SignUp.php">Registro</a>
              <a href="/Preguntados/view/home/login.php">Login</a>
        </div>        
    </header>';
}
?>









