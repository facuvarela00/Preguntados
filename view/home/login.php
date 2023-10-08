<?php
include_once ('c://xampp/htdocs/Preguntados/view/head/head.php');
?>

<?php
//no me deja ir al login porque ya tengo una sesion abierta
if (!empty($_SESSION['usuario'])){
    header('location: panel_control.php');
}
?>

<?php
// GET mensaje de contraseñas o usuario incorrecto
  $error=!empty ($_GET['error']) ? $_GET['error'] : ""
?>


<?php
echo'<h2 style="text-align: center">Pokemon Challenge</h2>

<form action="verificar.php" method="POST">

<h3 style="text-align: center">Iniciar sesion</h3>
 
  <div class="imgcontainer">    
  </div>
  <div class="container">
    <label for="uname"><b>Direccion de mail</b></label>
    <input type="text" placeholder="Ingrese direccion de mail" name="correo" required>
    <label for="psw"><b>Contraseña</b></label>
    <input type="password" placeholder="Ingrese contraseña" name="contraseña" required>
    <!-- mensaje de contraseñas o usuario incorrecto -->
     <span style="color: #f44336">'.$error.'</span>   
    <button type="submit">Login</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <span class="psw">Nuevo en Pokemon Challenge <a href="SignUp.php">Create una cuenta</a></span>
  </div>
 
</form>'
?>




