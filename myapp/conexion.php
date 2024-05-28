<?php


function conexion(){
    $host = "localhost";
    $user = "root";
    $pass = "";  
    
    $bd = "cotizador";
    
    $conex = mysqli_connect($host, $user, $pass);

    mysqli_select_db($conex, $bd);

    return $conex;   

};





?>