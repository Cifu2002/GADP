<?php
class Conexion
{
    private static $instance;
    private $conexion;

    public function __construct() {
        $username = 'ERPTENA';
        $password = 'GADTN$$2022';
        $connection_string = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.16.66.2)(PORT=1521))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=TENA)))';

        try {
            $this->conexion = oci_connect($username, $password, $connection_string);
            if (!$this->conexion) {
                $e = oci_error();
                echo("exito");
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
