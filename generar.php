<?php
include_once('pdf copy.php');
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
$componentes = isset($_GET['componentes']) ? $_GET['componentes'] : '';
$cambios = isset($_GET['cambios']) ? $_GET['cambios'] : '';
$fechaSolicitud = isset($_GET['fechaSolicitud']) ? $_GET['fechaSolicitud'] : '';
$horaSolicitud = isset($_GET['horaSolicitud']) ? $_GET['horaSolicitud'] : '';
$fechaSolicitudF = isset($_GET['fechaSolicitudF']) ? $_GET['fechaSolicitudF'] : '';
$horaSolicitudF = isset($_GET['horaSolicitudF']) ? $_GET['horaSolicitudF'] : '';
$detalles = isset($_GET['detalles']) ? $_GET['detalles'] : '';
$impresora = isset($_GET['impresora']) ? $_GET['impresora'] : '';

// Decodificar los valores JSON
$tipoMantenimiento = json_decode($tipoMantenimiento, true);
$componentes = json_decode($componentes, true);
$cambios = json_decode($cambios, true);
$impresora = json_decode($impresora, true);
// Generar PDF usando la función PDF::GenerarPDFPreventivo
PDF::GenerarPDFPreventivo(
    $solicitudID,
    $codigo,
    $mac,
    $tipoSolicitud,
    $tipoMantenimiento,
    $responsableBien,
    $departamento,
    $encargado,
    $fechaSolicitud,
    $horaSolicitud,
    $fechaSolicitudF,
    $horaSolicitudF,
    $detalles,
    $impresora
);
// Ejemplo de cómo podrías utilizar estos valores
echo "Operación: $op<br>";
echo "Solicitud ID: $solicitudID<br>";
echo "Código: $codigo<br>";
echo "MAC: $mac<br>";
echo "IP: $ip<br>";
echo "Tipo de Solicitud: $tipoSolicitud<br>";
echo "Tipo de Mantenimiento: " . implode(", ", $tipoMantenimiento) . "<br>";
echo "Responsable del Bien: $responsableBien<br>";
echo "Departamento: $departamento<br>";
echo "Cédula: $cedula<br>";
echo "Cargo: $cargo<br>";
echo "Encargado: $encargado<br>";
echo "Componentes: ";
print_r($componentes);
echo "<br>Cambios: ";
print_r($cambios);
echo "<br>Fecha de Solicitud: $fechaSolicitud<br>";
echo "Hora de Solicitud: $horaSolicitud<br>";
echo "Fecha Final: $fechaSolicitudF<br>";
echo "Hora Final: $horaSolicitudF<br>";
echo "Detalles: $detalles<br>";
echo "Impresora: " . implode(", ", $impresora) . "<br>";
?>