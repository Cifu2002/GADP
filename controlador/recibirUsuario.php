<?php
include_once('../modelo/validarUsuario.php');
include_once('../modelo/conexion.php');

// Verificar que la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Obtener datos JSON de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar que se han recibido los datos
    if (isset($data['usuario']) && isset($data['clave'])) {
        // Sanitizar y validar los datos
        $usuario = filter_var(trim($data['usuario']), FILTER_SANITIZE_STRING);
        $clave = filter_var(trim($data['clave']), FILTER_SANITIZE_STRING);

        // Validar el usuario
        if (validarUsuario($usuario, $clave)) {
            // Enviar respuesta JSON en caso de éxito
            echo json_encode(['success' => true]);
        } else {
            // Enviar respuesta JSON en caso de error
            echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
        }
    } else {
        // Enviar respuesta JSON si faltan datos
        echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
    }
} else {
    // Enviar respuesta JSON si no es una solicitud POST
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido.']);
}
?>
