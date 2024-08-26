<?php
include_once('modelo/conexion.php');
include_once('ReportePDF.php');

if (isset($_POST['ids'])) {
    // Obtener los IDs únicos desde la solicitud POST
    $ids = $_POST['ids'];

    if (!empty($ids)) {
        try {
            // Conectar a la base de datos
            $conexion = Conexion::getInstance()->getConexion();

            // Preparar la consulta con los IDs recibidos
            $ids_str = implode(',', array_map('intval', $ids)); // Convertir array a una lista de enteros
            $consulta = "
                SELECT 
                    s.SOL_ID AS ID, 
                    s.SOL_ENCARGADO AS ENCARGADO, 
                    s.SOL_RESPONSABLEBIEN AS RESPONSABLE, 
                    s.SOL_TIPOSOLICITUD AS SOLICITUD, 
                    TO_CHAR(s.SOL_FECSOLICITUD, 'DD-MM-YYYY') AS FECHA,
                    s.SOL_HORASOLICITUD AS HORA, 
                    TO_CHAR(s.SOL_FECSOLICITUDF, 'DD-MM-YYYY') AS FECHA_FINAL,
                    s.SOL_HORASOLICITUDF AS HORAF,
                    c.CAMB_NOM_COMP AS CAMBIO_NOMBRE_COMPONENTE,
                    o.COMP_NOM AS COMPONENTE_NOMBRE
                FROM 
                    SOLICITUDMANTSISTEMAS s
                LEFT JOIN 
                    MANTSISTEMASCAMBIOS c
                ON 
                    s.SOL_ID = c.SOL_ID
                LEFT JOIN 
                    MANTSISTEMASCOMPONENTES o
                ON 
                    s.SOL_ID = o.SOL_ID
                WHERE 
                    s.SOL_ID IN ($ids_str)"; // Filtrar solo los IDs recibidos

            $stid = oci_parse($conexion, $consulta);
            oci_execute($stid);

            $solicitudes = [];

            while ($row = oci_fetch_assoc($stid)) {
                $solicitudes[] = $row; // Almacenar cada fila en el array
            }

            oci_free_statement($stid);
            oci_close($conexion);

            // Generar el PDF con los datos obtenidos
            PDF::GenerarReportePDF($solicitudes);

        } catch (Exception $e) {
            error_log('Error al listar solicitudes: ' . $e->getMessage());
            // Manejar el error si es necesario
        }
    }
}
?>
