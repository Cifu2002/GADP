<?php
require('assets/fpdf/fpdf.php');

class PDF extends FPDF
{
    public static function GenerarPDFPreventivo(

    ) {

        // Crear instancia de PDF
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);

        // Título principal
        $pdf->Cell(0, 10, utf8_decode('Registro de asistencia / orden de trabajo Nro. Orden: dfg'), 0, 1, 'L');

        /* Encargado */
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(25, 10, 'Encargado: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode('Esteban Ismael CifueSDFSDFSDFSDFSDFSntes Salinas'), 0, 0, 'L'); // Resto del espacio para el nombre


        $pdf->Ln(10);
        $anchoPagina = $pdf->GetPageWidth();
        $margenIzquierdo = $pdf->GetX();
        $margenDerecho = $pdf->GetStringWidth(" ");
        $anchoDisponible = $anchoPagina - $margenIzquierdo - $margenDerecho;
        $anchoCelda = $anchoDisponible / 4;
        $pdf->SetX($margenIzquierdo);
        /* Departamento y Encargado */
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(31, 10, 'Departamento: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($anchoCelda + 19, 10, utf8_decode('Esteban Cifuentes'), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(29, 10, utf8_decode('Responsable: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($anchoCelda, 10, utf8_decode('Estebadfgdfgdfgdfggn Cifuentes'), 0, 0, 'L');
        $pdf->Ln(10);

        /* Codigo y Mac */
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(17, 10, utf8_decode('Código: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($anchoCelda + 33, 10, utf8_decode('1.4.1.01.07.00005.00002.00005'), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(11, 10, utf8_decode('Mac: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($anchoCelda, 10, utf8_decode('10-EB-F6-D2-F2-67'), 0, 1, 'L');


        /* Solicitud*/
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, utf8_decode('Solicitud: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode('Preventiva'), 0, 1, 'L');


        /* Tipo de mantenimiento e impresora */
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(49, 10, utf8_decode('Tipo de mantenimiento: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(51, 10, utf8_decode('Hardware'), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(43, 10, utf8_decode('Impresora Funciona: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode('Si'), 0, 0, 'L');

        /* Detalles */
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Detalles:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 5, 'asd asd usiah asu uas huas usaoi  hsahsahd uuash usadh usah usahu su asu susaua udasu u uas usu uas uaas aiush ', 0, 'L');

        // Fechas y firmas
        $margenIzquierdo = ($pdf->GetPageWidth() - 150) / 2; // 150 es el ancho total de las celdas (30 * 5)
        $pdf->Ln(10);
        $pdf->SetX($margenIzquierdo);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        $pdf->Cell(30, 10, 'DIA', 1, 0, 'C');
        $pdf->Cell(30, 10, 'MES', 1, 0, 'C');
        $pdf->Cell(30, 10, utf8_decode('AÑO'), 1, 0, 'C');
        $pdf->Cell(30, 10, 'HORA', 1, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetX($margenIzquierdo);
        $pdf->Cell(30, 10, 'INICIO', 1, 0, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        $pdf->Cell(30, 10, '', 1, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetX($margenIzquierdo); // Reposiciona la X para la siguiente fila
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 10, 'FIN', 1, 0, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        // Calcular el margen izquierdo para centrar las celdas
        $margenIzquierdo = ($pdf->GetPageWidth() - 180) / 2;

        // Firmas
        $margenIzquierdo = ($pdf->GetPageWidth() - 180) / 2;
        $pdf->Ln(15);
        $pdf->SetX($margenIzquierdo);

        $pdf->Cell(100, 10, utf8_decode('TÉCNICO RESPONSABLE'), 0, 0, 'C');
        $pdf->Cell(60, 10, 'USUARIO ATENDIDO', 0, 0, 'C');

        $pdf->Ln(20);
        $pdf->SetX($margenIzquierdo);
        $pdf->Cell(100, 10, '................................', 0, 0, 'C');
        $pdf->Cell(60, 10, '................................', 0, 0, 'C');

        $pdf->Ln(5);
        $pdf->SetX($margenIzquierdo);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, 'Firma', 0, 0, 'C');
        $pdf->Cell(60, 10, 'Firma', 0, 0, 'C');


        $pdf->Ln(15);
        $pdf->SetX($margenIzquierdo);
        $pdf->Cell(18, 10, utf8_decode('Nombre: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(90, 10, utf8_decode('ESTEBAN ISMAEL CIFUENTES SALINAS'), 0, 0, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(18, 10, utf8_decode('Nombre: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode('Diana Quevedo'), 0, 0, 'L');
  
        $pdf->Output('D', 'Asistencia Tecnica .pdf');

    }

    public static function GenerarPDFCorrectivo(
        $solicitudID,
        $codigo,
        $mac,
        $tipoSolicitud,
        $responsableBien,
        $departamento,
        $encargado,
        $fechaSolicitud,
        $horaSolicitud,
        $fechaSolicitudF,
        $horaSolicitudF,
        $detalles,
        $impresoraString,
        $componentes,
        $cambios
    ) {
        // Configurar cabeceras para la descarga del PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Asistencia Tecnica ' . $solicitudID . '.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        // Crear instancia de PDF
        $pdf = new self();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Título principal
        $pdf->Cell(108, 10, utf8_decode('Registro de asistencia / orden de trabajo Nro. Orden: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($solicitudID), 0, 1, 'L');

        $anchoPagina = $pdf->GetPageWidth();
        $margenIzquierdo = $pdf->GetX();
        $margenDerecho = $pdf->GetStringWidth(" ");
        $anchoDisponible = $anchoPagina - $margenIzquierdo - $margenDerecho;
        $anchoCelda = $anchoDisponible / 4;
        $pdf->SetX($margenIzquierdo);

        // Departamento
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(31, 10, 'Departamento: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($anchoCelda + 19, 10, utf8_decode($departamento), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln(10);

        // Código y Mac
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(17, 10, utf8_decode('Código: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($anchoCelda + 33, 10, utf8_decode($codigo), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(11, 10, utf8_decode('Mac: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($anchoCelda, 10, utf8_decode($mac), 0, 1, 'L');

        // Solicitud
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, utf8_decode('Solicitud: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($tipoSolicitud), 0, 1, 'L');

        // Impresora
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(43, 10, utf8_decode('Impresora Funciona: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($impresoraString), 0, 0, 'L');

        // Componentes y Cambios 
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, 'Componentes:', 0, 0, 'L');
        $pdf->Cell(0, 10, 'Cambios:', 0, 1, 'L');

        // Lista 
        $pdf->SetFont('Arial', '', 12);

        // Verificar si ambos arrays tienen el mismo número de elementos
        $maxLength = max(count($componentes), count($cambios));

        for ($i = 0; $i < $maxLength; $i++) {
            $componenteText = isset($componentes[$i]) ? '- ' . utf8_decode($componentes[$i]) : '- ';
            $cambioText = isset($cambios[$i]) ? '- ' . utf8_decode($cambios[$i]) : '- ';

            $pdf->Cell(100, 10, $componenteText, 0, 0, 'L');
            $pdf->Cell(0, 10, $cambioText, 0, 1, 'L');
        }


        // Detalles
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Detalles:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($detalles), 0, 'L');

        // Fechas
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(27, 10, utf8_decode('Fecha Inicio: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 10, utf8_decode($fechaSolicitud), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 10, utf8_decode('Hora de inicio: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20, 10, utf8_decode($horaSolicitud), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, utf8_decode('Fecha fin: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(33, 10, utf8_decode($fechaSolicitudF), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(18, 10, utf8_decode('Hora fin: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($horaSolicitudF), 0, 0, 'L');

        // Firmas
        $margenIzquierdo = ($pdf->GetPageWidth() - 180) / 2;
        $pdf->Ln(15);
        $pdf->SetX($margenIzquierdo);

        $pdf->Cell(100, 10, utf8_decode('TÉCNICO RESPONSABLE'), 0, 0, 'C');
        $pdf->Cell(60, 10, 'USUARIO ATENDIDO', 0, 0, 'C');

        $pdf->Ln(20);
        $pdf->SetX($margenIzquierdo);
        $pdf->Cell(100, 10, '................................', 0, 0, 'C');
        $pdf->Cell(60, 10, '................................', 0, 0, 'C');

        $pdf->Ln(5);
        $pdf->SetX($margenIzquierdo);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, 'Firma', 0, 0, 'C');
        $pdf->Cell(60, 10, 'Firma', 0, 0, 'C');

        $pdf->Ln(15);
        $pdf->SetX($margenIzquierdo);
        $pdf->Cell(18, 10, utf8_decode('Nombre: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(90, 10, utf8_decode($encargado), 0, 0, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(18, 10, utf8_decode('Nombre: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($responsableBien), 0, 0, 'L');

        // Generar el PDF
        $pdf->Output('I', 'Asistencia Tecnica ' . $solicitudID . '.pdf');

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
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Alcaldía de la dignidad'), 0, 0, 'L');
        $this->SetFont('Arial', 'I', 12);
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
$pdf->Cell(0, 10, utf8_decode('Registro de asistencia / orden de trabajo Nro. Orden: dfg'), 0, 1, 'L');

/* Encargado */
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(25, 10, 'Encargado: ', 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Esteban Ismael CifueSDFSDFSDFSDFSDFSntes Salinas'), 0, 0, 'L'); // Resto del espacio para el nombre


$pdf->Ln(10);
$anchoPagina = $pdf->GetPageWidth();
$margenIzquierdo = $pdf->GetX();
$margenDerecho = $pdf->GetStringWidth(" ");
$anchoDisponible = $anchoPagina - $margenIzquierdo - $margenDerecho;
$anchoCelda = $anchoDisponible / 4;
$pdf->SetX($margenIzquierdo);
/* Departamento y Encargado */
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(31, 10, 'Departamento: ', 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell($anchoCelda + 19, 10, utf8_decode('Esteban Cifuentes'), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(29, 10, utf8_decode('Responsable: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell($anchoCelda, 10, utf8_decode('Estebadfgdfgdfgdfggn Cifuentes'), 0, 0, 'L');
$pdf->Ln(10);

/* Codigo y Mac */
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(17, 10, utf8_decode('Código: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell($anchoCelda + 33, 10, utf8_decode('1.4.1.01.07.00005.00002.00005'), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 10, utf8_decode('Mac: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell($anchoCelda, 10, utf8_decode('10-EB-F6-D2-F2-67'), 0, 1, 'L');


/* Solicitud*/
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, utf8_decode('Solicitud: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Preventiva'), 0, 1, 'L');


/* Tipo de mantenimiento e impresora */
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(49, 10, utf8_decode('Tipo de mantenimiento: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(51, 10, utf8_decode('Hardware'), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(43, 10, utf8_decode('Impresora Funciona: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Si'), 0, 0, 'L');

/* Detalles */
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Detalles:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 5, 'asd asd usiah asu uas huas usaoi  hsahsahd uuash usadh usah usahu su asu susaua udasu u uas usu uas uaas aiush ', 0, 'L');

// Fechas y firmas
$margenIzquierdo = ($pdf->GetPageWidth() - 150) / 2; // 150 es el ancho total de las celdas (30 * 5)
$pdf->Ln(10);
$pdf->SetX($margenIzquierdo);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, 'DIA', 1, 0, 'C');
$pdf->Cell(30, 10, 'MES', 1, 0, 'C');
$pdf->Cell(30, 10, utf8_decode('AÑO'), 1, 0, 'C');
$pdf->Cell(30, 10, 'HORA', 1, 0, 'C');

$pdf->Ln(10);
$pdf->SetX($margenIzquierdo);
$pdf->Cell(30, 10, 'INICIO', 1, 0, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');

$pdf->Ln(10);
$pdf->SetX($margenIzquierdo); // Reposiciona la X para la siguiente fila
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'FIN', 1, 0, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
$pdf->Cell(30, 10, '', 1, 0, 'C');
// Calcular el margen izquierdo para centrar las celdas
$margenIzquierdo = ($pdf->GetPageWidth() - 180) / 2;

// Firmas
$margenIzquierdo = ($pdf->GetPageWidth() - 180) / 2;
$pdf->Ln(15);
$pdf->SetX($margenIzquierdo);

$pdf->Cell(100, 10, utf8_decode('TÉCNICO RESPONSABLE'), 0, 0, 'C');
$pdf->Cell(60, 10, 'USUARIO ATENDIDO', 0, 0, 'C');

$pdf->Ln(20);
$pdf->SetX($margenIzquierdo);
$pdf->Cell(100, 10, '................................', 0, 0, 'C');
$pdf->Cell(60, 10, '................................', 0, 0, 'C');

$pdf->Ln(5);
$pdf->SetX($margenIzquierdo);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'Firma', 0, 0, 'C');
$pdf->Cell(60, 10, 'Firma', 0, 0, 'C');


$pdf->Ln(15);
$pdf->SetX($margenIzquierdo);
$pdf->Cell(18, 10, utf8_decode('Nombre: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(90, 10, utf8_decode('ESTEBAN ISMAEL CIFUENTES SALINAS'), 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(18, 10, utf8_decode('Nombre: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Diana Quevedo'), 0, 0, 'L');
$pdf->Output();


?>