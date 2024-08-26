<?php
$solicitudes = [
    [
        'solicitudID' => 60,
        'codigo' => '9.1.1.17.07.00017.00007',
        'mac' => '50-EB-F6-D2-F2-67',
        'tipoSolicitud' => 'Correctiva',
        'tipoMantenimientoString' => '',
        'responsableBien' => 'Diana quevedo',
        'departamento' => 'BODEGA',
        'encargado' => 'KATHERINE STEFANIA LADINES GARCES',
        'fechaSolicitud' => '21-08-2024',
        'horaSolicitud' => '16:04',
        'fechaSolicitudF' => '22-08-2024',
        'horaSolicitudF' => '16:04',
        'detalles' => 'sd',
        'impresoraString' => '',
        'componentes' => [
            'Componente 1',
            'Componente 2'
        ],
        'cambios' => [
            'Cambio 1',
            'Cambio 2'
        ]
    ],
    [
        'solicitudID' => 61,
        'codigo' => '9.1.1.17.07.00017.00008',
        'mac' => '50-EB-F6-D2-F2-68',
        'tipoSolicitud' => 'Preventiva',
        'tipoMantenimientoString' => 'Mant. de rutina',
        'responsableBien' => 'Carlos Pérez',
        'departamento' => 'ADMINISTRACIÓN',
        'encargado' => 'JUAN PÉREZ',
        'fechaSolicitud' => '23-08-2024',
        'horaSolicitud' => '10:00',
        'fechaSolicitudF' => '24-08-2024',
        'horaSolicitudF' => '12:00',
        'detalles' => 'Revisión general',
        'impresoraString' => 'Impresora XYZ'
    ]
];

// Generar el reporte PDF para todas las solicitudes
PDF::GenerarReportePDF($solicitudes);
?>