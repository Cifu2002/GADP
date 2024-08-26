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
    <title>Solicitudes</title>
    <link rel="icon" href="../assets/images/cantonescudo1.png" type="image/x-icon">
    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Para la tabla -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/tabla.css">
</head>

<body>
    <nav class="navbar">
        <div class="nav-left">
            <a href="menu.php"><i class="fa-solid fa-house" style="color: #ffffff;"></i></a>
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
    <div class="content-wrapper contenedor-principal">
        <div class="container-fluid py-4">
            <a href="http://localhost/GAD/mac/index.php"><button type="button" class="btn btn-primary btn-sm agregar"><i
                        class="fa-solid fa-plus icono-agregar" style="color: #ffffff;" id="generarReporte"></i> Generar
                    reportes</button></a>
            <div class="card shadow mb-4 contenedor">
                <div class="card-body">
                    <div class="table-responsive tabla">

                        <div class="date-filter">
                            <label for="min-date">Fecha Inicio:</label>
                            <input type="date" id="min-date">
                            <label for="max-date">Fecha Fin:</label>
                            <input type="date" id="max-date">

                            <div class="filtros-select">
                                <!-- Encargado -->
                                <div>
                                    <label for="encargado">Encargado:</label>
                                    <select id="encargado" class="form-control">
                                        <option value="">Todos</option>
                                        <!-- Opciones serán agregadas dinámicamente -->
                                    </select>
                                </div>
                                <!-- Responsable -->
                                <div>
                                    <label for="responsable">Responsable:</label>
                                    <select id="responsable" class="form-control">
                                        <option value="">Todos</option>
                                        <!-- Opciones serán agregadas dinámicamente -->
                                    </select>
                                </div>
                                <!-- Tipos de solicitud -->
                                <div>
                                    <label for="tipo-solicitud">Tipo de Solicitud:</label>
                                    <select id="tipo-solicitud" class="form-control">
                                        <option value="">Todos</option>
                                        <!-- Opciones serán agregadas dinámicamente -->
                                    </select>
                                </div>
                                <!-- Cambio -->
                                <div>
                                    <label for="cambio">Cambio:</label>
                                    <select id="cambio" class="form-control">
                                        <option value="">Todos</option>
                                        <!-- Opciones serán agregadas dinámicamente -->
                                    </select>
                                </div>
                            </div>
                        </div>


                        <table class="table table-bordered table-hover table-striped" id="tablaSolicitud" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha de solicitud</th>
                                    <th>ID</th>
                                    <th>Cambio</th>
                                    <th>Serie</th>
                                    <th>Responsable</th>
                                    <th>Encargado</th>
                                    <th>Tipo de solicitud</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Fecha de solicitud</th>
                                    <th>ID</th>
                                    <th>Cambio</th>
                                    <th>Serie</th>
                                    <th>Responsable</th>
                                    <th>Encargado</th>
                                    <th>Tipo de solicitud</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            let tablaSolicitud = $("#tablaSolicitud").DataTable({
                dom: '<"d-flex flex-row justify-content-between"lf>rtip',
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                ajax: {
                    url: '../controlador/RestTabla.php',
                    type: 'GET',
                    dataSrc: function (json) {
                        // Poblamos los selects con los valores únicos
                        let tiposSolicitud = [];
                        let encargados = [];
                        let responsables = [];
                        let cambios = [];

                        json.forEach(row => {
                            if (!tiposSolicitud.includes(row.SOLICITUD)) {
                                tiposSolicitud.push(row.SOLICITUD);
                            }
                            if (!encargados.includes(row.ENCARGADO)) {
                                encargados.push(row.ENCARGADO);
                            }
                            if (!responsables.includes(row.RESPONSABLE)) {
                                responsables.push(row.RESPONSABLE);
                            }

                            if (row.CAMBIO_NOMBRE_COMPONENTE && !cambios.includes(row.CAMBIO_NOMBRE_COMPONENTE)) {
                                cambios.push(row.CAMBIO_NOMBRE_COMPONENTE);
                            }
                        });

                        // Poblar select de Tipo de Solicitud
                        let selectSolicitud = $('#tipo-solicitud');
                        selectSolicitud.empty().append('<option value="">Todos</option>');
                        tiposSolicitud.forEach(tipo => {
                            selectSolicitud.append(`<option value="${tipo}">${tipo}</option>`);
                        });

                        // Poblar select de Encargado
                        let selectEncargado = $('#encargado');
                        selectEncargado.empty().append('<option value="">Todos</option>');
                        encargados.forEach(encargado => {
                            selectEncargado.append(`<option value="${encargado}">${encargado}</option>`);
                        });

                        // Poblar select de Responsable
                        let selectResponsable = $('#responsable');
                        selectResponsable.empty().append('<option value="">Todos</option>');
                        responsables.forEach(responsable => {
                            selectResponsable.append(`<option value="${responsable}">${responsable}</option>`);
                        });

                        // Poblar el select de cambio
                        let selectCambio = $('#cambio');
                        selectCambio.empty().append('<option value="">Todos</option>');
                        cambios.forEach(cambio => {
                            selectCambio.append(`<option value="${cambio}">${cambio}</option>`);
                        });

                        return json;
                    }
                },
                columns: [
                    { data: 'FECHA' },    // Columna Fecha de solicitud
                    { data: 'ID' },       // Columna ID
                    { data: 'CAMBIO_NOMBRE_COMPONENTE' },  // Columna Cambio
                    { data: 'SERIE' }, // Serie del componente
                    { data: 'RESPONSABLE' },   // Columna Responsable
                    { data: 'ENCARGADO' },     // Columna Encargado
                    { data: 'SOLICITUD' }   // Columna Tipo de solicitud
                ]
            });

            // Filtro por fechas
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    let min = $('#min-date').val();
                    let max = $('#max-date').val();
                    let date = new Date(data[0].split('-').reverse().join('-'));

                    if (
                        (min === '' || new Date(min) <= date) &&
                        (max === '' || date <= new Date(max))
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            $('#min-date, #max-date').change(function () {
                tablaSolicitud.draw();
            });

            // Filtro por Encargado
            $('#encargado').change(function () {
                tablaSolicitud.draw();
            });

            // Filtro por Responsable
            $('#responsable').change(function () {
                tablaSolicitud.draw();
            });

            // Filtro por Tipo de Solicitud
            $('#tipo-solicitud').change(function () {
                tablaSolicitud.draw();
            });

            // Filtro por Cambio
            $('#cambio').change(function () {
                tablaSolicitud.draw();
            });

            // Configuración del botón de filtro de fechas
            $('.dataTables_filter').append('<button class="btn-filtro" id="btn-filtroFecha"><i class="fa-duotone fa-solid fa-filter"></i></button>');

            $('#btn-filtroFecha').click(function () {
                $('.date-filter').toggle();
            });

            // Aplicar filtro por Encargado
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    let tipoEncargado = $('#encargado').val();
                    let tipoEncargadoData = data[5]; // Índice de la columna 'Encargado'

                    if (tipoEncargado === '' || tipoEncargadoData === tipoEncargado) {
                        return true;
                    }
                    return false;
                }
            );

            // Aplicar filtro por Responsable
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    let tipoResponsable = $('#responsable').val();
                    let tipoResponsableData = data[4]; // Índice de la columna 'Responsable'

                    if (tipoResponsable === '' || tipoResponsableData === tipoResponsable) {
                        return true;
                    }
                    return false;
                }
            );

            // Aplicar filtro por Tipo de Solicitud
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    let tipoSolicitud = $('#tipo-solicitud').val();
                    let tipoSolicitudData = data[6]; // Índice de la columna 'SOLICITUD'

                    if (tipoSolicitud === '' || tipoSolicitudData === tipoSolicitud) {
                        return true;
                    }
                    return false;
                }
            );

            // Aplicar filtro por cambio
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    let tipoCambio = $('#cambio').val();
                    let tipoCambioData = data[2]; // Índice de la columna 'Cambio'

                    if (tipoCambio === '' || tipoCambioData === tipoCambio) {
                        return true;
                    }
                    return false;
                }
            );

            $('#generarReporte').on('click', function () {
                alert("sd");
                // Obtener las filas visibles después del filtrado
                let filasFiltradas = tablaSolicitud.rows({ filter: 'applied' }).data();

                // Crear un array con solo las IDs
                let ids = [];
                filasFiltradas.each(function (row) {
                    ids.push(row.ID);
                });

                // Enviar las IDs al backend mediante AJAX
                $.ajax({
                    url: 'generarReporte.php',
                    type: 'POST',
                    data: { ids: ids },
                    success: function (respuesta) {
                        // Manejar la respuesta del servidor
                        console.log(respuesta);
                    },
                    error: function (error) {
                        // Manejar cualquier error
                        console.error('Error al enviar los datos: ', error);
                    }
                });
            });
        });

    </script>
</body>

</html>