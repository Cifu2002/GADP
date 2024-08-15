<?php
include_once ("conexion.php");

class Consultas
{
    public static function listarEncargados()
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = $conexion->prepare("SELECT NOM01APELLIDOS,NOM01NOMBRES,NOM01CODI,NOM01CEDUAL,NOM01ESTADO FROM NOM01 where SEG04CODI='D.09.5' AND NOM01ESTADO=1");
            $consulta->execute();
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $opciones = '';
            foreach ($datos as $Lopciones) {
                $opciones .= '<option value="' . htmlspecialchars($Lopciones['NOM01CODI']) . '" data-nombre="' . htmlspecialchars($Lopciones['NOM01NOMBRES']) . ' ' . htmlspecialchars($Lopciones['NOM01APELLIDOS']) . '">' . htmlspecialchars($Lopciones['NOM01NOMBRES']) . ' ' . htmlspecialchars($Lopciones['NOM01APELLIDOS']) . '</option>';
            }


            return $opciones;
        } catch (PDOException $e) {
            error_log('Error al listar Técnicos: ' . $e->getMessage());
            return '<option value="">Error al cargar técnicos</option>';
        }
    }

    public static function obtenerDatosEncargado($id)
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = $conexion->prepare("SELECT NOM01.NOM01CEDUAL, NOM01.NOM01ESTADO, NOM01.TIT01CODI, TIT01.TIT01DESC AS NOMBRE_CARGO
            FROM NOM01 LEFT JOIN TIT01 on NOM01.TIT01CODI= TIT01.TIT01CODI 
            WHERE NOM01.SEG04CODI = 'D.09.5' AND NOM01.NOM01ESTADO = 1 AND NOM01.NOM01CODI = :encargado_id");
            $consulta->bindParam(':encargado_id', $id);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            error_log('Error al listar Técnicos: ' . $e->getMessage());
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
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $conexion->beginTransaction();

            $sigID = $conexion->prepare("SELECT SOLICITUDMANTSISTEMAS_SEQ.NEXTVAL AS SOL_ID FROM dual");
            $sigID->execute();
            $result = $sigID->fetch(PDO::FETCH_ASSOC);
            $solicitudID = $result['SOL_ID'];

            $tipoMantenimientoString = implode(',', $tipoMantenimiento);
            $impresoraString = implode(',', $impresora);

            $solicitud = $conexion->prepare("
                INSERT INTO SolicitudMantSistemas (
                    SOL_ID,SOL_COD, SOL_MAC, SOL_IP, SOL_TIPOSOLICITUD, SOL_ENCARGADO,
                    SOL_TIPOMANTENIMIENTO, SOL_CEDTEC, SOL_CARGOTEC, SOL_DEPARTAMENTO,
                    SOL_RESPONSABLEBIEN, SOL_FECSOLICITUD, SOL_HORASOLICITUD, 
                    SOL_FECSOLICITUDF, SOL_HORASOLICITUDF, SOL_DETA, SOL_IMP
                ) VALUES (
                    :solicitudID,:codigo, :mac, :ip, :tipoSolicitud, :encargado,
                    :tipoMantenimiento, :cedula, :cargo, :departamento,
                    :responsableBien, TO_DATE(:fechaSolicitud, 'YYYY-MM-DD'), :horaSolicitud, 
                    TO_DATE(:fechaSolicitudF, 'YYYY-MM-DD'), :horaSolicitudF, :detalles, :impresora
                )
            ");

            $solicitud->bindParam(':solicitudID', $solicitudID);
            $solicitud->bindParam(':codigo', $codigo);
            $solicitud->bindParam(':mac', $mac);
            $solicitud->bindParam(':ip', $ip);
            $solicitud->bindParam(':tipoSolicitud', $tipoSolicitud);
            $solicitud->bindParam(':encargado', $encargado);
            $solicitud->bindParam(':tipoMantenimiento', $tipoMantenimientoString);
            $solicitud->bindParam(':cedula', $cedula);
            $solicitud->bindParam(':cargo', $cargo);
            $solicitud->bindParam(':departamento', $departamento);
            $solicitud->bindParam(':responsableBien', $responsableBien);
            $solicitud->bindParam(':fechaSolicitud', $fechaSolicitud);
            $solicitud->bindParam(':horaSolicitud', $horaSolicitud);
            $solicitud->bindParam(':fechaSolicitudF', $fechaSolicitudF);
            $solicitud->bindParam(':horaSolicitudF', $horaSolicitudF);
            $solicitud->bindParam(':detalles', $detalles);
            $solicitud->bindParam(':impresora', $impresoraString);

            $solicitud->execute();


            if ($tipoSolicitud === "Correctiva") {
                if (is_array($componentes) && !empty($componentes)) {
                    $componentesConsulta = $conexion->prepare("
                INSERT INTO MantSistemasComponentes (
                    SOL_ID, COMP_NOM, COMP_DESCRIP, COMP_SERIE, COMP_OBSER
                ) VALUES (
                    :solicitudID, :nombre, :descripcion, :serie, :observacion
                )
                ");
                    foreach ($componentes as $componente) {
                        if (empty($componente['nombre'])) {
                            continue; 
                        }
                        error_log("Procesando componente: " . print_r($componente, true));
                        $componentesConsulta->bindParam(':solicitudID', $solicitudID);
                        $componentesConsulta->bindParam(':nombre', $componente['nombre']);
                        $componentesConsulta->bindParam(':descripcion', $componente['descripcion']);
                        $componentesConsulta->bindParam(':serie', $componente['serie']);
                        $componentesConsulta->bindParam(':observacion', $componente['observacion']);
                        $componentesConsulta->execute();
                    }
                }
                if (is_array($cambios) && !empty($cambios)) {
                    $cambiosConsulta = $conexion->prepare("
                INSERT INTO MantSistemasCambios (
                    SOL_ID, CAMB_FEC, CAMB_NOM_COMP, CAMB_DESCRIP, CAMB_SERIE
                ) VALUES (
                    :solicitudID, TO_DATE(:fecha, 'YYYY-MM-DD'), :nombre, :descripcion, :serie
                )
                ");

                    foreach ($cambios as $cambio) {
                        if (empty($cambio['fechaCambio']) || empty($cambio['nombreComponente'])) {
                            continue; 
                        }
                        try {
                            $fechaCambio = DateTime::createFromFormat('d/m/Y', $cambio['fechaCambio'])->format('Y-m-d');
                            $cambiosConsulta->bindParam(':solicitudID', $solicitudID);
                            $cambiosConsulta->bindParam(':fecha', $fechaCambio);
                            $cambiosConsulta->bindParam(':nombre', $cambio['nombreComponente']);
                            $cambiosConsulta->bindParam(':descripcion', $cambio['descripcion']);
                            $cambiosConsulta->bindParam(':serie', $cambio['serie']);
                            $cambiosConsulta->execute();
                        } catch (PDOException $e) {
                            error_log("Error al insertar cambio: " . $e->getMessage());
                        }
                    }
                }
            }

            $conexion->commit();
            return $solicitudID;
        } catch (PDOException $e) {
            if ($conexion->inTransaction()) {
                $conexion->rollBack();
                error_log("Transacción deshecha.");
            }
            error_log('Error al insertar registro: ' . $e->getMessage());
            return array('status' => 'error', 'message' => 'Error al insertar el registro: ' . $e->getMessage());
        }
    }
}
?>