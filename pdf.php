<?php
require('assets/fpdf/fpdf.php');

class PDF extends FPDF
{
    public static function GenerarPDFPreventivo(
        $solicitudID,
        $codigo,
        $mac,
        $ip,
        $tipoSolicitud,
        $tipoMantenimientoString,
        $responsableBien,
        $departamento,
        $cedula,
        $cargo,
        $encargado,
        $fechaSolicitud,
        $horaSolicitud,
        $fechaSolicitudF,
        $horaSolicitudF,
        $detalles,
        $impresora
    )
    {

    }
    public static function GenerarPDFCorrectivo()
    {

    }
    // Header
    function Header()
    {
        $this->Image('assets/images/cantonescudo1.png', 90, 10, 30);
        $this->Ln(15);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('DIRECCIÓN DE TECNOLOGÍA Y SISTEMAS INFORMÁTICOS 2024'), 0, 1, 'C');
        $this->Ln(2);
    }


    // Footer
    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Alcaldía de la dignidad'), 0, 0, 'L');
        $this->Cell(0, 5, utf8_decode('Av. Juan Montalvo y Abdón Calderón'), 0, 1, 'R');
        $this->Cell(0, 5, utf8_decode('Teléfonos: (062) 886-452-886 021-886-052'), 0, 1, 'R');
        $this->Cell(0, 5, utf8_decode('www.tena.gob.ec'), 0, 0, 'R');
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
$pdf->Ln(5);
// Establecer la fuente para la parte en negrilla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Mantenimiento: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(-78, 10, utf8_decode('Preventivo( ) Correctivo( ) Sis. eléctrico( )'), 0, 0, 'R');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Soporte: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(-69, 10, utf8_decode('Hardware( ) Software( ) Impresora( ) Redes( ) Virus( )'), 0, 0, 'R');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Capacitación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(-54, 10, utf8_decode('Office( ) Internet( ) Windows( ) Email( ) Uso de Equipo( )'), 0, 0, 'R');

// Diagnóstico y trabajo realizado
$pdf->Ln(15);
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


$pdf->Ln(20);
$pdf->SetX($margenIzquierdo);
$pdf->Cell(0, 10, utf8_decode('Nombre: ....................                             
                              Nombre: ...................'), 0, 1, 'C');

$pdf->Output();
?>