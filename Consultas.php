<?php
include_once("conexion.php");

class Consultas
{
    public static function listarEncargados()
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = "SELECT NOM01APELLIDOS, NOM01NOMBRES, NOM01CODI, NOM01CEDUAL, NOM01ESTADO 
                     FROM NOM01 
                     WHERE SEG04CODI = 'D.09.5' AND NOM01ESTADO = 1";
            $stid = oci_parse($conexion, $consulta);
            oci_execute($stid);
            $opciones = '';
            while (($fila = oci_fetch_assoc($stid)) != false) {
                $opciones .= '<option value="' . htmlspecialchars($fila['NOM01CODI']) . '" data-nombre="' . htmlspecialchars($fila['NOM01NOMBRES'] . ' ' . $fila['NOM01APELLIDOS']) . '">' . htmlspecialchars($fila['NOM01NOMBRES'] . ' ' . $fila['NOM01APELLIDOS']) . '</option>';
            }
            oci_free_statement($stid);
            oci_close($conexion);

            return $opciones;
        } catch (Exception $e) {
            error_log('Error al listar Técnicos: ' . $e->getMessage());
            return '<option value="">Error al cargar técnicos</option>';
        }
    }


    public static function obtenerDatosEncargado($id)
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = "SELECT NOM01.NOM01CEDUAL, NOM01.NOM01ESTADO, NOM01.TIT01CODI, TIT01.TIT01DESC AS NOMBRE_CARGO
                     FROM NOM01 
                     LEFT JOIN TIT01 ON NOM01.TIT01CODI = TIT01.TIT01CODI 
                     WHERE NOM01.SEG04CODI = 'D.09.5' 
                     AND NOM01.NOM01ESTADO = 1 
                     AND NOM01.NOM01CODI = :encargado_id";
            $stid = oci_parse($conexion, $consulta);
            oci_bind_by_name($stid, ':encargado_id', $id);
            oci_execute($stid);
            $resultado = oci_fetch_assoc($stid);
            oci_free_statement($stid);
            oci_close($conexion);

            return $resultado;
        } catch (Exception $e) {
            error_log('Error al obtener datos del encargado: ' . $e->getMessage());
            return null;
        }
    }





    public static function insertarRegistro(
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
    ) {
        $conexion = Conexion::getInstance()->getConexion();
        try {
            $consulta = "SELECT SOLICITUDMANTSISTEMAS_SEQ.NEXTVAL AS SOL_ID FROM dual";
            $stid = oci_parse($conexion, $consulta);
            oci_execute($stid);
            $result = oci_fetch_assoc($stid);
            $solicitudID = $result['SOL_ID'];
            oci_free_statement($stid);
            $consulta = "
            INSERT INTO SolicitudMantSistemas (
                SOL_ID, SOL_COD, SOL_MAC, SOL_IP, SOL_TIPOSOLICITUD, SOL_ENCARGADO,
                SOL_TIPOMANTENIMIENTO, SOL_CEDTEC, SOL_CARGOTEC, SOL_DEPARTAMENTO,
                SOL_RESPONSABLEBIEN, SOL_FECSOLICITUD, SOL_HORASOLICITUD, 
                SOL_FECSOLICITUDF, SOL_HORASOLICITUDF, SOL_DETA, SOL_IMP
            ) VALUES (
                :solicitudID, :codigo, :mac, :ip, :tipoSolicitud, :encargado,
                :tipoMantenimiento, :cedula, :cargo, :departamento,
                :responsableBien, TO_DATE(:fechaSolicitud, 'YYYY-MM-DD'), :horaSolicitud, 
                TO_DATE(:fechaSolicitudF, 'YYYY-MM-DD'), :horaSolicitudF, :detalles, :impresora
            )
        ";

            $stid = oci_parse($conexion, $consulta);
            oci_bind_by_name($stid, ':solicitudID', $solicitudID);
            oci_bind_by_name($stid, ':codigo', $codigo);
            oci_bind_by_name($stid, ':mac', $mac);
            oci_bind_by_name($stid, ':ip', $ip);
            oci_bind_by_name($stid, ':tipoSolicitud', $tipoSolicitud);
            oci_bind_by_name($stid, ':encargado', $encargado);
            oci_bind_by_name($stid, ':tipoMantenimiento', implode(',', $tipoMantenimiento));
            oci_bind_by_name($stid, ':cedula', $cedula);
            oci_bind_by_name($stid, ':cargo', $cargo);
            oci_bind_by_name($stid, ':departamento', $departamento);
            oci_bind_by_name($stid, ':responsableBien', $responsableBien);
            oci_bind_by_name($stid, ':fechaSolicitud', $fechaSolicitud);
            oci_bind_by_name($stid, ':horaSolicitud', $horaSolicitud);
            oci_bind_by_name($stid, ':fechaSolicitudF', $fechaSolicitudF);
            oci_bind_by_name($stid, ':horaSolicitudF', $horaSolicitudF);
            oci_bind_by_name($stid, ':detalles', $detalles);
            oci_bind_by_name($stid, ':impresora', implode(',', $impresora));

            oci_execute($stid);
            oci_free_statement($stid);
            if ($tipoSolicitud === "Correctiva") {
                if (is_array($componentes) && !empty($componentes)) {
                    $consulta = "
                INSERT INTO MantSistemasComponentes (
                    SOL_ID, COMP_NOM, COMP_DESCRIP, COMP_SERIE, COMP_OBSER
                ) VALUES (
                    :solicitudID, :nombre, :descripcion, :serie, :observacion
                )
            ";
                    $stid = oci_parse($conexion, $consulta);

                    foreach ($componentes as $componente) {
                        if (empty($componente['nombre'])) {
                            continue;
                        }
                        oci_bind_by_name($stid, ':solicitudID', $solicitudID);
                        oci_bind_by_name($stid, ':nombre', $componente['nombre']);
                        oci_bind_by_name($stid, ':descripcion', $componente['descripcion']);
                        oci_bind_by_name($stid, ':serie', $componente['serie']);
                        oci_bind_by_name($stid, ':observacion', $componente['observacion']);
                        oci_execute($stid);
                    }
                    oci_free_statement($stid);
                }
                if (is_array($cambios) && !empty($cambios)) {
                    $consulta = "
                INSERT INTO MantSistemasCambios (
                    SOL_ID, CAMB_FEC, CAMB_NOM_COMP, CAMB_DESCRIP, CAMB_SERIE
                ) VALUES (
                    :solicitudID, TO_DATE(:fecha, 'YYYY-MM-DD'), :nombre, :descripcion, :serie
                )
            ";
                    $stid = oci_parse($conexion, $consulta);

                    foreach ($cambios as $cambio) {
                        if (empty($cambio['fechaCambio']) || empty($cambio['nombreComponente'])) {
                            continue;
                        }
                        try {
                            $fechaCambio = DateTime::createFromFormat('d/m/Y', $cambio['fechaCambio'])->format('Y-m-d');
                            oci_bind_by_name($stid, ':solicitudID', $solicitudID);
                            oci_bind_by_name($stid, ':fecha', $fechaCambio);
                            oci_bind_by_name($stid, ':nombre', $cambio['nombreComponente']);
                            oci_bind_by_name($stid, ':descripcion', $cambio['descripcion']);
                            oci_bind_by_name($stid, ':serie', $cambio['serie']);
                            oci_execute($stid);
                        } catch (Exception $e) {
                            error_log("Error al insertar cambio: " . $e->getMessage());
                        }
                    }
                    oci_free_statement($stid);
                }
            }
            oci_commit($conexion);

            return $solicitudID;

        } catch (Exception $e) {
            oci_rollback($conexion);

            error_log('Error al insertar registro: ' . $e->getMessage());
            return array('status' => 'error', 'message' => 'Error al insertar el registro: ' . $e->getMessage());
        }
    }
}
?>