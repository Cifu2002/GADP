<?php
include_once('Consultas.php');
include_once("pdf.php");
$op = $_SERVER["REQUEST_METHOD"];
switch ($op) {
    case 'GET':
        $opG = filter_var($_GET['op'], FILTER_SANITIZE_STRING);
        switch ($opG) {
            case 1:
                /* Datos del tecnico */
                $id = filter_var($_GET['encargado_id'], FILTER_SANITIZE_STRING);
                $resultado = Consultas::obtenerDatosEncargado($id);
                echo json_encode($resultado);
                break;
            case 2:
                /* Datos del departamento */
                $id_departamento = urldecode(filter_var($_GET['departamento'], FILTER_SANITIZE_STRING));
                $usuario = urldecode(filter_var($_GET['usuario'], FILTER_SANITIZE_STRING));
                $resultado = Consultas::obtenerDatosDepartamento($id_departamento, $usuario);
                echo $resultado;
                break;
            case 3:
                /* Datos de la mac, departamento y usuario*/
                $codigo = urldecode(filter_var($_GET['codigo'], FILTER_SANITIZE_STRING));
                $resultado = Consultas::obtenerDatosMacDepartamentoUsuario($codigo);
                echo $resultado;
                break;
            case 4:
                /* Datos cargados segun la MAC*/
                $mac = urldecode(filter_var($_GET['cargarporMac'], FILTER_SANITIZE_STRING));
                $resultado = Consultas::obtenerDatosporMac($mac);
                echo $resultado;
                break;
            default:
                break;
        }
        break;
    case 'POST':
        /* INSERTAR EN LA BD */
        $json_input = file_get_contents('php://input');
        $data = json_decode($json_input, true);
        $opP = filter_var($data['op'], FILTER_SANITIZE_STRING);
        switch ($opP) {
            case 1:
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
                $resultado = Consultas::insertarRegistro(
                    $codigo,
                    $mac,
                    $ip,
                    $tipoSolicitud,
                    $tipoMantenimiento,
                    $responsableBien,
                    $departamento,
                    $cedula,
                    $cargo,
                    $encargado,
                    $componentes,
                    $cambios,
                    $fechaSolicitud,
                    $horaSolicitud,
                    $fechaSolicitudF,
                    $horaSolicitudF,
                    $detalles,
                    $impresora
                );
                echo json_encode(['status' => 'success', 'data' => $resultado]);
                break;
            case 2:
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
                }
                if ($tipoSolicitud === "Correctiva") {
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
                break;
            default:
                break;
        }
    case "PUT":

        break;
    case "DELETE":

        break;
}
?>