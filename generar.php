<?php
include_once('pdf copy.php');

$solicitudID = $_POST['solicitudID'];
$codigo = $_POST['codigo'];
$mac = $_POST['mac'];
$ip = isset($_POST['ip']) ? $_POST['ip'] : ''; // Si no se pasa, puedes dejarlo vacío
$tipoSolicitud = $_POST['tipoSolicitud'];
$tipoMantenimientoString = $_POST['tipoMantenimientoString'];
$responsableBien = $_POST['responsableBien'];
$departamento = $_POST['departamento'];
$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : ''; // Si no se pasa, puedes dejarlo vacío
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : ''; // Si no se pasa, puedes dejarlo vacío
$encargado = $_POST['encargado'];
$fechaSolicitud = $_POST['fechaSolicitud'];
$horaSolicitud = $_POST['horaSolicitud'];
$fechaSolicitudF = $_POST['fechaSolicitudF'];
$horaSolicitudF = $_POST['horaSolicitudF'];
$detalles = $_POST['detalles'];
$impresoraString = $_POST['impresoraString'];

// Llamada a la función GenerarPDFPreventivo
PDF::GenerarPDFPreventivo(
    
);
?>
