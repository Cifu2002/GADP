<?php
include_once('conexion.php'); 
include_once('Sesion.php');   

function validarUsuario($usuario, $clave)
{
    global $conn;

    $consulta = "SELECT * FROM SOLICITUD_USUARIOS WHERE USUARIO = :usuario AND CLAVE = :clave";
    $stmt = oci_parse($conn, $consulta);

    oci_bind_by_name($stmt, ':usuario', $usuario);
    oci_bind_by_name($stmt, ':clave', $clave);

    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if ($row) {

        $sesion = Sesion::getInstance();
        $sesion->setSesion('usuario_id', $row['ID']);
        $sesion->setSesion('usuario_nombre', $row['NOM_APE']);

        oci_free_statement($stmt);

        return true; 
    } else {
        oci_free_statement($stmt);

        return false; 
    }
}
?>