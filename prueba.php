<?php
class Conexion
{
    private static $instance;
    private $conexion;

    private function __construct() {
        $db_username = 'ERPTENA';
        $db_password = 'GADTN$$2022';
        $db_connection_string = 'cabildo';

        try {
            // Usando OCI8 para la conexión
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
