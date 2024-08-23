
<?php
include_once('../modelo/Sesion.php');

$sesion = Sesion::getInstance();

$sesion->cerrarSesion();

header('Location: ../vista/login.php');
?>
