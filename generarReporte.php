<?php
include_once('modelo/conexion.php');
include_once('ReportePDF.php');

if (isset($_GET['ids'])) {
    // Obtener los IDs únicos desde la solicitud GET
    $ids = $_GET['ids'];


    if (!empty($ids)) {
        try {
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
            // Inicializar el array de resultados
            $solicitudes = [];
            while ($row = oci_fetch_assoc($stid)) {
                $solicitudID = $row['SOLICITUDID'];
                // Verificar si ya existe una entrada para este ID
                if (!isset($solicitudes[$solicitudID])) {
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
                    // Evitar duplicados en componentes
                    if (!empty($row['COMPONENTENOMBRE']) && !in_array($row['COMPONENTENOMBRE'], $solicitudes[$solicitudID]['componentes'])) {
                        $solicitudes[$solicitudID]['componentes'][] = $row['COMPONENTENOMBRE'];
                    }

                    // Evitar duplicados en cambios
                    if (!empty($row['CAMBIONOMBRECOMPONENTE']) && !in_array($row['CAMBIONOMBRECOMPONENTE'], $solicitudes[$solicitudID]['cambios'])) {
                        $solicitudes[$solicitudID]['cambios'][] = $row['CAMBIONOMBRECOMPONENTE'];
                    }
                }
            }

            // Cerrar conexión
            oci_free_statement($stid);
            
            $solicitudes = [
                60 => [
                    'solicitudID' => 60,
                    'codigo' => '9.1.1.17.07.00017.00007',
                    'mac' => '50-EB-F6-D2-F2-67',
                    'tipoSolicitud' => 'Correctiva',
                    'tipoMantenimientoString' => '', // Campo vacío
                    'responsableBien' => 'Diana Quevedo',
                    'departamento' => 'BODEGA',
                    'encargado' => 'KATHERINE STEFANIA LADINES GARCES',
                    'fechaSolicitud' => '21-08-2024',
                    'horaSolicitud' => '16:04',
                    'fechaSolicitudF' => '22-08-2024',
                    'horaSolicitudF' => '16:04',
                    'detalles' => 'sd',
                    'impresoraString' => '', // Campo vacío
                    'componentes' => [
                        'componente 3',
                        'componente 2',
                        'componente 1'
                    ],
                    'cambios' => [
                        'fsdf',
                        'dsfsdf'
                    ]
                ]
            ];

            
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