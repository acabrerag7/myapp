<?php
require 'vendor/autoload.php';

use \setasign\Fpdi\Fpdi;

function generatePDFReport($data) {
    $pdf = new Fpdi();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Encabezados de los detalles del cliente
    $pdf->Cell(0, 10, 'Detalles del Cliente', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Nombre:', 0);
    $pdf->Cell(0, 10, utf8_decode($data['nombre']), 0, 1);
    $pdf->Cell(40, 10, 'NIT:', 0);
    $pdf->Cell(0, 10, utf8_decode($data['nit']), 0, 1);
    $pdf->Cell(40, 10, 'Numero de Telefono:', 0);
    $pdf->Cell(0, 10, utf8_decode($data['telefono']), 0, 1);
    $pdf->Cell(40, 10, 'Direccion:', 0);
    $pdf->Cell(0, 10, utf8_decode($data['direccion']), 0, 1);
    $pdf->Ln(); 

    // Encabezados de la tabla de cotización
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20, 10, 'Cantidad', 1, 0, 'C');
    $pdf->Cell(80, 10, 'Descripcion', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Valor Unitario', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Descuentos', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Total', 1, 0, 'C');
    $pdf->Ln();

    // Detalles de la cotización
    $pdf->SetFont('Arial', '', 12);
    if (isset($data['items']) && is_array($data['items'])) {
        foreach ($data['items'] as $item) {
            $pdf->Cell(20, 10, $item['cantidad'], 1, 0, 'C');
            $pdf->Cell(80, 10, utf8_decode($item['descripcion']), 1, 0, 'L');
            $pdf->Cell(30, 10, $item['valor_unitario'], 1, 0, 'R'); 
            $pdf->Cell(30, 10, $item['descuento'], 1, 0, 'R'); 
            $pdf->Cell(30, 10, $item['total'], 1, 0, 'R'); 
            $pdf->Ln();
        }
    } else {
        $pdf->Cell(190, 10, 'No hay elementos en la cotización', 1, 0, 'C');
    }
    
    // Calcular el gran total y obtener el símbolo de la moneda
    $grandTotal = 0;
    foreach ($data['items'] as $item) {
        $grandTotal += $item['total'];
    }
    $moneda = isset($data['moneda']) ? $data['moneda'] : 'GTQ';
    $currencySymbol = getCurrencySymbol($moneda);

    // Mostrar el gran total con el símbolo de la moneda en el PDF
    $formattedTotal = number_format($grandTotal, 2, ',', '.') . ' ' . $currencySymbol;
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Total General: ' . $formattedTotal, 1, 0, 'R');
    $pdf->Output();
}

function getCurrencySymbol($currencyCode) {
    switch ($currencyCode) {
        case 'USD':
            return '$';
        case 'EUR':
            return 'EUR';
        case 'MXN':
            return 'MX$';
        case 'GTQ':
            return 'Q';
        default:
            return '';
    }
}
?>