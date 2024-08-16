<?php

class Conexion
{
    private static $instance = null; // Instancia única de la clase
    private $conexion; // Objeto de conexión a la base de datos

    // Constructor privado para evitar la creación de instancias desde fuera de la clase
    private function __construct() {
        $db_username = 'ERPTENA';
        $db_password = 'GADTN$$2022';
        $db_connection_string = 'cabildo';

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

    // Método estático para obtener la instancia única de la clase
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self(); // Crear una nueva instancia si no existe
        }
        return self::$instance;
    }

    // Método para obtener la conexión
    public function getConexion()
    {
        return $this->conexion;
    }

    // Destructor para cerrar la conexión cuando la instancia sea destruida
    public function __destruct() {
        if ($this->conexion) {
            oci_close($this->conexion);
        }
    }

    // Método privado para evitar la clonación de la instancia
    private function __clone()
    {
    }
}

?>
