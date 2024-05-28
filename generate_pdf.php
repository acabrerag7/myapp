<?php
require 'conexion.php';
require 'pdf_report.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $nit = $_POST['nit'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $items = $_POST['items'];
    $total_general = $_POST['total-grande'];
    $moneda = $_POST['moneda'];

    $conexion = conexion();

    // Guardar información del cliente en la base de datos
    $sql_cliente = "INSERT INTO clientes (NIT, nombre_cliente, numero_cliente, direccion) 
                    VALUES ('$nit', '$nombre', '$telefono', '$direccion')";

    if (!mysqli_query($conexion, $sql_cliente)) {
        echo "Error al guardar los datos del cliente en la base de datos: " . mysqli_error($conexion);
        exit();
    }

    // Guardar detalles de la cotización en la base de datos
    $detalle_guardado = true;
    $id_detalle = null;

    foreach ($items as $item) {
        $cantidad = $item['cantidad'];
        $descripcion = $item['descripcion'];
        $valor = $item['valor_unitario'];
        $descuento = $item['descuento'];
        $total_item = $item['total'];

        $sql_detalle = "INSERT INTO detalle_cotizaciones (cantidad, descripcion, valor, descuento, total) 
                        VALUES ('$cantidad', '$descripcion', '$valor', '$descuento', '$total_item')";

        if (!mysqli_query($conexion, $sql_detalle)) {
            $detalle_guardado = false;
            break;
        } else {
            $id_detalle = mysqli_insert_id($conexion);
        }
    }

    if ($detalle_guardado && $id_detalle !== null) {
        // Insertar en la tabla de cotizaciones
        $fecha = date("Y-m-d");
        $sql_cotizacion = "INSERT INTO cotizaciones (NIT, id_detalle, fecha, total) 
                           VALUES ('$nit', '$id_detalle', '$fecha', '$total_general')";

        if (mysqli_query($conexion, $sql_cotizacion)) {
            $data = [
                'nombre' => $nombre,
                'nit' => $nit,
                'telefono' => $telefono,
                'direccion' => $direccion,
                'items' => $items,
                'moneda' => $moneda
            ];
            generatePDFReport($data);
        } else {
            echo "Error al guardar la cotización en la base de datos: " . mysqli_error($conexion);
        }

        mysqli_close($conexion);
    } else {
        echo "Error al guardar los detalles de la cotización en la base de datos.";
    }
} else {
    header("Location: insert.php");
    exit();
}
?>