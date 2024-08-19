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
                throw new Exception($e['message']);
            }
    
            // Establecer la codificación a UTF-8
            oci_set_client_encoding($this->conexion, 'AL32UTF8');
            // Configurar el identificador del cliente (opcional)
            oci_set_client_identifier($this->conexion, 'UTF-8');
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
