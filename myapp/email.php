<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>

    <div class="container">    
    <form method="post">

    <h2> Hola vos Tilin </h2> 
    <h2> Veo que olvidaste tu Contraseña </h2> 
    <h2> Llena lo que se te pide para ayudarte </h2> 

    <p>  Ingresa tus Credenciales </p> 



<div class="input-wrapper">
<input type="text" name ="nit" placeholder="Ingresa tu Usuario (Nit)">
<img class="input-icon" src="images/name.svg"alt="">
</div>
 

<input class="bth" type="submit" name="validar" id="validarBtn" value="Validar NIT">

</form>
</div>
</body>
</html>

<?php

    include("conexion.php");
    $conex = conexion();

    if (isset($_POST["validar"])) { // Valida que a la hora de presionar el boton hayan valores.
        
        if (strlen($_POST['nit']) >= 1){

            $nit = $_POST['nit'];

            if(!noEstaEseNit($nit)){

                // Obtener la contraseña almacenada en la base de datos para el usuario dado ($nit)
                $consulta = "SELECT email FROM registro WHERE NIT = '$nit'";
                $resultado = mysqli_query($conex, $consulta);
                $row = mysqli_fetch_assoc($resultado);
                $email = $row['email'];

                

                // Mostrar el correo electrónico y el botón si se encontró el NIT
                ?>
                    <h3 class="success">Se ha encontrado tu usuario</h3>

                    <div class="resultado">
                    <label for="email">Se enviará un código verificador<br>al Correo Electrónico:</label>
                    <p id="email"><?php echo $email; ?></p>
                    <form method="post" action="email.php">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="nit" value="<?php echo $nit; ?>">
                    <button type="submit" name="enviarCorreo">Enviar Correo</button> 
                    </form>
                    </div>
                <?php
    
            }else{
                ?>
                <h3 class="error">No hay registro de ese NIT<?php ?></h3>
                <?php
            }    
        }else{
            ?>
            <h3 class="error">No se Permiten Campos en Blanco<?php ?></h3>
            <?php
        }   
    }
?>


<?php
//Apartado de envio de correo
    if (isset($_POST["enviarCorreo"])){

        $email = $_POST['email']; //email de cliente
        $nit = $_POST['nit'];
        $codigo = mt_rand(100000, 999999); //Genera codigo aleatorio de 6 digitos

        if(enviarEmail($email,$codigo)){
            echo $codigo;
            ?>
            
            <h3 class="success">Se ha enviado Exitosamente el Codigo</h3>
            <div class="input-wrapper">
            <form method="post" action="email.php">
            <input type="text" name ="codigo" placeholder="Ingresa el Codigo que te llego">
            <img class="input-icon" src="images/password.svg"alt="">
            <input type="hidden" name="codigoGenerado" value="<?php echo $codigo; ?>">
            <input type="hidden" name="nit" value="<?php echo $nit; ?>">

            <input class="bth" type="submit" name="validarCodigo" id="validarCodBtn" value="Validar">
            </form>
            </div>
            
           
            
            <?php
           
        }else{
            ?>
            <h3 class="error">Hubo un error al enviar el Codigo<?php ?></h3>
            <?php
        }
    }
?>

<?php
 if (isset($_POST["validarCodigo"])){ // Valida que el codigo sea el correcto y reenvia
    $codigo = $_POST['codigo'];
    $codigoGenerado = $_POST['codigoGenerado'];
    $nit = $_POST['nit'];

    if($codigo==$codigoGenerado){

        ?> 
        <form method="post" action="recuperacion.php">
        <input type="hidden" name="nit" value="<?php echo $nit; ?>">
        </form>
        <?php
        
        session_start();
        $_SESSION['nit'] = $nit;
        header("Location: recuperacion.php");
        exit(); // Asegura que no se ejecuten más instrucciones después de la redirección
    }
}
?>


<?php
function noEstaEseNit($nit){ // Valida si el nit ya existe en la base de datos
    $conexprueba = conexion();

    // Consulta SQL para buscar si el NIT ya existe en la base de datos
    $consulta = "SELECT NIT FROM login WHERE NIT = '$nit'";
    $resultado = mysqli_query($conexprueba, $consulta);

    // Comprobar si se encontraron resultados
    if (mysqli_num_rows($resultado) > 0) {
        // El NIT ya existe en la base de datos
        return false;
    } else {
        // El NIT no existe en la base de datos
        return true;
    }
}


function enviarEmail($email,$codigo){ //Funcion enviar email para recuperacion
    $asunto = "Recuperación Contraseña";
    $mensaje = "Tú código para recuperar tu contraseña es: ".$codigo." No lo compartas con Nadie.";
    $headers = "From: tuemail@example.com\r\n";
    $headers .= "Reply-To: tuemail@example.com\r\n";
    $headers .= "Return-Path: tuemail@example.com\r\n";

    // Envío del correo electrónico
    if (mail($email, $asunto, $mensaje,$headers)) {
        return true;
    } else {
        return true;
    }
}


?>

