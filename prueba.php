<?php
class Conexion
{
    private static $instance;
    private $conexion;

    private function __construct()
    {
        $host = "localhost";
        $database = "ORCL";  // Nombre de la base de datos
        $user = "SYSTEM";        // Usuario de SQL Server
        $password = "Cifu1234"; // Contraseña de SQL Server

        try {
            $dsn = "sqlsrv:Server=$host;Database=$database"; // Conexión a SQL Server
            $this->conexion = new PDO($dsn, $user, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // En producción, considera registrar este error en lugar de mostrarlo
            die("Error al conectar a la base de datos SQL Server: " . $e->getMessage());
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