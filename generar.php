<?php
include_once('pdf_copy.php');

// Obtener los datos de la URL
$opP = filter_input(INPUT_GET, 'op', FILTER_SANITIZE_STRING);
$codigo = filter_input(INPUT_GET, 'codigo', FILTER_SANITIZE_STRING);
$mac = filter_input(INPUT_GET, 'mac', FILTER_SANITIZE_STRING);
$ip = filter_input(INPUT_GET, 'ip', FILTER_SANITIZE_STRING);
$tipoSolicitud = filter_input(INPUT_GET, 'tipoSolicitud', FILTER_SANITIZE_STRING);
$responsableBien = filter_input(INPUT_GET, 'responsableBien', FILTER_SANITIZE_STRING);
$departamento = filter_input(INPUT_GET, 'departamento', FILTER_SANITIZE_STRING);
$cedula = filter_input(INPUT_GET, 'cedula', FILTER_SANITIZE_STRING);
$cargo = filter_input(INPUT_GET, 'cargo', FILTER_SANITIZE_STRING);
$encargado = filter_input(INPUT_GET, 'encargado', FILTER_SANITIZE_STRING);
$fechaSolicitud = filter_input(INPUT_GET, 'fechaSolicitud', FILTER_SANITIZE_STRING);
$horaSolicitud = filter_input(INPUT_GET, 'horaSolicitud', FILTER_SANITIZE_STRING);
$fechaSolicitudF = filter_input(INPUT_GET, 'fechaSolicitudF', FILTER_SANITIZE_STRING);
$horaSolicitudF = filter_input(INPUT_GET, 'horaSolicitudF', FILTER_SANITIZE_STRING);
$detalles = filter_input(INPUT_GET, 'detalles', FILTER_SANITIZE_STRING);
$tipoMantenimiento = filter_input(INPUT_GET, 'tipoMantenimiento', FILTER_SANITIZE_STRING);
$impresora = filter_input(INPUT_GET, 'impresora', FILTER_SANITIZE_STRING);
$solicitudID = filter_input(INPUT_GET, 'solicitudID', FILTER_SANITIZE_STRING);

$tipoMantenimientoArray = json_decode($tipoMantenimiento, true);
$impresoraArray = json_decode($impresora, true);

$tipoMantenimientoString = implode(',', $tipoMantenimientoArray);
$impresoraString = implode(',', $impresoraArray);

// Generar PDF usando la función PDF::GenerarPDFPreventivo
$pdfContent = PDF::GenerarPDFPreventivo(
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
);

// Establecer las cabeceras para la descarga del PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="archivo.pdf"');
header('Content-Length: ' . strlen($pdfContent));

// Enviar el contenido del PDF
echo $pdfContent;
exit;
?>
