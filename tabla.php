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
    <style>
        .contenedor {
            border-radius: 10px;
        }

        .agregar {
            background-color: #2e8b57;
            border-radius: 7px;
            margin-bottom: 10px;
            border: #29764a;
        }

        .agregar:hover {
            background-color: #29764a;
        }

        .date-filter {
            margin-bottom: 10px;
        }

        .btn-filtro {
            border-radius: 5px;
            margin-left: 3px;
            border: 1px solid #ced4da;
            height: 31px;
            background-color: white;
        }

        .date-filter {
            display: none;
            text-align: center;
        }

        .date-filter input {
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 5px;
            border: 1px solid #ced4da;
        }

        .contenedor-principal {
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="content-wrapper contenedor-principal">
        <div class="container-fluid py-4">
            <a href="http://localhost/GAD/mac/index.php"><button type="button" class="btn btn-primary btn-sm agregar"><i
                        class="fa-solid fa-plus icono-agregar" style="color: #ffffff;"></i> Nueva Solicitud</button></a>
            <div class="card shadow mb-4 contenedor">
                <div class="card-body">
                    <div class="table-responsive tabla">

                        <div class="date-filter">
                            <label for="min-date">Fecha Inicio:</label>
                            <input type="date" id="min-date">
                            <label for="max-date">Fecha Fin:</label>
                            <input type="date" id="max-date">
                        </div>
                        <table class="table table-bordered table-hover table-striped" id="tablaSolicitud" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha de solicitud</th>
                                    <th>Mac</th>
                                    <th>IP</th>
                                    <th>Tipo de solicitud</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac</td>
                                    <td>ip</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac</td>
                                    <td>ip</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2022</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac</td>
                                    <td>ip</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac</td>
                                    <td>ip</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac</td>
                                    <td>ip</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac</td>
                                    <td>ip</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                                <tr>
                                    <td>23-07-2024</td>
                                    <td>mac 1</td>
                                    <td>ip 2</td>
                                    <td>Preventiva</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Fecha de solicitud</th>
                                    <th>Mac</th>
                                    <th>IP</th>
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
                    "infoEmpty": "Mostrando 0 to 0 of 0 entradas",
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
                }
            });

            /* Filtro por fechas */
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

            $('.dataTables_filter').append('<button class="btn-filtro" id="btn-filtroFecha"><i class="fa-duotone fa-solid fa-filter"></i></button>');

            $('#btn-filtroFecha').click(function () {
                $('.date-filter').toggle();
            });

        });
    </script>
</body>

</html>