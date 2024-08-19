<?php
include_once("Consultas.php");
$mac = isset($_GET['mac']) ? $_GET['mac'] : null;
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : null;
$departamento = isset($_GET['departamento']) ? $_GET['departamento'] : null;
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;
$porCodigo = isset($_GET['porCodigo']) ? $_GET['porCodigo'] : null;
$valido = false;
$causa = '';
$departamentos = Consultas::listarDepartamentos(trim($departamento));

if ($usuario !== null || $departamento !== null || $codigo !== null) {
    if ($usuario !== null && validarExistencia('USUARIO', $usuario) === null) {
        $valido = false;
        $causa = 'Usuario no encontrado';
    } else if ($departamento !== null && validarExistencia('DEPARTAMENTO', $departamento) === null) {
        $valido = false;
        $causa = 'Departamento no encontrado';
    } else if ($codigo !== null && validarExistencia('PC_COD_AF', $codigo) === null) {
        $valido = false;
        $causa = 'Código no encontrado';
    } else {
        $valido = true;
    }

   
}
function validarExistencia($columna, $valor)
{
    function normalize($text)
    {
        $search = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ'];
        $replace = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N'];
        return str_replace($search, $replace, $text);
    }

    // Normalizar el valor antes de la consulta
    $valorNormalizado = normalize($valor);

    try {
        $conexion = Conexion::getInstance()->getConexion();
        // Usa una consulta SQL parametrizada para evitar problemas de inyección SQL
        $consulta = "SELECT $columna FROM INVENTARIOEQUIPOS WHERE $columna = :valor";
        $stid = oci_parse($conexion, $consulta);

        // Vincular el valor normalizado
        oci_bind_by_name($stid, ':valor', $valorNormalizado);
        oci_execute($stid);

        // Recuperar el resultado
        $resultado = oci_fetch_assoc($stid);
        oci_free_statement($stid);
        oci_close($conexion);

        // Normalizar el resultado obtenido y devolverlo
        if ($resultado) {
            echo normalize($resultado[$columna]);
        } else {
            echo "No se encontró el valor.";
        }
    } catch (Exception $e) {
        error_log("Error al validar $columna: " . $e->getMessage());
        echo "Error al realizar la consulta.";
    }
}
?>