<?php
include_once('pdf.php');
// Obtener los valores de la URL
$op = isset($_GET['op']) ? $_GET['op'] : '';
$solicitudID = isset($_GET['solicitudID']) ? $_GET['solicitudID'] : '';
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';
$mac = isset($_GET['mac']) ? $_GET['mac'] : '';
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$tipoSolicitud = isset($_GET['tipoSolicitud']) ? $_GET['tipoSolicitud'] : '';
$tipoMantenimiento = isset($_GET['tipoMantenimiento']) ? $_GET['tipoMantenimiento'] : '';
$responsableBien = isset($_GET['responsableBien']) ? $_GET['responsableBien'] : '';
$departamento = isset($_GET['departamento']) ? $_GET['departamento'] : '';
$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';
$cargo = isset($_GET['cargo']) ? $_GET['cargo'] : '';
$encargado = isset($_GET['encargado']) ? $_GET['encargado'] : '';
$fechaSolicitud = isset($_GET['fechaSolicitud']) ? $_GET['fechaSolicitud'] : '';
$horaSolicitud = isset($_GET['horaSolicitud']) ? $_GET['horaSolicitud'] : '';
$fechaSolicitudF = isset($_GET['fechaSolicitudF']) ? $_GET['fechaSolicitudF'] : '';
$horaSolicitudF = isset($_GET['horaSolicitudF']) ? $_GET['horaSolicitudF'] : '';
$detalles = isset($_GET['detalles']) ? $_GET['detalles'] : '';
$impresora = isset($_GET['impresora']) ? $_GET['impresora'] : '';

$componentes = json_decode(isset($_GET['componentes']) ? $_GET['componentes'] : '[]', true);
$cambios = json_decode(isset($_GET['cambios']) ? $_GET['cambios'] : '[]', true);


$tipoMantenimiento = json_decode($tipoMantenimiento, true);

$impresora = json_decode($impresora, true);
$impresoraString = implode(',', $impresora);

/* Generar PDF preventivo */
if ($tipoSolicitud === 'Preventiva') {
    $tipoMantenimientoString = implode(',', $tipoMantenimiento);
    PDF::GenerarPDFPreventivo(
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
}

/* Generar PDF correctivo */
if ($tipoSolicitud === 'Correctiva') {
    PDF::GenerarPDFCorrectivo(
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
    );
}
?>