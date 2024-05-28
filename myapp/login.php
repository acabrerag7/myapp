
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">    
<form method="post">

<h2> Hola vos Tilin </h2> 

<p>  Ingresa tus Credenciales </p> 



<div class="input-wrapper">
<input type="text" name ="nit" placeholder="Usuario">
<img class="input-icon" src="images/name.svg"alt="">
</div>

<div class="input-wrapper">
<input type="password" name ="password" placeholder="Contraseña">
<img class="input-icon" src="images/password.svg"alt="">
</div>
 

<input class="bth" type="submit" name="login" value="Inicia Sesión">

<p>¿Olvidaste tu Contraseña? <a href="email.php">Da click aquí</a></p>

</form>
</div>
</body>
</html>

<?php

    include("conexion.php");
    $conex = conexion();

    if (isset($_POST["login"])) { // Valida que a la hora de presionar el boton hayan valores.
        
        if (
            strlen($_POST['nit']) >= 1 &&
            strlen($_POST['password']) >= 1){


            // Obtener la contraseña del formulario
            $password = $_POST['password'];
            $nit = $_POST['nit'];


            // Obtener la contraseña almacenada en la base de datos para el usuario dado ($nit)
            $consulta = "SELECT CONTRASEÑA FROM login WHERE NIT = '$nit'";
            $resultado = mysqli_query($conex, $consulta);
            $row = mysqli_fetch_assoc($resultado);
            $stored_password = $row['CONTRASEÑA'];
        

            // Verificar si la contraseña proporcionada coincide con la contraseña almacenada
            if (password_verify($password, $stored_password)) {
                // Contraseña válida
                header("Location: validar.php");
                exit(); // Asegura que no se ejecuten más instrucciones después de la redirección
            } else {
                ?>
                <h3 class="error">NIT o Contraseña No Válidas<?php ?></h3>
                <?php
            }
        }else{
            ?>
            <h3 class="error">No se Permiten Campos en Blanco<?php ?></h3>
            <?php
        }   
    }
?>
