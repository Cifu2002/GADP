<?php
include_once('pdf_copy.php');

// Obtener los datos enviados por POST
$json_input = file_get_contents('php://input');
$data = json_decode($json_input, true);

// Sanitizar y extraer datos
$opP = filter_var($data['op'], FILTER_SANITIZE_STRING);
$componentes = isset($data['componentes']) ? $data['componentes'] : [];
$cambios = isset($data['cambios']) ? $data['cambios'] : [];
$codigo = filter_var($data['codigo'], FILTER_SANITIZE_STRING);
$mac = filter_var($data['mac'], FILTER_SANITIZE_STRING);
$ip = filter_var($data['ip'], FILTER_SANITIZE_STRING);
$tipoSolicitud = filter_var($data['tipoSolicitud'], FILTER_SANITIZE_STRING);
$responsableBien = filter_var($data['responsableBien'], FILTER_SANITIZE_STRING);
$departamento = filter_var($data['departamento'], FILTER_SANITIZE_STRING);
$cedula = filter_var($data['cedula'], FILTER_SANITIZE_STRING);
$cargo = filter_var($data['cargo'], FILTER_SANITIZE_STRING);
$encargado = filter_var($data['encargado'], FILTER_SANITIZE_STRING);
$fechaSolicitud = filter_var($data['fechaSolicitud'], FILTER_SANITIZE_STRING);
$horaSolicitud = filter_var($data['horaSolicitud'], FILTER_SANITIZE_STRING);
$fechaSolicitudF = filter_var($data['fechaSolicitudF'], FILTER_SANITIZE_STRING);
$horaSolicitudF = filter_var($data['horaSolicitudF'], FILTER_SANITIZE_STRING);
$detalles = filter_var($data['detalles'], FILTER_SANITIZE_STRING);
$tipoMantenimiento = isset($data['tipoMantenimiento']) ? json_decode($data['tipoMantenimiento'], true) : [];
$impresora = isset($data['impresora']) ? json_decode($data['impresora'], true) : [];
$solicitudID = filter_var($data['solicitudID'], FILTER_SANITIZE_STRING);

$tipoMantenimientoString = implode(',', $tipoMantenimiento);
$impresoraString = implode(',', $impresora);

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
