<?php

class Conexion
{
    private static $instance = null;
    private $conexion;

    private function __construct() {
        $db_username = 'ERPTENA';
        $db_password = 'GADTN$$2022';
        $db_connection_string = 'cabildo'; // Asegúrate de que este identificador esté correctamente definido

        try {
            // Usando OCI8 para conectar a Oracle
            $this->conexion = oci_connect($db_username, $db_password, $db_connection_string);
            if (!$this->conexion) {
                $e = oci_error();
                throw new Exception($e['message']);
            }
        } catch (Exception $e) {
            die("Error al conectar a Oracle: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    public function __destruct() {
        if ($this->conexion) {
            oci_close($this->conexion);
        }
    }

    private function __clone()
    {
    }
}

?>
