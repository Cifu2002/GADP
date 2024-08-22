<?php
include_once("conexion.php");

class ConsultasTabla
{
    public static function obtenerDatosTabla()
    {
        try {
            // Obtener la conexión
            $conexion = Conexion::getInstance()->getConexion();

            // Consulta SQL para obtener los datos solo de SOLICITUDMANTSISTEMAS
            $consulta = "
                SELECT 
                    SOL_ID AS ID, 
                    SOL_ENCARGADO AS ENCARGADO, 
                    SOL_RESPONSABLEBIEN AS RESPONSABLE, 
                    SOL_TIPOSOLICITUD AS SOLICITUD, 
                    TO_CHAR(SOL_FECSOLICITUD, 'DD-MM-YYYY') AS FECHA
                FROM 
                    SOLICITUDMANTSISTEMAS";

            // Preparar y ejecutar la consulta
            $stid = oci_parse($conexion, $consulta);
            oci_execute($stid);

            // Array para almacenar los resultados
            $resultados = [];

            // Recorrer los resultados de la consulta
            while ($fila = oci_fetch_assoc($stid)) {
                $resultados[] = $fila;
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
