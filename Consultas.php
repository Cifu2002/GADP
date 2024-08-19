<?php
include_once("conexion.php");

class Consultas
{
    /* Listar */
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

    public static function listarDepartamentos()
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            // Consulta para excluir valores NULL y ordenar alfabéticamente
            $consulta = "SELECT DISTINCT DEPARTAMENTO FROM INVENTARIOEQUIPOS 
                     WHERE DEPARTAMENTO IS NOT NULL 
                     ORDER BY DEPARTAMENTO";
            $stid = oci_parse($conexion, $consulta);
            oci_execute($stid);

            $opciones = '';
            while (($fila = oci_fetch_assoc($stid)) !== false) {
                // Asegúrate de que los valores están siendo capturados correctamente
                $departamento = htmlspecialchars($fila['DEPARTAMENTO'], ENT_QUOTES, 'UTF-8');
                if (!empty($departamento)) {
                    $opciones .= '<option value="' . $departamento . '">' . $departamento . '</option>';
                }
            }

            oci_free_statement($stid);
            oci_close($conexion);

            return $opciones;
        } catch (Exception $e) {
            error_log('Error al listar departamentos: ' . $e->getMessage());
            return '<option value="">Error al cargar departamentos</option>';
        }
    }




    /* VALIDAR EXISTENCIA */
    /* public static function validarUsuario($nombreUsuario)
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = "SELECT USUARIO FROM INVENTARIOEQUIPOS WHERE USUARIO = :nombreUsuario";
            $stid = oci_parse($conexion, $consulta);

            // Bind del parámetro :nombreUsuario
            oci_bind_by_name($stid, ':nombreUsuario', $nombreUsuario);

            oci_execute($stid);

            $usuario = oci_fetch_assoc($stid);

            oci_free_statement($stid);
            oci_close($conexion);

            // Si el usuario existe, retorna el nombre del usuario, de lo contrario retorna null
            return $usuario ? $usuario['USUARIO'] : null;
        } catch (Exception $e) {
            error_log('Error al validar usuario: ' . $e->getMessage());
            return null;
        }
    }

    public static function validarDepartamentos($departamento)
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = "SELECT DEPARTAMENTO FROM INVENTARIOEQUIPOS WHERE DEPARTAMENTO = :departamento";
            $stid = oci_parse($conexion, $consulta);

            // Bind del parámetro :nombreUsuario
            oci_bind_by_name($stid, ':departamento', $departamento);

            oci_execute($stid);

            $departamento = oci_fetch_assoc($stid);

            oci_free_statement($stid);
            oci_close($conexion);

            // Si el usuario existe, retorna el nombre del usuario, de lo contrario retorna null
            return $departamento ? $departamento['DEPARTAMENTO'] : null;
        } catch (Exception $e) {
            error_log('Error al validar el departamento: ' . $e->getMessage());
            return null;
        }
    }

    public static function validarCodigo($codigo)
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = "SELECT PC_COD_AF FROM INVENTARIOEQUIPOS WHERE PC_COD_AF = :codigo";
            $stid = oci_parse($conexion, $consulta);

            // Bind del parámetro :nombreUsuario
            oci_bind_by_name($stid, ':codigo', $codigo);

            oci_execute($stid);

            $codigo = oci_fetch_assoc($stid);

            oci_free_statement($stid);
            oci_close($conexion);

            // Si el usuario existe, retorna el nombre del usuario, de lo contrario retorna null
            return $codigo ? $codigo['PC_COD_AF'] : null;
        } catch (Exception $e) {
            error_log('Error al validar el codigo: ' . $e->getMessage());
            return null;
        }
    }
 */
    public static function validarExistencia($columna, $valor)
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = "SELECT $columna FROM INVENTARIOEQUIPOS WHERE $columna = :valor";
            $stid = oci_parse($conexion, $consulta);
            oci_bind_by_name($stid, ':valor', $valor);
            oci_execute($stid);
            $resultado = oci_fetch_assoc($stid);
            oci_free_statement($stid);
            oci_close($conexion);
            return $resultado ? $resultado[$columna] : null;
        } catch (Exception $e) {
            error_log("Error al validar $columna: " . $e->getMessage());
            return null;
        }
    }

    /* OBTENER DATOS */
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

    public static function obtenerDatosDepartamento($departamento, $usuarioSeleccionado = null)
    {
        function normalize($text)
        {
            $search = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ'];
            $replace = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N'];
            return str_replace($search, $replace, preg_replace('/\s+/', ' ', trim($text)));
        }

        $normalizedDepartamento = normalize($departamento);

        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = "SELECT DISTINCT USUARIO, DEPARTAMENTO FROM INVENTARIOEQUIPOS";
            $stid = oci_parse($conexion, $consulta);
            oci_execute($stid);

            $opciones = '';
            while (($fila = oci_fetch_assoc($stid)) !== false) {
                $usuario = htmlspecialchars(trim($fila['USUARIO']));
                $departamentoBD = htmlspecialchars(trim($fila['DEPARTAMENTO']));

                if (normalize($departamentoBD) === $normalizedDepartamento) {
                    $seleccionado = ($usuario === $usuarioSeleccionado) ? 'selected' : '';
                    $opciones .= '<option value="' . htmlspecialchars($usuario) . '" ' . $seleccionado . '>' . htmlspecialchars($usuario) . '</option>';
                }
            }

            oci_free_statement($stid);
            oci_close($conexion);

            return $opciones;
        } catch (Exception $e) {
            error_log('Error al listar usuarios por departamento: ' . $e->getMessage());
            return '<option value="">Error al cargar usuarios</option>';
        }
    }



    public static function obtenerDatosMacDepartamentoUsuario($pcCodAf)
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = "SELECT USUARIO, DEPARTAMENTO, MAC FROM INVENTARIOEQUIPOS WHERE PC_COD_AF = :pcCodAf";
            $stid = oci_parse($conexion, $consulta);
            oci_bind_by_name($stid, ':pcCodAf', $pcCodAf);
            oci_execute($stid);

            $resultado = oci_fetch_assoc($stid);
            oci_free_statement($stid);
            oci_close($conexion);

            if ($resultado) {
                return json_encode([
                    'usuario' => htmlspecialchars($resultado['USUARIO']),
                    'departamento' => htmlspecialchars($resultado['DEPARTAMENTO']),
                    'mac' => htmlspecialchars($resultado['MAC'])
                ]);
            } else {
                return json_encode(['error' => 'No se encontró ningún registro con el código especificado.']);
            }
        } catch (Exception $e) {
            error_log('Error al obtener información por el código: ' . $e->getMessage());
            return json_encode(['error' => 'Ocurrió un error al procesar la solicitud.']);
        }
    }

    public static function obtenerDatosporMac($mac)
    {
        try {
            $conexion = Conexion::getInstance()->getConexion();
            $consulta = "SELECT USUARIO, DEPARTAMENTO, PC_COD_AF FROM INVENTARIOEQUIPOS WHERE MAC = :mac";
            $stid = oci_parse($conexion, $consulta);
            oci_bind_by_name($stid, ':mac', $mac);
            oci_execute($stid);

            $resultado = oci_fetch_assoc($stid);
            oci_free_statement($stid);
            oci_close($conexion);

            if ($resultado) {
                return json_encode([
                    'usuario' => htmlspecialchars($resultado['USUARIO']),
                    'departamento' => htmlspecialchars($resultado['DEPARTAMENTO']),
                    'codigo' => htmlspecialchars($resultado['PC_COD_AF'])
                ]);
            } else {
                return json_encode(['error' => 'No se encontró ningún registro con la mac especificado.']);
            }
        } catch (Exception $e) {
            error_log('Error al obtener información por la mac: ' . $e->getMessage());
            return json_encode(['error' => 'Ocurrió un error al procesar la solicitud.']);
        }
    }



    /* INSERTAR */
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