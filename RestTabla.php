<?php
include_once('ConsultasTabla.php');
$op = $_SERVER["REQUEST_METHOD"];
switch ($op) {
    case 'GET':
        echo ConsultasTabla::obtenerDatosTabla();
        $opG = filter_var($_GET['op'], FILTER_SANITIZE_STRING);
        switch ($opG) {
            case 1:

                break;
            case 2:

                break;
            default:
                break;
        }
        break;
    case 'POST':

        break;

    case "PUT":

        break;
    case "DELETE":

        break;
}
?>