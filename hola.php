<?php
include_once('ReportePDF.php');

$solicitudes = [
    60 => [
        'solicitudID' => 60,
        'codigo' => '9.1.1.17.07.00017.00007',
        'mac' => '50-EB-F6-D2-F2-67',
        'tipoSolicitud' => 'Correctiva',
        'tipoMantenimientoString' => '', // Vacío
        'responsableBien' => 'Diana Quevedo',
        'departamento' => 'BODEGA',
        'encargado' => 'KATHERINE STEFANIA LADINES GARCES',
        'fechaSolicitud' => '21-08-2024',
        'horaSolicitud' => '16:04',
        'fechaSolicitudF' => '22-08-2024',
        'horaSolicitudF' => '16:04',
        'detalles' => 'sd',
        'impresoraString' => '', // Vacío
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

// Generar el reporte PDF para todas las solicitudes
PDF::GenerarReportePDF($solicitudes);
?>
