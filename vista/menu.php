<?php
include_once('../modelo/Sesion.php');
$sesion = Sesion::getInstance();
$nombreUsuario = $sesion->getSesion('usuario_nombre');

if (!$sesion->getSesion('usuario_id') || !$sesion->getSesion('usuario_nombre')) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/menu.css">

</head>

<body>
    <nav class="navbar">
        <div class="user">
            <span> <?php echo $nombreUsuario; ?> </span>
            <div class="dropdown">
                <a href="../controlador/cerrarSesion.php">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <div class="row">
            <!-- Tarjeta 1 -->
            <div class="col-md-6 mb-4">
                <a href="../index.php">
                    <div class="card efectos borde">
                        <img src="../assets/images/solicitud.jpeg" class="card-img-top" alt="Imagen de Solicitud">
                        <div class="card-body text-center">
                            <h5 class="card-title">Solicitud</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 2 -->
            <div class="col-md-6 mb-4">
                <a href="tabla.php">
                    <div class="card efectos borde">
                        <img src="../assets/images/reporte.jpeg" class="card-img-top" alt="Imagen de Reporte">
                        <div class="card-body text-center">
                            <h5 class="card-title">Reporte</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

</body>

</html>