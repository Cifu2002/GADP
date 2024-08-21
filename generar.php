<?php
include_once("pdf.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        // Manejar el error si no se pueden decodificar los datos JSON
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    // Filtrar y asignar los valores como antes
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

    // Generar PDF según el tipo de solicitud
    if ($tipoSolicitud === "Preventiva") {
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
    } elseif ($tipoSolicitud === "Correctiva") {
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

    // Terminar el script después de generar y enviar el PDF
    exit;
} else {
    // Manejar el caso de que no sea una solicitud POST
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

?>