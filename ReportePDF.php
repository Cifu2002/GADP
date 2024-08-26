<?php
require('assets/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Reporte de solicitudes
    public static function GenerarReportePDF($solicitudes)
    {
        // Crear instancia de PDF
        $pdf = new self();
        $pdf->SetFont('Arial', 'B', 12);

        // Recorrer todas las solicitudes y generar sus páginas en el PDF
        foreach ($solicitudes as $solicitud) {
            $pdf->AddPage();

            // Detectar tipo de solicitud y generar el PDF correspondiente
            if ($solicitud['tipoSolicitud'] === 'Preventivo') {
                self::GenerarPDFPreventivo(
                    $pdf,
                    $solicitud['solicitudID'],
                    $solicitud['codigo'],
                    $solicitud['mac'],
                    $solicitud['tipoSolicitud'],
                    $solicitud['tipoMantenimientoString'],
                    $solicitud['responsableBien'],
                    $solicitud['departamento'],
                    $solicitud['encargado'],
                    $solicitud['fechaSolicitud'],
                    $solicitud['horaSolicitud'],
                    $solicitud['fechaSolicitudF'],
                    $solicitud['horaSolicitudF'],
                    $solicitud['detalles'],
                    $solicitud['impresoraString']
                );
            } elseif ($solicitud['tipoSolicitud'] === 'Correctivo') {
                self::GenerarPDFCorrectivo(
                    $pdf,
                    $solicitud['solicitudID'],
                    $solicitud['codigo'],
                    $solicitud['mac'],
                    $solicitud['tipoSolicitud'],
                    $solicitud['responsableBien'],
                    $solicitud['departamento'],
                    $solicitud['encargado'],
                    $solicitud['fechaSolicitud'],
                    $solicitud['horaSolicitud'],
                    $solicitud['fechaSolicitudF'],
                    $solicitud['horaSolicitudF'],
                    $solicitud['detalles'],
                    $solicitud['impresoraString'],
                    $solicitud['componentes'],
                    $solicitud['cambios']
                );
            }
        }

        // Generar el PDF y forzar la descarga al final
        $pdf->Output('D', 'Solicitudes.pdf');
    }

    // Método para generar el PDF de solicitud Preventiva
    public static function GenerarPDFPreventivo(
        $pdf,
        $solicitudID,
        $codigo,
        $mac,
        $tipoSolicitud,
        $tipoMantenimientoString,
        $responsableBien,
        $departamento,
        $encargado,
        $fechaSolicitud,
        $horaSolicitud,
        $fechaSolicitudF,
        $horaSolicitudF,
        $detalles,
        $impresoraString
    ) {
        // Generar el contenido del PDF para solicitudes preventivas
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(108, 10, 'Registro de asistencia / orden de trabajo Nro. Orden: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($solicitudID), 0, 1, 'L');
        // Continuar con la lógica específica para solicitudes preventivas...
    }

    // Método para generar el PDF de solicitud Correctiva
    public static function GenerarPDFCorrectivo(
        $pdf,
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
        // Generar el contenido del PDF para solicitudes correctivas
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(108, 10, 'Registro de asistencia / orden de trabajo Nro. Orden: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($solicitudID), 0, 1, 'L');

        // Departamento
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(31, 10, 'Departamento: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($departamento), 0, 1, 'L');

        // Código y Mac
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(17, 10, 'Código: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($codigo), 0, 1, 'L');
        $pdf->Cell(11, 10, 'Mac: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($mac), 0, 1, 'L');

        // Solicitud
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'Solicitud: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($tipoSolicitud), 0, 1, 'L');

        // Detalles
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Detalles:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($detalles), 0, 'L');

        // Componentes
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Componentes:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        foreach ($componentes as $componente) {
            $pdf->Cell(0, 10, utf8_decode($componente), 0, 1, 'L');
        }

        // Cambios
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Cambios:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        foreach ($cambios as $cambio) {
            $pdf->Cell(0, 10, utf8_decode($cambio), 0, 1, 'L');
        }

        // Fechas y Horas
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(27, 10, 'Fecha Inicio: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 10, utf8_decode($fechaSolicitud), 0, 0, 'L');
        $pdf->Cell(30, 10, 'Hora de inicio: ', 0, 0, 'L');
        $pdf->Cell(20, 10, utf8_decode($horaSolicitud), 0, 1, 'L');
        $pdf->Cell(20, 10, 'Fecha fin: ', 0, 0, 'L');
        $pdf->Cell(33, 10, utf8_decode($fechaSolicitudF), 0, 0, 'L');
        $pdf->Cell(18, 10, 'Hora fin: ', 0, 0, 'L');
        $pdf->Cell(0, 10, utf8_decode($horaSolicitudF), 0, 1, 'L');
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

?>