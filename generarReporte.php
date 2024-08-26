<?php
include_once('modelo/conexion.php');

if (isset($_GET['ids'])) {
    // Obtener los IDs únicos desde la solicitud GET
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

            $solicitudes = [];

            while ($row = oci_fetch_assoc($stid)) {
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
                        'fechaSolicitud' => $row['SOL_FECSOLICITUDF'],
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
            echo "<h2>Solicitud ID: $ids_str</h2>";
            echo "<h2>Solicitud ID: $solicitudID </h2>";
            // Imprimir los resultados
            foreach ($solicitudes as $solicitudID => $datos) {
                echo "<h2>Solicitud ID: $solicitudID</h2>";
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
        } catch (Exception $e) {
            error_log('Error al listar solicitudes: ' . $e->getMessage());
            echo 'Error al procesar la solicitud.';
        }
    }
}
?>
