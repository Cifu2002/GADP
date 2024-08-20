<?php
require('assets/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Encabezado de página
    function Header()
    {
        // Fuente Arial negrita 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Título del PDF', 0, 1, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Fuente Arial itálica 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '¡Hola, mundo! Este es un PDF generado con FPDF.', 0, 1);
$pdf->Output('D', 'tu_documento.pdf'); // 'D' para descargar
?>
