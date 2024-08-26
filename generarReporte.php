<?php
include_once('modelo/conexion.php');
include_once('ReportePDF.php');

if (isset($_GET['ids'])) {
    // Obtener los IDs únicos desde la solicitud GET
    $ids = $_GET['ids'];
    echo 'IDs recibidos: ' . htmlspecialchars($ids); // Depurar IDs recibidos

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
                        'impresoraString' => $row['impresoraString'],
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


            print_r($solicitudes);

            // Imprimir los resultados
            foreach ($solicitudes as $solicitudID => $datos) {
                echo "<h2>Solicitud ID: $solicitudID</h2>";
                echo "<p>Código: {$datos['solicitudID']}</p>";
                echo "<p>Código: {$datos['codigo']}</p>";
                echo "<p>MAC: {$datos['mac']}</p>";
                echo "<p>Tipo de Solicitud: {$datos['tipoSolicitud']}</p>";
                echo "<p>Tipo de Mantenimiento: {$datos['tipoMantenimientoString']}</p>";
                echo "<p>Responsable del Bien: {$datos['responsableBien']}</p>";
                echo "<p>Departamento: {$datos['departamento']}</p>";
                echo "<p>Encargado: {$datos['encargado']}</p>";
                echo "<p>Fecha de Solicitud: {$datos['fechaSolicitud']}</p>";
                echo "<p>Hora de Solicitud: {$datos['horaSolicitud']}</p>";
                echo "<p>Fecha de Solicitud F: {$datos['fechaSolicitudF']}</p>";
                echo "<p>Hora de Solicitud F: {$datos['horaSolicitudF']}</p>";
                echo "<p>Detalles: {$datos['detalles']}</p>";
                echo "<p>Impresora: {$datos['impresoraString']}</p>";

                if (!empty($datos['componentes'])) {
                    echo "<h3>Componentes:</h3>";
                    echo "<ul>";
                    foreach ($datos['componentes'] as $componente) {
                        echo "<li>$componente</li>";
                    }
                    echo "</ul>";
                }

                if (!empty($datos['cambios'])) {
                    echo "<h3>Cambios:</h3>";
                    echo "<ul>";
                    foreach ($datos['cambios'] as $cambio) {
                        echo "<li>$cambio</li>";
                    }
                    echo "</ul>";
                }

                echo "<hr>";
            }
            echo "<pre>";
            print_r($solicitudes);
            echo "</pre>";
            echo "ANTES DE LLAMAR";
            PDF::GenerarReportePDF($solicitudes);
            echo "SE LLAMO?";
        } catch (Exception $e) {
            error_log('Error al listar solicitudes: ' . $e->getMessage());
            // Manejar el error si es necesario
        }
    }
} else {
    echo 'No se recibieron IDs válidos en la solicitud.';
}
?>