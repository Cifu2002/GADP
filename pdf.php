<?php
require('assets/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Header
    function Header()
    {
        // Logo
        $this->Image('assets/images/cantonescudo1.png', 10, 6, 30); // Ajusta el logo y posición
        $this->SetFont('Arial', 'B', 12);
        // Title
        $this->Cell(0, 10, utf8_decode('DIRECCIÓN DE TECNOLOGÍA Y SISTEMAS INFORMÁTICOS 2024'), 0, 1, 'C');
        $this->Ln(10);
    }

    // Footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear instancia de PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Título principal
$pdf->Cell(0, 10, utf8_decode('Registro de asistencia / orden de trabajo Nro. Orden: _________'), 0, 1, 'L');
$pdf->Cell(0, 10, utf8_decode('Departamento Unidad: _______________  Cod. Equipo: ___________'), 0, 1, 'L');

// Mantenimiento y Soporte
$pdf->Ln(10);
$pdf->Cell(0, 10, utf8_decode('Mantenimiento: Preventivo( ) Correctivo( ) Sis. eléctrico( )'), 0, 1, 'L');
$pdf->Cell(0, 10, utf8_decode('Soporte: Hardware( ) Software( ) Impresora( ) Redes( ) Virus( )'), 0, 1, 'L');
$pdf->Cell(0, 10, utf8_decode('Capacitación: Office( ) Internet( ) Windows( ) Email( ) Uso de Equipo( )'), 0, 1, 'L');

// Diagnóstico y trabajo realizado
$pdf->Ln(10);
$pdf->Cell(0, 10, 'DIAGNOSTICO:', 0, 1, 'L');
$pdf->MultiCell(0, 10, str_repeat("_", 100), 0, 'L'); // Espacio para diagnóstico

$pdf->Ln(5);
$pdf->Cell(0, 10, utf8_decode('TRABAJO REALIZADO:'), 0, 1, 'L');
$pdf->MultiCell(0, 10, str_repeat("_", 100), 0, 'L'); // Espacio para trabajo realizado

// Fechas y firmas
$pdf->Ln(10);
$pdf->Cell(30, 10, 'INICIO', 1);
$pdf->Cell(30, 10, 'DIA', 1);
$pdf->Cell(30, 10, 'MES', 1);
$pdf->Cell(30, 10, utf8_decode('AÑO'), 1);
$pdf->Cell(30, 10, 'HORA', 1);
$pdf->Ln(10);
$pdf->Cell(30, 10, 'FIN', 1);
$pdf->Cell(30, 10, '', 1);
$pdf->Cell(30, 10, '', 1);
$pdf->Cell(30, 10, '', 1);
$pdf->Cell(30, 10, '', 1);

// Firmas
$pdf->Ln(15);
$pdf->Cell(60, 10, 'AUTORIZADO', 0);
$pdf->Cell(60, 10, utf8_decode('TÉCNICO RESPONSABLE'), 0);
$pdf->Cell(60, 10, 'USUARIO ATENDIDO', 0);
$pdf->Ln(15);
$pdf->Cell(60, 10, '____________________', 0);
$pdf->Cell(60, 10, '____________________', 0);
$pdf->Cell(60, 10, '____________________', 0);

$pdf->Ln(10);
$pdf->Cell(60, 10, utf8_decode('Ing. Claudio Freire'), 0);
$pdf->Cell(60, 10, 'Firma', 0);
$pdf->Cell(60, 10, 'Firma', 0);

$pdf->Output();
?>
