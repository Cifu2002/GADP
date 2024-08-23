<?php

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="contenedor">
        <div class="login-form">
            <h3 class="text-center mb-4">Iniciar Sesión</h3>
            <form id="form-enviar">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario <i class="fa-solid fa-user"
                            style="color: #000000;"></i></label>
                    <input type="text" class="form-control" id="usuario" placeholder="Ingresa tu usuario" required>
                </div>
                <div class="mb-3">
                    <label for="clave" class="form-label">Contraseña <i class="fa-solid fa-key"
                            style="color: #000000;"></i></label>
                    <input type="password" class="form-control" id="clave" placeholder="Ingresa tu contraseña" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn enviar">Iniciar Sesión</button>
                </div>
            </form>

            <script>
                $(document).ready(function () {
                    $('#form-enviar').on('submit', function (event) {
                        event.preventDefault();

                        const usuario = $('#usuario').val();
                        const clave = $('#clave').val();
                        if (usuario === '' || clave === '') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Campos Vacíos',
                                text: 'Por favor, completa todos los campos.'
                            });
                            return;
                        }

                        $.ajax({
                            url: "../controlador/recibirUsuario.php",
                            type: "POST",
                            contentType: 'application/json',
                            data: JSON.stringify({
                                usuario: usuario,
                                clave: clave
                            }),
                            success: function (response) {
                                // Parsear la respuesta JSON
                                const data = JSON.parse(response);

                                // Comprobar el estado de la respuesta
                                if (data.success) {
                                    window.location.href = 'pagina-principal.html';
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message || 'Datos de usuario incorrectos'
                                    });
                                    // Limpia los campos del formulario
                                    $('#usuario').val('');
                                    $('#clave').val('');
                                }
                            },
                            error: function (xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error en la conexión con el servidor'
                                });
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>