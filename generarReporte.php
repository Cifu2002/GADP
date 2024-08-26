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
                    s.SOL_ID,
                    s.SOL_COD,  
                    s.SOL_MAC, 
                    s.SOL_TIPOSOLICITUD, 
                    s.SOL_TIPOMANTENIMIENTO,
                    s.SOL_RESPONSABLEBIEN, 
                    s.SOL_DEPARTAMENTO,
                    s.SOL_ENCARGADO,  
                    TO_CHAR(s.SOL_FECSOLICITUD, 'DD-MM-YYYY'),
                    s.SOL_HORASOLICITUD, 
                    TO_CHAR(s.SOL_FECSOLICITUDF, 'DD-MM-YYYY'),
                    s.SOL_HORASOLICITUDF,
                    c.CAMB_NOM_COMP,
                    o.COMP_NOM,
                    s.SOL_DETA,
                    s.SOL_IMP
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
                
                $solicitudID = $row['SOLICITUDID']; // Nombre de columna en la consulta SQL
                echo 'bucle'.$b;
                $b=$b+1;
                // Verificar si ya existe una entrada para este ID
                if (!isset($solicitudes[$solicitudID])) {
                    // Agregar una nueva entrada para este ID
                    $solicitudes[$solicitudID] = [
                        'solicitudID' => $row['SOLICITUDID'],
                        'codigo' => $row['CODIGO'],
                        'mac' => $row['MAC'],
                        'tipoSolicitud' => $row['TIPOSOLICITUD'],
                        'tipoMantenimientoString' => $row['TIPOMANTENIMIENTOSTRING'],
                        'responsableBien' => $row['RESPONSABLEBIEN'],
                        'departamento' => $row['DEPARTAMENTO'],
                        'encargado' => $row['ENCARGADO'],
                        'fechaSolicitud' => $row['FECHASOLICITUD'],
                        'horaSolicitud' => $row['HORASOLICITUD'],
                        'fechaSolicitudF' => $row['FECHASOLICITUDF'],
                        'horaSolicitudF' => $row['HORASOLICITUDF'],
                        'detalles' => $row['DETALLES'],
                        'impresoraString' => $row['IMPRESORASTRING'],
                        'componentes' => !empty($row['COMPONENTENOMBRE']) ? [$row['COMPONENTENOMBRE']] : [],
                        'cambios' => !empty($row['CAMBIONOMBRECOMPONENTE']) ? [$row['CAMBIONOMBRECOMPONENTE']] : [],
                    ];
                } else {
                    // Agregar los datos de componentes y cambios si existen
                    if (!empty($row['COMPONENTENOMBRE'])) {
                        $solicitudes[$solicitudID]['componentes'][] = $row['COMPONENTENOMBRE'];
                    }
                    if (!empty($row['CAMBIONOMBRECOMPONENTE'])) {
                        $solicitudes[$solicitudID]['cambios'][] = $row['CAMBIONOMBRECOMPONENTE'];
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
