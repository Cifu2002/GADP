<?php
require 'assets/librerias/ImportarExcel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Excel
{
    public static function listarDepartamentos($departamentoSeleccionado)
    {
        try {
            // Cargar el archivo Excel
            $archivo = 'assets/archivos/Inventarioequipos2024-enero.xlsx';
            if (!file_exists($archivo)) {
                throw new Exception("El archivo no existe: $archivo");
            }
            $spreadsheet = IOFactory::load($archivo);
            /* Escoger el nombre de la hoja */
            $hoja = $spreadsheet->getSheetByName("Inventario a mayo 2021");
            $datos = $hoja->toArray();

            // Buscar la columna "DEPARTAMENTO"
            $indiceColumnaDepartamento = null;
            foreach ($datos as $fila) {
                foreach ($fila as $indice => $valor) {
                    if (strcasecmp(trim($valor), 'DEPARTAMENTO') === 0) {
                        $indiceColumnaDepartamento = $indice;
                        break 2; // Rompe ambos bucles cuando se encuentra la columna
                    }
                }
            }

            if ($indiceColumnaDepartamento === null) {
                throw new Exception("La columna 'DEPARTAMENTO' no se encontró en el archivo.");
            }
            $departamentoSeleccionado = trim($departamentoSeleccionado);

            // Imprimir todas las filas de la columna "DEPARTAMENTO"
            $opciones = '';
            for ($i = 1; $i < count($datos); $i++) {
                $departamento = htmlspecialchars(trim($datos[$i][$indiceColumnaDepartamento]));
                if ($departamento != null) {
                    $selected = ($departamentoSeleccionado !== null && $departamento === $departamentoSeleccionado) ? 'selected' : '';
                    $opciones .= '<option value="' . $departamento . '" ' . $selected . '>' . $departamento . '</option>';
                }
            }
            return $opciones;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    }

    public static function obtenerDatosDepartamento($id_departamento, $usuario)
    {
        try {
            
            $archivo = 'assets/archivos/Inventarioequipos2024-enero.xlsx';
            $spreadsheet = IOFactory::load($archivo);
            
            $hoja = $spreadsheet->getSheetByName("Inventario a mayo 2021");
            
            if (!file_exists($archivo)) {
                throw new Exception("El archivo no existe: $archivo");
            }
            
            $celdaDepartamento = encontrarCeldaPorValor($hoja, $id_departamento);
       
            $resultado = obtenerValorSigColumna($hoja, $celdaDepartamento);
            $opciones = '';
            
            $datoAnterior = null;
            foreach ($resultado as $dato) {
                if ($datoAnterior !== $dato) {
                    $selected = ($usuario !== null && $dato === $usuario) ? 'selected' : '';
                    $opciones .= '<option value="' . $dato . '"' . $selected . '>' . $dato . '</option>';
                    $datoAnterior = $dato;
                }
            }
            return $opciones;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public static function obtenerDatosMacDepartamentoUsuario($codigo)
    {
        try {
            /* Cargar Excel */
            $archivo = 'assets/archivos/Inventarioequipos2024-enero.xlsx';
            $spreadsheet = IOFactory::load($archivo);
            /* Escoger el nombre de la hoja */
            $hoja = $spreadsheet->getSheetByName("Inventario a mayo 2021");
            /* Si el archivo no existe */
            if (!file_exists($archivo)) {
                throw new Exception("El archivo no existe: $archivo");
            }
            /* Encontrar celda del departamento */
            $celdaCodigo = encontrarCeldaPorValor($hoja, $codigo);
            /* Buscar los usuarios del departamento */
            if ($celdaCodigo === null) {
                return null;
            }
            $resultado = obtenerValoresDosColumnasAnteriores($hoja, $celdaCodigo);
            return $resultado;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public static function obtenerDatosporMac($mac)
    {
        try {
            /* Cargar Excel */
            $archivo = 'assets/archivos/Inventarioequipos2024-enero.xlsx';
            $spreadsheet = IOFactory::load($archivo);
            /* Escoger el nombre de la hoja */
            $hoja = $spreadsheet->getSheetByName("Inventario a mayo 2021");
            /* Si el archivo no existe */
            if (!file_exists($archivo)) {
                throw new Exception("El archivo no existe: $archivo");
            }
            /* Encontrar celda del departamento */
            $celdaCodigo = encontrarCeldaPorValor($hoja, $mac);
            /* Buscar los usuarios del departamento */
            if ($celdaCodigo === null) {
                return null;
            }
            $resultado = obtenerValoresAnterioresPorMac($hoja, $celdaCodigo);
            return $resultado;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
function encontrarCeldaPorValor(Worksheet $sheet, string $valorBuscado)
{
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    for ($fila = 1; $fila <= $highestRow; $fila++) {
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $cellAddress = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $fila;
            $cellValue = $sheet->getCell($cellAddress)->getValue();
            if (strcasecmp(trim($cellValue), $valorBuscado) === 0) {
                return $cellAddress;
            }
        }
    }

    return null;
}
function validarExistencia(string $valorBuscado)
{
    try {
        /* Cargar Excel */
        $archivo = 'assets/archivos/Inventarioequipos2024-enero.xlsx';
        $spreadsheet = IOFactory::load($archivo);
        /* Escoger el nombre de la hoja */
        $sheet = $spreadsheet->getSheetByName("Inventario a mayo 2021");
        /* Si el archivo no existe */
        if (!file_exists($archivo)) {
            throw new Exception("El archivo no existe: $archivo");
        }
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        for ($fila = 1; $fila <= $highestRow; $fila++) {
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $cellAddress = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $fila;
                $cellValue = $sheet->getCell($cellAddress)->getValue();
                if (strcasecmp(trim($cellValue), $valorBuscado) === 0) {
                    return $cellAddress;
                }
            }
        }

        return null;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}
function obtenerValorSigColumna(Worksheet $sheet, string $cellAddress)
{
    $mergedCells = $sheet->getMergeCells();
    $resultado = [];

    // Comprobar si la celda actual es parte de un rango combinado
    foreach ($mergedCells as $mergedCellRange) {
        $mergedCellArea = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::extractAllCellReferencesInRange($mergedCellRange);

        if (in_array($cellAddress, $mergedCellArea)) {
            // Celda parte de un rango combinado
            list($columnaInicio, $filaInicio) = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($mergedCellArea[0]);
            list($columnaFin, $filaFin) = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString(end($mergedCellArea));

            // Obtener la siguiente columna
            $columnaActualIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($columnaInicio);
            $siguienteColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaActualIndex + 1);

            // Obtener todos los valores de la columna siguiente
            for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                $nextCellAddress = $siguienteColumna . $fila;
                $resultado[] = $sheet->getCell($nextCellAddress)->getValue();
            }

            return $resultado;
        }
    }

    // Si la celda no es parte de un rango combinado, manejar el caso normal
    list($columnaActual, $fila) = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($cellAddress);
    $columnaActualIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($columnaActual);
    $siguienteColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaActualIndex + 1);
    $nextCellAddress = $siguienteColumna . $fila;

    // Obtener el valor de la celda en la columna siguiente
    $resultado[] = $sheet->getCell($nextCellAddress)->getValue();

    return $resultado;
}

function obtenerValoresDosColumnasAnteriores(Worksheet $sheet, string $celdaDirecc)
{
    $celdasCombinadas = $sheet->getMergeCells();
    $result = [];

    // Función para obtener el valor de una celda, considerando si es parte de un rango combinado
    function obtenerValorCelda(Worksheet $sheet, string $celdaDirecc, array $celdasCombinadas)
    {
        foreach ($celdasCombinadas as $mergedCellRange) {
            $celdaCombinadaArea = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::extractAllCellReferencesInRange($mergedCellRange);
            if (in_array($celdaDirecc, $celdaCombinadaArea)) {
                return $sheet->getCell($celdaCombinadaArea[0])->getValue();
            }
        }
        return $sheet->getCell($celdaDirecc)->getValue();
    }

    // Comprobar si la celda actual es parte de un rango combinado
    foreach ($celdasCombinadas as $mergedCellRange) {
        $celdaCombinadaArea = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::extractAllCellReferencesInRange($mergedCellRange);

        if (in_array($celdaDirecc, $celdaCombinadaArea)) {
            // La celda es parte de un rango combinado
            list($columnaInicio, $filaInicio) = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($celdaCombinadaArea[0]);
            list($columnaFin, $filaFin) = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString(end($celdaCombinadaArea));

            // Obtener las dos columnas anteriores para todas las filas en el rango combinado
            $columnaInicioIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($columnaInicio);
            $columnaUsuario = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaInicioIndex - 1);
            $columnaDepartamento = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaInicioIndex - 2);
            $columnaMac = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaInicioIndex + 1);
            for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                $prevceldaDirecc1 = $columnaUsuario . $fila;
                $prevceldaDirecc2 = $columnaDepartamento . $fila;
                $prevceldaDirecc3 = $columnaMac . $fila;
                $result[] = [
                    obtenerValorCelda($sheet, $prevceldaDirecc1, $celdasCombinadas),
                    obtenerValorCelda($sheet, $prevceldaDirecc2, $celdasCombinadas),
                    obtenerValorCelda($sheet, $prevceldaDirecc3, $celdasCombinadas)
                ];
            }

            return $result;
        }
    }

    // Si la celda no es parte de un rango combinado, manejar el caso normal
    list($columnaActual, $fila) = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($celdaDirecc);
    $columnaActualIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($columnaActual);
    $columnaUsuario = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaActualIndex - 1);
    $columnaDepartamento = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaActualIndex - 2);
    $columnaMac = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaActualIndex + 1);
    $prevceldaDirecc1 = $columnaUsuario . $fila;
    $prevceldaDirecc2 = $columnaDepartamento . $fila;
    $prevceldaDirecc3 = $columnaMac . $fila;
    $result[] = [
        obtenerValorCelda($sheet, $prevceldaDirecc1, $celdasCombinadas),
        obtenerValorCelda($sheet, $prevceldaDirecc2, $celdasCombinadas),
        obtenerValorCelda($sheet, $prevceldaDirecc3, $celdasCombinadas)
    ];

    return $result;
}
function obtenerValoresAnterioresPorMac(Worksheet $sheet, string $celdaDirecc)
{
    $celdasCombinadas = $sheet->getMergeCells();
    $result = [];

    // Función para obtener el valor de una celda, considerando si es parte de un rango combinado
    function obtenerValorCelda(Worksheet $sheet, string $celdaDirecc, array $celdasCombinadas)
    {
        foreach ($celdasCombinadas as $mergedCellRange) {
            $celdaCombinadaArea = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::extractAllCellReferencesInRange($mergedCellRange);
            if (in_array($celdaDirecc, $celdaCombinadaArea)) {
                return $sheet->getCell($celdaCombinadaArea[0])->getValue();
            }
        }
        return $sheet->getCell($celdaDirecc)->getValue();
    }

    // Comprobar si la celda actual es parte de un rango combinado
    foreach ($celdasCombinadas as $mergedCellRange) {
        $celdaCombinadaArea = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::extractAllCellReferencesInRange($mergedCellRange);

        if (in_array($celdaDirecc, $celdaCombinadaArea)) {
            // La celda es parte de un rango combinado
            list($columnaInicio, $filaInicio) = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($celdaCombinadaArea[0]);
            list($columnaFin, $filaFin) = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString(end($celdaCombinadaArea));

            // Obtener las dos columnas anteriores para todas las filas en el rango combinado
            $columnaInicioIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($columnaInicio);
            $columnaCodigo = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaInicioIndex - 1);
            $columnaUsuario = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaInicioIndex - 2);
            $columnaDepartamento = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaInicioIndex - 3);
            for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                $prevceldaDirecc1 = $columnaCodigo . $fila;
                $prevceldaDirecc2 = $columnaUsuario . $fila;
                $prevceldaDirecc3 = $columnaDepartamento . $fila;
                $result[] = [
                    obtenerValorCelda($sheet, $prevceldaDirecc1, $celdasCombinadas),
                    obtenerValorCelda($sheet, $prevceldaDirecc2, $celdasCombinadas),
                    obtenerValorCelda($sheet, $prevceldaDirecc3, $celdasCombinadas)
                ];
            }

            return $result;
        }
    }

    // Si la celda no es parte de un rango combinado, manejar el caso normal
    list($columnaActual, $fila) = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($celdaDirecc);
    $columnaActualIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($columnaActual);
    $columnaCodigo = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaActualIndex - 1);
    $columnaUsuario = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaActualIndex - 2);
    $columnaDepartamento = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnaActualIndex - 3);

    $prevceldaDirecc1 = $columnaCodigo . $fila;
    $prevceldaDirecc2 = $columnaUsuario . $fila;
    $prevceldaDirecc3 = $columnaDepartamento . $fila;
    $result[] = [
        obtenerValorCelda($sheet, $prevceldaDirecc1, $celdasCombinadas),
        obtenerValorCelda($sheet, $prevceldaDirecc2, $celdasCombinadas),
        obtenerValorCelda($sheet, $prevceldaDirecc3, $celdasCombinadas)
    ];

    return $result;
}
?>