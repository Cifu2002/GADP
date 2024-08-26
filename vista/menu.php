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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" href="../assets/images/cantonescudo1.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav class="navbar">
        <div class="nav-left">
            <a href="menu.php"><i class="fa-solid fa-house" style="color: #ffffff;"></i> Inicio</a>
        </div>
        <div class="user">
            <span><?php echo $nombreUsuario; ?> <i class="fa-solid fa-user" style="color: #ffffff;"></i></span>
            <div class="dropdown">
                <a href="../controlador/cerrarSesion.php">
                    <i class="fa-solid fa-right-from-bracket" style="color: #000000;"></i> Cerrar sesión
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5 d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-6 d-flex align-items-center mb-4">
            <a href="../index.php" class="w-100">
                <div class="card efectos borde">
                    <img src="../assets/images/solicitud.jpeg" class="card-img-top" alt="Imagen de Solicitud">
                    <div class="card-body text-center">
                        <h5 class="card-title">Solicitud</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 d-flex align-items-center mb-4">
            <a href="tabla.php" class="w-100">
                <div class="card efectos borde">
                    <img src="../assets/images/reporte.jpg" class="card-img-top" alt="Imagen de Reporte">
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