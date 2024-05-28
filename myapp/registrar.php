<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
    <link rel="stylesheet" href="style.css">
</head>
<head>
  <div >
        
    </div>
  </head>

<body>
<div class="container">    
<form method="post">

<h2> COTIPRO </h2> 

<p>  Ingresa tus Datos </p> 

<div class="input-wrapper">
<input type="text" name ="nit" placeholder="Nit">
<img class="input-icon" src="images/name.svg"alt="">
</div>

<div class="input-wrapper">
<input type="text" name ="name" placeholder="Nombre/Organización">
<img class="input-icon" src="images/name.svg"alt="">
</div>



<div class="input-wrapper">
<input type="email" name ="email" placeholder="Correo">
<img class="input-icon" src="images/email.svg"alt="">
</div>

<div class="input-wrapper">
<input type="tel" name ="phone" placeholder="Telefono">
<img class="input-icon" src="images/phone.svg"alt="">
</div>

<div class="input-wrapper">
<input type="text" name ="organizacion" placeholder="Compañia (Si eres persona Individual puedes Omitirlo)">
<img class="input-icon" src="images/organizacion.png"alt="">
</div>



<div class="input-wrapper">
    <input type="password" name="password" placeholder="Contraseña (Minimo 8 caracteres)" minlength="8" required>
    <img class="input-icon" src="images/password.svg" alt="">
</div>

<div class="input-wrapper">
    <input type="password" name="confirmpassword" placeholder="Confirma tu Contraseña" minlength="8" required>
    <img class="input-icon" src="images/password.svg" alt="">
</div>


<input class="bth" type="submit" name="registrar" valu="Enviar">



</form>
</div>
</body>
</html>





<?php

include("conexion.php");
$conex = conexion();

if (isset($_POST["registrar"])) {

    if (
        strlen($_POST['name']) >= 1 &&
        strlen($_POST['email']) >= 1 &&
        strlen($_POST['phone']) >= 1 &&
        //strlen($_POST['nit']) >= 1 &&
        //strlen($_POST['giro']) >= 1 &&
        strlen($_POST['confirmpassword']) >= 1 &&
        strlen($_POST['password']) >= 1) 
        
    {
        $nit = $_POST['nit'];
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
        $email = $_POST['email'];

        if(valNit($nit)){
            if(isPassword($password,$confirmpassword)){
                if(validarCorreo($email)){
                    if(noEstaEseNit($nit)){

                        $nombre = $_POST['name'];
                        //$apellido = $_POST['lastname'];
                        $email = $_POST['email'];
                        $phone = $_POST['phone'];
                       $organizacion = $_POST['organizacion']; //quitar
                        $nit = $_POST['nit'];
                       // $giro = $_POST['giro']; // quitar
                        $password = $_POST['password'];

                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Encriptacion de Contraseña

                        $consulta = "INSERT INTO registro VALUES ('$nit','$nombre', '$apellido', '$email', '$phone', '$organizacion', '$giro')";
                        $resultado = mysqli_query($conex, $consulta);
                        $consulta2 = "INSERT INTO login VALUES ('$nit','$hashed_password')";
                        $resultado2 = mysqli_query($conex, $consulta2);

                        if ($resultado && $resultado2) {
                            ?>
                            <h3 class="successfooter">Tu Registro se ha completado</h3>
                        
                            <div class="button">
                            <a href="index.php">Ir a inicio de sesión</a>
                            </div>
                            <?php
                        } else {
                            ?>
                            <h3 class="error">No se pudo registrar en la Base de Datos</h3>
                            <?php
                        }
                    }else{
                        ?>
                            <h3 class="error">El NIT ya esta Registrado!</h3>
                            <?php
                    }    
                }else{
                    ?>
                    <h3 class="error">El Correo no tiene un formato Valido</h3>
                    <?php
                }
            }else{
                ?>
                <h3 class="error">Las contraseñas no concuerdan</h3>
                <?php 
            }       
        }else{
            ?>
            <h3 class="error">El NIT Ingresado No es Valido</h3>
            <?php 
        }    
    } else {
        ?>
        <h3 class="error">Llena todos los campos</h3>
        <?php
    
    }mysqli_close($conex);
} else {
    ?>
        <h3 class="error">Formulario no se envió</h3>
    <?php
}


//Funciones PHP

function valNit($nit) {
    // Elimina espacios en blanco
    $nit_n = str_replace(' ', '', $nit);
    // Elimina el guion del nit
    $nit_ok = str_replace('-', '', $nit_n);
    // Base para multiplicar
    $base = 1;

    // Guarda el digito validador, el ultimo
    $dig_validador = substr($nit_ok, -1);

    // Guarda el resto de numeros para sumar
    $dig_nit = str_split(substr($nit_ok, 0, -1));

    // Reverse invierte el orden de los digitos del original
    // El array inverso se refleja al original
    $dig_nit_rev = array_reverse($dig_nit);

    try {
        $suma = 0;
        // Por cada numero del nit en inversa
        foreach ($dig_nit_rev as $n) {
            $base += 1;
            $suma += (int)$n * $base;
        }

        // Guarda el residuo
        $resultado = $suma % 11;
        $comprobacion = 11 - $resultado;

        if ($suma >= 11) {
            $resultado = $suma % 11;
            $comprobacion = 11 - $resultado;
        }

        if ($comprobacion == 10) {
            if (strtoupper($dig_validador) == 'K') {
                return true;
            }
        } elseif ($comprobacion == (int)$dig_validador) {
            return true;
        } else {
            return false;
        }

    } catch (Exception $e) {
        return false;
    }
}

function isPassword($password,$confirmpassword){ //Confirma si las contraseñas ingresadas son iguales
    if($password == $confirmpassword){
        return true;
    }else{
        return false;
    }
}

function validarCorreo($email) { //Valida si un correo es valido
    // Usar filter_var() para verificar el formato del correo electrónico
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Utilizar expresión regular para verificar el dominio del correo electrónico
        list(, $dominio) = explode('@', $email);
        if (checkdnsrr($dominio, 'MX')) {
            return true; // El correo electrónico es válido y el dominio tiene registros MX
        } else {
            return false; // El dominio no tiene registros MX
        }
    } else {
        return false; // El formato del correo electrónico no es válido
    }
}

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

/*

<div class="input-wrapper">
<input type="text" name ="giro" placeholder="Giro de tu Negocio (A que te dedicas)">
<img class="input-icon" src="images/giro.png"alt="">
</div>

<div class="input-wrapper">
<input type="text" name ="lastname" placeholder="Apellidos (Si eres Empresa puedes Omitirlo)">
<img class="input-icon" src="images/name.svg"alt="">
</div>
*/

?>


