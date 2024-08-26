<?php
include_once('modelo/conexion.php');
include_once('ReportePDF.php');

if (isset($_GET['ids'])) {
    // Obtener los IDs únicos desde la solicitud GET
    $ids = $_GET['ids'];
    echo 'IDs recibidos: ' . htmlspecialchars($ids); // Depurar IDs recibidos

    if (!empty($ids)) {
        try {
            echo 'Entro al try';
            // Conectar a la base de datos
            $conexion = Conexion::getInstance()->getConexion();

            // Preparar la consulta con los IDs recibidos
            $ids_str = implode(',', array_map('intval', explode(',', $ids))); // Convertir string a array y luego a lista de enteros
            $consulta = "
                SELECT 
                    s.SOL_ID AS solicitudID,
                    s.SOL_COD AS codigo,  
                    s.SOL_MAC AS mac, 
                    s.SOL_TIPOSOLICITUD AS tipoSolicitud, 
                    s.SOL_TIPOMANTENIMIENTO AS tipoMantenimientoString,
                    s.SOL_RESPONSABLEBIEN AS responsableBien, 
                    s.SOL_DEPARTAMENTO AS departamento,
                    s.SOL_ENCARGADO AS encargado,  
                    TO_CHAR(s.SOL_FECSOLICITUD, 'DD-MM-YYYY') AS fechaSolicitud,
                    s.SOL_HORASOLICITUD AS horaSolicitud, 
                    TO_CHAR(s.SOL_FECSOLICITUDF, 'DD-MM-YYYY') AS fechaSolicitudF,
                    s.SOL_HORASOLICITUDF AS horaSolicitudF,
                    c.CAMB_NOM_COMP AS cambioNombreComponente,
                    o.COMP_NOM AS componenteNombre,
                    s.SOL_DETA AS detalles,
                    s.SOL_IMP AS impresoraString
                FROM 
                    SOLICITUDMANTSISTEMAS s
                LEFT JOIN 
                    MANTSISTEMASCAMBIOS c ON s.SOL_ID = c.SOL_ID
                LEFT JOIN 
                    MANTSISTEMASCOMPONENTES o ON s.SOL_ID = o.SOL_ID
                WHERE 
                    s.SOL_ID IN ($ids_str)";

            $stid = oci_parse($conexion, $consulta);
            oci_execute($stid);
            echo 'Se ejecuto';
            // Inicializar el array de resultados
            $solicitudes = [];
            $b=0;
            while ($row = oci_fetch_assoc($stid)) {
                
                $solicitudID = $row['solicitudID']; // Nombre de columna en la consulta SQL
                echo 'bucle'.$b;
                $b=$b+1;
                // Verificar si ya existe una entrada para este ID
                if (!isset($solicitudes[$solicitudID])) {
                    $solicitudes[$solicitudID] = [
                        'solicitudID' => $row['solicitudID'],
                        'codigo' => $row['codigo'],
                        'mac' => $row['mac'],
                        'tipoSolicitud' => $row['tipoSolicitud'],
                        'tipoMantenimientoString' => $row['tipoMantenimientoString'],
                        'responsableBien' => $row['responsableBien'],
                        'departamento' => $row['departamento'],
                        'encargado' => $row['encargado'],
                        'fechaSolicitud' => $row['fechaSolicitud'],
                        'horaSolicitud' => $row['horaSolicitud'],
                        'fechaSolicitudF' => $row['fechaSolicitudF'],
                        'horaSolicitudF' => $row['horaSolicitudF'],
                        'detalles' => $row['detalles'],
                        'impresoraString' => $row['impresoraString'],
                        'componentes' => !empty($row['componenteNombre']) ? [$row['componenteNombre']] : [],
                        'cambios' => !empty($row['cambioNombreComponente']) ? [$row['cambioNombreComponente']] : [],
                    ];
                } else {
                    // Agregar los datos de componentes y cambios si existen
                    if (!empty($row['componenteNombre'])) {
                        $solicitudes[$solicitudID]['componentes'][] = $row['componenteNombre'];
                    }
                    if (!empty($row['cambioNombreComponente'])) {
                        $solicitudes[$solicitudID]['cambios'][] = $row['cambioNombreComponente'];
                    }
                }
            }

            // Cerrar conexión
            oci_free_statement($stid);
            oci_close($conexion);

            // Llamar a la función para generar el PDF
            PDF::GenerarReportePDF($solicitudes);
        } catch (Exception $e) {
            error_log('Error al listar solicitudes: ' . $e->getMessage());
            // Manejar el error si es necesario
        }
    }
} else {
    echo 'No se recibieron IDs válidos en la solicitud.';
}
?>
