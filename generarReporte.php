<?php
include_once('modelo/conexion.php');
include_once('ReportePDF.php');

if (isset($_GET['ids'])) {
    // Obtener los IDs únicos desde la solicitud GET
    $ids = $_GET['ids'];
    echo 'IDs recibidos: ' . htmlspecialchars($ids); // Depurar IDs recibidos

    if (!empty($ids)) {
        try {
            
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
            echo "<pre>";
            print_r($solicitudes);
            echo "</pre>";
            
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