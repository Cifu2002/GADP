<?php
require('assets/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Header

    function Header()
    {
        $this->Image('assets/images/cantonescudo1.png', 90, 10, 30);

        $this->Ln(15); 

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('DIRECCIÓN DE TECNOLOGÍA Y SISTEMAS INFORMÁTICOS 2024'), 0, 1, 'C');
        $this->Ln(5);
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

$margenIzquierdo = ($pdf->GetPageWidth() - 150) / 2; // 150 es el ancho total de las celdas (30 * 5)

$pdf->Ln(10);
$pdf->SetX($margenIzquierdo); 
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, 'DIA', 1, 0, 'C');
$pdf->Cell(30, 10, 'MES', 1, 0, 'C');
$pdf->Cell(30, 10, utf8_decode('AÑO'), 1, 0, 'C');
$pdf->Cell(30, 10, 'HORA', 1, 0, 'C');

$pdf->Ln(10);
$pdf->SetX($margenIzquierdo); 
$pdf->Cell(30, 10, 'INICIO', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');

$pdf->Ln(10);
$pdf->SetX($margenIzquierdo); // Reposiciona la X para la siguiente fila
$pdf->Cell(30, 10, 'FIN', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
// Calcular el margen izquierdo para centrar las celdas
$margenIzquierdo = ($pdf->GetPageWidth() - 180) / 2;

// Firmas
$pdf->Ln(15);
$pdf->SetX($margenIzquierdo);
$pdf->Cell(60, 10, 'AUTORIZADO', 0, 0, 'C');
$pdf->Cell(60, 10, utf8_decode('TÉCNICO RESPONSABLE'), 0, 0, 'C');
$pdf->Cell(60, 10, 'USUARIO ATENDIDO', 0, 0, 'C');

$pdf->Ln(20);
$pdf->SetX($margenIzquierdo);
$pdf->Cell(60, 10, '.............................', 0, 0, 'C');
$pdf->Cell(60, 10, '.............................', 0, 0, 'C');
$pdf->Cell(60, 10, '.............................', 0, 0, 'C');

$pdf->Ln(5);
$pdf->SetX($margenIzquierdo);
$pdf->Cell(60, 10, utf8_decode('Ing. Claudio Freire'), 0, 0, 'C');
$pdf->Cell(60, 10, 'Firma', 0, 0, 'C');
$pdf->Cell(60, 10, 'Firma', 0, 0, 'C');


$pdf->Ln(15);
$pdf->SetX($margenIzquierdo);
$pdf->Cell(0, 10, utf8_decode('Nombre: ..........               Nombre: .........'), 0, 1, 'C');

$pdf->Output();
?>