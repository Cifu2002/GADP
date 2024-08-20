<?php
require('assets/fpdf/fpdf.php');

class PDF extends FPDF
{
    private $headerText;
    private $footerText1;
    private $footerText2;
    private $footerText3;

    // Constructor para recibir los textos dinámicos
    public function __construct($headerText, $footerText1, $footerText2, $footerText3)
    {
        parent::__construct();
        $this->headerText = $headerText;
        $this->footerText1 = $footerText1;
        $this->footerText2 = $footerText2;
        $this->footerText3 = $footerText3;
    }

    // Header
    function Header()
    {
        $this->Image('assets/images/cantonescudo1.png', 90, 10, 30);
        $this->Ln(15);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode($this->headerText), 0, 1, 'C');
        $this->Ln(2);
    }

    // Footer
    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 8);

        // Calcular anchos para centrado entre sí
        $width1 = $this->GetStringWidth($this->footerText1);
        $width2 = $this->GetStringWidth($this->footerText2);
        $width3 = $this->GetStringWidth($this->footerText3);
        $maxWidth = max($width1, $width2, $width3);

        // Posicionar y alinear a la derecha
        $this->Cell(0, 5, utf8_decode($this->footerText1), 0, 1, 'R');
        $this->Cell(0, 5, utf8_decode($this->footerText2), 0, 1, 'R');
        $this->Cell(0, 5, utf8_decode($this->footerText3), 0, 0, 'R');
    }
}

// Función para crear el PDF
function crearPDF($headerText, $footerText1, $footerText2, $footerText3)
{
    $pdf = new PDF($headerText, $footerText1, $footerText2, $footerText3);
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Título principal
    $pdf->Cell(0, 10, utf8_decode('Registro de asistencia / orden de trabajo Nro. Orden: _________'), 0, 1, 'L');
    $pdf->Cell(0, 10, utf8_decode('Departamento Unidad: _______________  Cod. Equipo: ___________'), 0, 1, 'L');

    // Mantenimiento y Soporte
    $pdf->Ln(5);
    $pdf->Cell(0, 10, utf8_decode('Mantenimiento: Preventivo( ) Correctivo( ) Sis. eléctrico( )'), 0, 1, 'L');
    $pdf->Cell(0, 10, utf8_decode('Soporte: Hardware( ) Software( ) Impresora( ) Redes( ) Virus( )'), 0, 1, 'L');
    $pdf->Cell(0, 10, utf8_decode('Capacitación: Office( ) Internet( ) Windows( ) Email( ) Uso de Equipo( )'), 0, 1, 'L');

    // Diagnóstico y trabajo realizado
    $pdf->Ln(5);
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
}

// Llamar a la función con los textos deseados
crearPDF(
    'DIRECCIÓN DE TECNOLOGÍA Y SISTEMAS INFORMÁTICOS 2024', 
    'Alcaldía de la dignidad', 
    'Av. Juan Montalvo y Abdón Calderón', 
    'Teléfonos: (062) 886-452-886 021-886-052 www.tena.gob.ec'
);
?>
