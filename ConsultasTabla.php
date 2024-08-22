<?php
include_once("conexion.php");

class ConsultasTabla
{
    public static function obtenerDatosTabla()
    {
        try {
            // Obtener la conexión
            $conexion = Conexion::getInstance()->getConexion();

            // Consulta SQL para obtener los datos de las tablas SOLICITUDMANTSISTEMAS y MANTSISTEMASCAMBIOS
            $consulta = "
                SELECT 
                    s.SOL_ID AS ID, 
                    s.SOL_ENCARGADO AS ENCARGADO, 
                    s.SOL_RESPONSABLEBIEN AS RESPONSABLE, 
                    s.SOL_TIPOSOLICITUD AS SOLICITUD, 
                    TO_CHAR(s.SOL_FECSOLICITUD, 'DD-MM-YYYY') AS FECHA,
                    c.CAMB_NOM_COMP AS CAMBIO_NOMBRE_COMPONENTE,
                    c.CAMB_SERIE AS SERIE
                FROM 
                    SOLICITUDMANTSISTEMAS s
                LEFT JOIN 
                    MANTSISTEMASCAMBIOS c
                ON 
                    s.SOL_ID = c.SOL_ID";

            // Preparar y ejecutar la consulta
            $stid = oci_parse($conexion, $consulta);
            oci_execute($stid);

            // Array para almacenar los resultados
            $resultados = [];

            // Recorrer los resultados de la consulta
            while ($fila = oci_fetch_assoc($stid)) {
                $resultados[] = [
                    'ID' => $fila['ID'],
                    'ENCARGADO' => $fila['ENCARGADO'],
                    'RESPONSABLE' => $fila['RESPONSABLE'],
                    'SOLICITUD' => $fila['SOLICITUD'],
                    'FECHA' => $fila['FECHA'],
                    'CAMBIO_NOMBRE_COMPONENTE' => $fila['CAMBIO_NOMBRE_COMPONENTE'],
                    'SERIE' => $fila['SERIE']
                ];
            }

            // Liberar los recursos y cerrar la conexión
            oci_free_statement($stid);
            oci_close($conexion);

            // Retornar los resultados en formato JSON
            return json_encode($resultados);

        } catch (Exception $e) {
            // Registrar el error en el log
            error_log('Error al obtener datos de la tabla: ' . $e->getMessage());

            // Retornar un JSON con un mensaje de error
            return json_encode(['error' => 'Error al obtener datos de la tabla']);
        }
    }
}
?>
