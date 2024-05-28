<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Cotización</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="content">
            <h2>Generador de Cotización</h2>
            <form action="generate_pdf.php" method="POST">
                <div class="detalles-cliente">
                    <label for="nombre">Nombre del Cliente:</label>
                    <input type="text" id="nombre" name="nombre">
                    <label for="nit">NIT:</label>
                    <input type="text" id="nit" name="nit">
                    <label for="telefono">Número de Teléfono:</label>
                    <input type="text" id="telefono" name="telefono">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion">
                </div>
                <div class="tabla-cotizacion">
                    <table id="tabla-cotizacion">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Descripción</th>
                                <th>Valor Unitario</th>
                                <th>Descuentos</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-cotizacion">
                            <tr>
                                <td><input type="number" class="cantidad" name="items[0][cantidad]" value="1" onchange="calcularTotal(this)"></td>
                                <td><input type="text" class="descripcion" name="items[0][descripcion]"></td>
                                <td><input type="number" class="precio-unico" name="items[0][valor_unitario]" value="0" onchange="calcularTotal(this)"></td>
                                <td><input type="number" class="descuento" name="items[0][descuento]" value="0" onchange="calcularTotal(this)"></td>
                                <td><input type="text" class="total" name="items[0][total]" readonly></td>
                                <td><button type="button" class="delete-row-button" onclick="eliminarFila(this)">Eliminar</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="add-row-button" onclick="agregarFila()">Agregar Fila</button>
                </div>
                <div id="total-container">
                    <label for="total-grande">Total General:</label>
                    <input type="text" id="total-grande" name="total-grande" readonly>
                    <label for="moneda">Moneda:</label>
                    <select id="moneda" name="moneda">
                        <option value="GTQ">GTQ</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="MXN">MXN</option>
                    </select>
                </div>
                <button type="submit" class="save-quotation-button">Generar Cotización</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>