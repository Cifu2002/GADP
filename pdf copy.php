<?php
require('assets/fpdf/fpdf.php');

class PDF extends FPDF
{
    public static function GenerarPDFPreventivo(
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

        // Tipo de mantenimiento e impresora
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(49, 10, utf8_decode('Tipo de mantenimiento: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(51, 10, utf8_decode($tipoMantenimientoString), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(43, 10, utf8_decode('Impresora Funciona: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode($impresoraString), 0, 0, 'L');

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
        $pdf->Output('D', 'Asistencia Tecnica ' . $solicitudID . '.pdf');
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

        // Itera a través de los elementos de los arrays, utilizando $i como índice
        for ($i = 0; $i < $maxLength; $i++) {
            // Verifica si el índice $i existe en el array $componentes y si 'nombre' no es null o vacío
            $componenteNombre = isset($componentes[$i]['nombre']) ? $componentes[$i]['nombre'] : null;
            $componenteText = !empty($componenteNombre) ? '- ' . utf8_decode($componenteNombre) : null;

            // Verifica si el índice $i existe en el array $cambios y si 'nombreComponente' y 'fechaCambio' no son null o vacíos
            $cambioNombre = isset($cambios[$i]['nombreComponente']) ? $cambios[$i]['nombreComponente'] : null;
            $cambioFecha = isset($cambios[$i]['fechaCambio']) ? $cambios[$i]['fechaCambio'] : null;
            $cambioText = (!empty($cambioNombre) && !empty($cambioFecha)) ? '- ' . utf8_decode($cambioNombre) : null;

            // Solo imprime si hay texto válido para ambos componentes y cambios
            if ($componenteText || $cambioText) {
                $pdf->Cell(100, 10, $componenteText ?: '- ', 0, 0, 'L');
                $pdf->Cell(0, 10, $cambioText ?: '- ', 0, 1, 'L');
            }
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
        $pdf->Output('D', 'Asistencia Tecnica ' . $solicitudID . '.pdf');
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