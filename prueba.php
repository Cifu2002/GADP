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

    if (!$valido) {
        header("Location: index.php?error=$causa&val=$valido");
        die();
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
            $consulta = "SELECT $columna FROM INVENTARIOEQUIPOS WHERE normalize($columna) = :valor";
            $stid = oci_parse($conexion, $consulta);

            // Normalizar el valor antes de pasarlo a la consulta
            oci_bind_by_name($stid, ':valor', $valorNormalizado);
            oci_execute($stid);

            // Recuperar el resultado y normalizarlo para la comparación
            $resultado = oci_fetch_assoc($stid);
            oci_free_statement($stid);
            oci_close($conexion);

            // Normalizar el resultado obtenido
            return $resultado ? normalize($resultado[$columna]) : null;
        } catch (Exception $e) {
            error_log("Error al validar $columna: " . $e->getMessage());
            return null;
        }
    }
?>