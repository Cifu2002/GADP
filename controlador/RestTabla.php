<?php
include_once('../modelo/ConsultasTabla.php');
$op = $_SERVER["REQUEST_METHOD"];
switch ($op) {
    case 'GET':
        echo ConsultasTabla::obtenerDatosTabla();
        $opG = filter_var($_GET['op'], FILTER_SANITIZE_STRING);
        break;
    case 'POST':

        break;

    case "PUT":

        break;
    case "DELETE":

        break;
}
?>