<?php
include_once('modelo/conexion.php');
include_once('ReportePDF.php');
//Obtener ID
try {
    $conexion = Conexion::getInstance()->getConexion();
    $consulta = "
        SELECT 
            s.SOL_ID AS ID, 
            s.SOL_ENCARGADO AS ENCARGADO, 
            s.SOL_RESPONSABLEBIEN AS RESPONSABLE, 
            s.SOL_TIPOSOLICITUD AS SOLICITUD, 
            TO_CHAR(s.SOL_FECSOLICITUD, 'DD-MM-YYYY') AS FECHA,
            s.SOL_HORASOLICITUD AS HORA, 
            TO_CHAR(s.SOL_FECSOLICITUDF, 'DD-MM-YYYY') AS FECHA_FINAL,
            s.SOL_HORASOLICITUDF AS HORAF,
            c.CAMB_NOM_COMP AS CAMBIO_NOMBRE_COMPONENTE,
            o.COMP_NOM AS COMPONENTE_NOMBRE
        FROM 
            SOLICITUDMANTSISTEMAS s
        LEFT JOIN 
            MANTSISTEMASCAMBIOS c
        ON 
            s.SOL_ID = c.SOL_ID
        LEFT JOIN 
            MANTSISTEMASCOMPONENTES o
        ON 
            s.SOL_ID = o.SOL_ID";

    $stid = oci_parse($conexion, $consulta);
    oci_execute($stid);
    
    oci_free_statement($stid);
    oci_close($conexion);

    return $opciones;
} catch (Exception $e) {
    error_log('Error al listar Técnicos: ' . $e->getMessage());
    return '<option value="">Error al cargar técnicos</option>';
}
/* Generar PDF preventivo */
if ($tipoSolicitud === 'Preventiva') {
    $tipoMantenimientoString = implode(',', $tipoMantenimiento);
    PDF::GenerarReportePDF(
        $solicitudID,
        $codigo,
        $mac,
        $tipoSolicitud,
        $tipoMantenimientoString,
        $responsableBien,
        $departamento,
        $encargado,
        $fechaSolicitud,
        $horaSolicitud,
        $fechaSolicitudF,
        $horaSolicitudF,
        $detalles,
        $impresoraString
    );
}

/* Generar PDF correctivo */
if ($tipoSolicitud === 'Correctiva') {
    PDF::GenerarPDFCorrectivo(
        $solicitudID,
        $codigo,
        $mac,
        $tipoSolicitud,
        $responsableBien,
        $departamento,
        $encargado,
        $fechaSolicitud,
        $horaSolicitud,
        $fechaSolicitudF,
        $horaSolicitudF,
        $detalles,
        $impresoraString,
        $componentes,
        $cambios
    );
}
?>