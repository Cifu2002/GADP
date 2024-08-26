<?php
include_once('modelo/conexion.php');
include_once('ReportePDF.php');

if (isset($_GET['ids'])) {
    // Obtener los IDs únicos desde la solicitud GET
    $ids = $_GET['ids'];

    if (!empty($ids) && is_array($ids)) {
        try {
            // Conectar a la base de datos
            $conexion = Conexion::getInstance()->getConexion();
            if (!$conexion) {
                die('Error de conexión a la base de datos');
            }

            // Preparar la consulta con los IDs recibidos
            $ids_str = implode(',', array_map('intval', $ids)); // Convertir array a una lista de enteros
            $consulta = "
                SELECT 
                    s.SOL_ID AS SOL_ID,
                    s.SOL_COD AS SOL_COD,  
                    s.SOL_MAC AS SOL_MAC, 
                    s.SOL_TIPOSOLICITUD AS SOL_TIPOSOLICITUD, 
                    s.SOL_TIPOMANTENIMIENTO AS SOL_TIPOMANTENIMIENTO,
                    s.SOL_RESPONSABLEBIEN AS SOL_RESPONSABLEBIEN, 
                    s.SOL_DEPARTAMENTO AS SOL_DEPARTAMENTO,
                    s.SOL_ENCARGADO AS SOL_ENCARGADO,  
                    TO_CHAR(s.SOL_FECSOLICITUD, 'DD-MM-YYYY') AS SOL_FECSOLICITUD,
                    s.SOL_HORASOLICITUD AS SOL_HORASOLICITUD,
                    TO_CHAR(s.SOL_FECSOLICITUDF, 'DD-MM-YYYY') AS FECHASOLICITUDF,
                    s.SOL_HORASOLICITUDF AS SOL_HORASOLICITUDF,
                    c.CAMB_NOM_COMP AS CAMB_NOM_COMP,
                    o.COMP_NOM AS COMP_NOM,
                    s.SOL_DETA AS SOL_DETA,
                    s.SOL_IMP AS SOL_IMP
                FROM 
                    SOLICITUDMANTSISTEMAS s
                LEFT JOIN 
                    MANTSISTEMASCAMBIOS c ON s.SOL_ID = c.SOL_ID
                LEFT JOIN 
                    MANTSISTEMASCOMPONENTES o ON s.SOL_ID = o.SOL_ID
                WHERE 
                    s.SOL_ID IN ($ids_str)";

            // Ejecutar la consulta
            $stid = oci_parse($conexion, $consulta);
            if (!$stid) {
                $e = oci_error($conexion);
                die("Error al preparar la consulta: " . $e['message']);
            }

            $r = oci_execute($stid);
            if (!$r) {
                $e = oci_error($stid);
                die("Error al ejecutar la consulta: " . $e['message']);
            }

            // Inicializar el array de resultados
            $solicitudes = [];

            // Depuración: Imprimir antes del bucle
            echo "Ejecutando la consulta...\n";

            while ($row = oci_fetch_assoc($stid)) {
                echo '<pre>';
                print_r($row);
                echo '</pre>'; // Imprimir cada fila para depuración

                $solicitudID = $row['SOL_ID']; // Nombre de columna en la consulta SQL

                // Verificar si ya existe una entrada para este ID
                if (!isset($solicitudes[$solicitudID])) {
                    // Agregar una nueva entrada para este ID
                    $solicitudes[$solicitudID] = [
                        'solicitudID' => $row['SOL_ID'],
                        'codigo' => $row['SOL_COD'],
                        'mac' => $row['SOL_MAC'],
                        'tipoSolicitud' => $row['SOL_TIPOSOLICITUD'],
                        'tipoMantenimientoString' => $row['SOL_TIPOMANTENIMIENTO'],
                        'responsableBien' => $row['SOL_RESPONSABLEBIEN'],
                        'departamento' => $row['SOL_DEPARTAMENTO'],
                        'encargado' => $row['SOL_ENCARGADO'],
                        'fechaSolicitud' => $row['SOL_FECSOLICITUD'],
                        'horaSolicitud' => $row['SOL_HORASOLICITUD'],
                        'fechaSolicitudF' => $row['FECHASOLICITUDF'],
                        'horaSolicitudF' => $row['SOL_HORASOLICITUDF'],
                        'detalles' => $row['SOL_DETA'],
                        'impresoraString' => $row['SOL_IMP'],
                        'componentes' => [],
                        'cambios' => [],
                    ];
                }

                // Agregar los datos de componentes y cambios si existen
                if (!empty($row['COMP_NOM'])) {
                    $solicitudes[$solicitudID]['componentes'][] = $row['COMP_NOM'];
                }
                if (!empty($row['CAMB_NOM_COMP'])) {
                    $solicitudes[$solicitudID]['cambios'][] = $row['CAMB_NOM_COMP'];
                }
            }

            // Cerrar conexión
            oci_free_statement($stid);
            oci_close($conexion);

            // Imprimir el array final para depuración
            echo '<pre>';
            print_r($solicitudes);
            echo '</pre>';

            // Llamar a la función para generar el PDF
            PDF::GenerarReportePDF($solicitudes);
        } catch (Exception $e) {
            error_log('Error al listar solicitudes: ' . $e->getMessage());
            // Manejar el error si es necesario
        }
    }
}
?>