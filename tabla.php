<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes</title>
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
    <link rel="stylesheet" href="assets/css/tabla.css">
</head>

<body>

    <div class="content-wrapper contenedor-principal">
        <div class="container-fluid py-4">
            <!-- <a href="http://localhost/GAD/mac/index.php"><button type="button" class="btn btn-primary btn-sm agregar"><i
                        class="fa-solid fa-plus icono-agregar" style="color: #ffffff;"></i> Nueva Solicitud</button></a> -->
            <div class="card shadow mb-4 contenedor">
                <div class="card-body">
                    <div class="table-responsive tabla">

                        <div class="date-filter">
                            <label for="min-date">Fecha Inicio:</label>
                            <input type="date" id="min-date">
                            <label for="max-date">Fecha Fin:</label>
                            <input type="date" id="max-date">

                            <div>
                                <!-- Filtro por Encargado -->
                                <div>
                                    <label for="encargado">Encargado:</label>
                                    <select id="encargado" class="form-control">
                                        <option value="">Todos</option>
                                        <!-- Opciones serán agregadas dinámicamente -->
                                    </select>
                                </div>

                                <!-- Filtro por Responsable -->
                                <div>
                                    <label for="responsable">Responsable:</label>
                                    <select id="responsable" class="form-control">
                                        <option value="">Todos</option>
                                        <!-- Opciones serán agregadas dinámicamente -->
                                    </select>
                                </div>

                                <!-- Filtro por Tipo de Solicitud -->
                                <div>
                                    <label for="tipo-solicitud">Tipo de Solicitud:</label>
                                    <select id="tipo-solicitud" class="form-control">
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
            url: 'RestTabla.php',
            type: 'GET',
            dataSrc: function (json) {
                // Poblamos los selects con los valores únicos
                let tiposSolicitud = [];
                let encargados = [];
                let responsables = [];
                
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

                return json;
            }
        },
        columns: [
            { data: 'FECHA' },    // Columna Fecha de solicitud
            { data: 'ID' },       // Columna ID
            { data: 'CAMBIO_NOMBRE_COMPONENTE' },  // Columna Cambio
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

    // Configuración del botón de filtro de fechas
    $('.dataTables_filter').append('<button class="btn-filtro" id="btn-filtroFecha"><i class="fa-duotone fa-solid fa-filter"></i></button>');

    $('#btn-filtroFecha').click(function () {
        $('.date-filter').toggle();
    });

    // Aplicar filtro por Encargado
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            let tipoEncargado = $('#encargado').val();
            let tipoEncargadoData = data[4]; // Índice de la columna 'Encargado'

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
            let tipoResponsableData = data[3]; // Índice de la columna 'Responsable'

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
            let tipoSolicitudData = data[5]; // Índice de la columna 'SOLICITUD'

            if (tipoSolicitud === '' || tipoSolicitudData === tipoSolicitud) {
                return true;
            }
            return false;
        }
    );
});

    </script>
</body>

</html>