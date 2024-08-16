<?php
class Conexion
{
    private static $instance;
    private $conexion;

    /* private function __construct()
    {
        $db_username = 'ERPTENA';
        $db_password = 'GADTN$$2022';
        $db_connection_string = 'cabildo';
        try {
            $this->conexion = new PDO("oci:dbname=" . $db_connection_string, $db_username, $db_password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            header("Location: respuesta.php");
            exit(); 
        }
    } */
    private function __construct()
{
    $db_username = 'ERPTENA';
    $db_password = 'GADTN$$2022';
    $db_connection_string = 'cabildo';
    try {
        $this->conexion = new PDO("oci:dbname=" . $db_connection_string . ";charset=AL32UTF8", $db_username, $db_password);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error al conectar a Oracle: " . $e->getMessage());
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