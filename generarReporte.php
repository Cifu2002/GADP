<?php
include_once('modelo/conexion.php');
include_once('ReportePDF.php');

if (isset($_GET['ids'])) {
    // Obtener los IDs únicos desde la solicitud POST
    $ids = $_GET['ids'];

    if (!empty($ids)) {
        try {
            // Conectar a la base de datos
            $conexion = Conexion::getInstance()->getConexion();

            // Preparar la consulta con los IDs recibidos
            $ids_str = implode(',', array_map('intval', $ids)); // Convertir array a una lista de enteros
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
            // Filtrar solo los IDs recibidos

            $stid = oci_parse($conexion, $consulta);
            oci_execute($stid);

            oci_free_statement($stid);
            oci_close($conexion);

            // Inicializar el array de resultados
            $solicitudes = [];

            while ($row = oci_fetch_assoc($stid)) {
                $solicitudID = $row['SOLICITUDID']; // Nombre de columna en la consulta SQL

                // Verificar si ya existe una entrada para este ID
                if (isset($solicitudes[$solicitudID])) {
                    // Agregar los datos de componentes y cambios si existen
                    if (!empty($row['COMPONENTENOMBRE'])) {
                        $solicitudes[$solicitudID]['componentes'][] = $row['COMPONENTENOMBRE'];
                    }
                    if (!empty($row['CAMBIONOMBRECOMPONENTE'])) {
                        $solicitudes[$solicitudID]['cambios'][] = $row['CAMBIONOMBRECOMPONENTE'];
                    }
                } else {
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
}
?>