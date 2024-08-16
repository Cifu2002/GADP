<?php
class Conexion
{
    private static $instance;
    private $conexion;

    public function __construct() {
        $db_username = 'ERPTENA';
        $db_password = 'GADTN$$2022';
        $host = '172.16.66.2'; // Reemplaza con la IP de la base de datos Oracle
        $port = '1521'; // Puerto estándar de Oracle
        $service_name = 'TENA'; // Reemplaza con el nombre del servicio de tu BD

        $connection_string = "(DESCRIPTION =
                                (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
                                (CONNECT_DATA = (SERVICE_NAME = $service_name))
                              )";

        try {
            // Conexión usando OCI8
            $this->conexion = oci_connect($db_username, $db_password, $connection_string);
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

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    private function __clone()
    {
    }
}
?>
