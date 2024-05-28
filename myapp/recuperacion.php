<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">    
<form method="post">

<form action="nuevaContra.php" method="post" id="recuperacionForm">


<h2> Hola vos Tilin </h2> 

<p>  Ingresa los siguientes datos </p> 

<div class="input-wrapper">
    <a>Ingresa Tu Nueva Contraseña</a>
    <input type="password" name="password" placeholder="Contraseña">
    <img class="input-icon" src="images/password.svg" alt="">
</div>

<div class="input-wrapper">
    <a>Confirma Tu Nueva Contraseña</a>
    <input type="password" name="confirmpassword" placeholder="Contraseña">
    <img class="input-icon" src="images/password.svg" alt="">
</div>
<input class="bth" type="submit" name="cambiar" value="Cambiar Contraseña">

</form>
</div>
</body>
</html>


<?php

include("conexion.php");
$conex = conexion();

session_start();
$nit = $_SESSION['nit'];


if (isset($_POST["cambiar"])) {

    if (strlen($_POST['confirmpassword']) >= 1 &&
        strlen($_POST['password']) >= 1){
        
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];

            if(isPassword($password,$confirmpassword)){

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $consulta = "UPDATE login SET CONTRASEÑA = '$hashed_password' WHERE NIT = '$nit'";
                $resultado = mysqli_query($conex, $consulta);

                if ($resultado) { // Se cambio la contraseña y se redirige.
                    header("Location: nuevaContra.php");
                    exit();

                } else {
                    ?>
                    <h3 class="error">No se pudo registrar en la Base de Datos</h3>
                    <?php
                }

            }else{
                ?>
                <h3 class="error">Las contraseñas no concuerdan</h3>
                <?php 
            }

    }else{
        ?>
        <h3 class="error">Llena todos los campos</h3>
        <?php
    }

}else{
    ?>
    <h3 class="error">Formulario no se envió</h3>
    <?php
}

?>


<?php
function isPassword($password,$confirmpassword){ //Confirma si las contraseñas ingresadas son iguales
    if($password == $confirmpassword){
        return true;
    }else{
        return false;
    }
}

?>