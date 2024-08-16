<?php

class ConexionOracle {
    private $conexion;

    public function __construct() {
        $db_username = 'ERPTENA';
        $db_password = 'GADTN$$2022';
        $db_connection_string = 'cabildo';

        try {
            // Usando OCI8
            $this->conexion = oci_connect($db_username, $db_password, $db_connection_string);
            if (!$this->conexion) {
                $e = oci_error();
                throw new Exception($e['message']);
            }
        } catch (Exception $e) {
            die("Error al conectar a Oracle: " . $e->getMessage());
        }
    }

    public function __destruct() {
        if ($this->conexion) {
            oci_close($this->conexion);
        }
    }
}

?>
