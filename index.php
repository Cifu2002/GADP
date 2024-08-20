<?php
include_once("Consultas.php");
$encargados = Consultas::listarEncargados();


/* $ip = isset($_GET['ip']) ? $_GET['ip'] : null;*/
$mac = isset($_GET['mac']) ? $_GET['mac'] : null;
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : null;
$departamento = isset($_GET['departamento']) ? $_GET['departamento'] : null;
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;
$porCodigo = isset($_GET['porCodigo']) ? $_GET['porCodigo'] : null;
$valido = false;
$causa = '';
$departamentos = Consultas::listarDepartamentos(trim($departamento));

if ($usuario !== null || $departamento !== null || $codigo !== null) {
    if ($usuario !== null && Consultas::validarUsuario((string) $usuario) === null) {
        $valido = false;
        $causa = 'Usuario no encontrado';
    } else {
        if ($departamento !== null && Consultas::validarDepartamentos((string) $departamento) === null) {
            $valido = false;
            $causa = 'Departamento no encontrado';
        } else {
            if ($codigo !== null && Consultas::validarCodigo((string) $codigo) === null) {
                $valido = false;
                $causa = 'Codigo no encontrado';
            } else {
                $valido = true;
            }
        }
    }

    if (!$valido) {
        header("Location: index.php?error=$causa&val=$valido");
        die();
    }
}

if (!empty($mac)) {
    $valido = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de asistencia técnica</title>
    <link rel="icon" href="assets/images/cantonescudo1.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/estilo.css"> <!-- CSS para el estilo -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JQuery para simplificar el uso de ajax y eventos -->
    <!-- Manejo de fecha -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> -->
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"
        integrity="sha256-J8ay84czFazJ9wcTuSDLpPmwpMXOm573OUtZHPQqpEU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <!-- <script src="assets/js/bootstrap-datepicker.es.js" charset="UTF-8"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-ui/ui/i18n/datepicker-es.js"></script>
    <!-- Alert bonito -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <h1 class="titulo">Formulario de asistencia técnica</h1>
        <img src="assets/images/cantonescudo1.png" alt="Escudo del Cantón" class="corner-image">
        <?php if (empty($mac) && $valido === false): ?>
            <div class="form-group">
                <input type="text" id="codigo" name="codigo" required>
                <button type="button" id="btn-cargar-codigo" class="btn-cargar-codigo">Cargar
                    por
                    código</button>
            </div>
        <?php endif; ?>
        <?php /* if (!empty($mac) && !empty($ip)): */
        if ($valido === true): ?>
            <label for="">Código:</label>
            <input type="text" name="codigoCargar" id="codigoCargar" value="<?php echo htmlspecialchars($codigo); ?>"
                readonly>
            <form method="" id="formSolicitud">
                <div class="form-group-col-2">
                    <div class="labels">
                        <label for="mac">Mac de la PC:</label>
                        <label for="ip">IP de la PC:</label>
                    </div>
                    <div class="inputs margen">
                        <input type="text" id="mac" name="mac" value="<?php echo htmlspecialchars($mac); ?>" readonly>
                        <input type="text" id="ip" name="ip">
                    </div>
                    <div id="ip-mensaje" class="detalle-mensaje"></div>
                </div>
                <div class="form-group">
                    <label for="opcion">Seleccione el tipo de solicitud:</label>
                    <select id="opcion" name="opcion" required>
                        <option value="">Seleccione una opción</option>
                        <option value="Preventiva">Preventiva</option>
                        <option value="Correctiva">Correctiva</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="opcion">Seleccionar encargado:</label>
                    <select name="encargado" required id="encargado" required>
                        <option value="">Seleccione una opción</option>
                        <?php
                        echo $encargados;
                        ?>
                    </select>
                </div>

                <div class="form-group-col-2">
                    <div class="labels">
                        <label>Datos del Técnico:</label>
                        <label>Datos del responsable del bien:</label>
                    </div>
                    <div class="labels-inputs">
                        <label for="cedulaTec" class="ocultar">Cédula:</label>
                        <input type="text" id="cedulaTec" name="cedulaTec" placeholder="Cédula del Técnico" readonly>
                        <label for="departamento" class="ocultar">Departamento:</label>
                        <select id="departamento" name="departamento" placeholder="Departamento" required>
                            <option value="">Seleccione una opción</option>
                            <?php
                            echo $departamentos;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group-col-2">
                    <div class="labels-inputs">
                        <label for="cargo" class="ocultar">Cargo:</label>
                        <input type="text" id="cargo" name="cargo" placeholder="Cargo del Técnico" readonly>
                        <label for="nombresResp" class="ocultar">Nombres:</label>
                        <select id="responsableBien" name="responsableBien" placeholder="Nombres" required>
                            <option value="">Seleccione una opción</option>

                        </select>
                    </div>
                </div>
                <!-- PREVENTIVO -->
                <div class="tipoOcultar" id="preventivo">
                    <div class="form-group">
                        <label for="opcion">Marcar el tipo de mantenimiento:</label>
                        <div class="form-group-checbox">
                            <div class="form-group">
                                <label for="checkbox1">
                                    <input type="checkbox" id="software" name="tipoMantenimiento" value="Software">
                                    Software
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="checkbox2">
                                    <input type="checkbox" id="hardware" name="tipoMantenimiento" value="Hardware">
                                    Hardware
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="checkbox3">
                                    <input type="checkbox" id="ambos" name="tipoMantenimiento" value="Ambos">
                                    Ambos
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CORRECTIVO -->
                <div class="tipoOcultar" id="correctivo">
                    <!-- TABLA 1 -->
                    <div class="form-group-col-2">
                        <label class="T_tabla">Componentes del bien</label>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Componente</th>
                                    <th>Descripción</th>
                                    <th>Serie</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody id="componentes-body">
                                <tr>
                                    <td><input type="text" value="1" disabled></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group-2 centrar-btn">
                            <button class="btn-tabla" type="button" onclick="agregarFila()"><i
                                    class="fa-solid fa-plus fa-2xl" style="color: #3f9d51;"></i></button>
                            <button class="btn-tabla" type="button" onclick="eliminarFila()"><i
                                    class="fa-solid fa-minus fa-2xl" style="color: #d52029;"></i></button>
                        </div>
                    </div>
                    <!-- Tabla 2 -->
                    <div class="form-group-col-2">
                        <label class="T_tabla">Cambiamos de los componentes del bien</label>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha Cambio</th>
                                    <th>Nombre del componente</th>
                                    <th>Descripción</th>
                                    <th>Serie</th>
                                </tr>
                            </thead>
                            <tbody id="componentes-Cambio-body">
                                <tr>
                                    <td><input type="text" value="1" disabled></td>
                                    <td><input type='text' class="date-input" readonly required /></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group-2 centrar-btn">
                            <button class="btn-tabla" type="button" onclick="agregarFilaCambios()"><i
                                    class="fa-solid fa-plus fa-2xl" style="color: #3f9d51;"></i></button>
                            <button class="btn-tabla" type="button" onclick="eliminarFilaCambios()"><i
                                    class="fa-solid fa-minus fa-2xl" style="color: #d52029;"></i></button>
                        </div>
                    </div>
                </div>
                <!-- Fecha de la solicitud -->
                <div class="form-group-2 form-group-col-2">
                    <div class="labels">
                        <label for="datetime">Fecha de la solicitud:</label>
                        <label for="datetime">Hora de la solicitud:</label>
                    </div>
                    <div class="input-group">
                        <input type="date" id="fecha" name="fecha" readonly>
                        <input type="time" id="hora" name="hora" readonly>
                    </div>
                    <div id="hora-mensaje" class="detalle-mensaje"></div>
                    <div id="fecha-mensaje" class="detalle-mensaje"></div>
                </div>
                <!-- Fecha de finalizacion -->
                <div class="form-group-2 form-group-col-2">
                    <div class="labels">
                        <label for="datetime">Fecha de finalización:</label>
                        <label for="datetime">Hora de finalización:</label>
                    </div>
                    <div class="input-group">
                        <input type="date" id="fechaF" name="fechaF" required>
                        <input type="time" id="horaF" name="horaF" required>
                    </div>
                    <div id="hora-mensajeF" class="detalle-mensaje"></div>
                    <div id="fecha-mensajeF" class="detalle-mensaje"></div>
                </div>
                <div class="form-group">
                    <label for="detalles">Detalles:</label>
                    <textarea id="detalles" name="detalles" rows="4" maxlength="255" required></textarea>
                    <div id="detalle-mensaje" class="detalle-mensaje"></div>
                </div>
                <div class="form-group">
                    <label for="impresora">¿La impresora funciona?</label>
                    <div class="form-group-checbox-impresora">
                        <div class="form-group">
                            <label for="checkbox1">
                                <input type="checkbox" id="funcionaSi" name="impresora" value="Si">
                                Si
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="checkbox2">
                                <input type="checkbox" id="funcionaNo" name="impresora" value="No">
                                No
                            </label>
                        </div>
                    </div>
                </div>

                <div id="submit-mensaje" class="detalle-mensaje"></div>
                <input type="submit" value="Enviar">

            </form>
        <?php endif; ?>
    </div>
    <script>
        $(document).ready(function () {
            let porCodigo = <?php echo $porCodigo ? 'true' : 'false'; ?>;
            /* Enviar codigo y obtener datos */
            $("#btn-cargar-codigo").on('click', function () {
                let codigo = $("#codigo").val().trim();
                let op = 3;
                if (codigo === "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Por favor, ingresa un código.'
                    });
                    return;
                }
                if (!codigo.includes('.')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Código inválido.'
                    });
                    return;
                }

                $.ajax({
                    url: "Rest.php",
                    type: "GET",
                    data: {
                        op: op,
                        codigo: codigo
                    },
                    dataType: "json",
                    success: function (data) {

                        if (data.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error
                            });
                            return;
                        }

                        let usuario = data.usuario ? data.usuario.trim() : '';
                        let departamento = data.departamento ? data.departamento.trim() : '';
                        let mac = data.mac ? data.mac.trim() : '';
                        let url = `index.php?porCodigo=true&codigo=${encodeURIComponent(codigo)}&mac=${encodeURIComponent(mac)}&departamento=${encodeURIComponent(departamento)}&usuario=${encodeURIComponent(usuario)}`;
                        window.location.href = url;

                    }, error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la solicitud AJAX',
                            text: 'Hubo un problema al comunicarse con el servidor. Por favor, intentelo más tarde.'
                        });
                    }
                });
            });

            /* CODIGO POR MAC */

            if ($("#mac").val() && porCodigo === false) {
                let cargarporMac = '<?php echo $mac ?>';
                op = 4;
                $.ajax({
                    url: "Rest.php",
                    type: "GET",
                    data: {
                        op: op,
                        cargarporMac: cargarporMac
                    },
                    success: function (data) {
                        if (data.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'MAC no encontrada'
                            }).then(function () {
                                window.location.href = 'index.php';
                            });
                            return;
                        }
                        let usuarioR = data.usuario ? data.usuario.trim() : '';
                        let departamentoR = data.departamento ? data.departamento.trim() : '';
                        let codigo = data.codigo ? data.codigo.trim() : '';
                        $("#codigoCargar").val(codigo);
                        $("#departamento").val(departamentoR);
                        let departamento = $("#departamento").val();
                        let usuario = usuarioR;
                        if (departamento && usuario) {
                            op = 2;
                            $.ajax({
                                url: "Rest.php",
                                type: "GET",
                                data: {
                                    op: op,
                                    departamento: departamento,
                                    usuario: usuario
                                },
                                success: function (response) {
                                    $("#responsableBien").html(response);
                                }, error: function (xhr, status, error) {
                                    console.error("Error en la solicitud AJAX:", status, error);
                                }
                            });
                        }

                    }, error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la solicitud',
                            text: 'Hubo un problema al comunicarse con el servidor. Por favor, intentelo más tarde.'
                        });
                    }
                });
            }

            if ($("#departamento").val() !== "" && porCodigo === true) {
                let departamento = $("#departamento").val();
                let usuario = '<?php echo $usuario ?>';
                let op = 2;
                $.ajax({
                    url: "Rest.php",
                    type: "GET",
                    data: {
                        op: op,
                        departamento: departamento,
                        usuario: usuario
                    },
                    success: function (response) {
                        $("#responsableBien").html(response);
                    }, error: function (xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", status, error);
                    }
                });
            };
            configurarFechaMinima();
            let $esCorrectivo = false;
            /* Inicializar datepicker */
            inicializarDatePicker();
            /* Establecer fecha */
            var fechaHoy = new Date();
            fechaHoy.setMinutes(fechaHoy.getMinutes() - fechaHoy.getTimezoneOffset());
            var fechaActual = fechaHoy.toISOString().split('T')[0];
            $("#fecha").val(fechaActual);
            /* Establecer hora */
            var horaPorDefecto = new Date();
            var hora = horaPorDefecto.getHours();
            var minutos = horaPorDefecto.getMinutes();
            if (minutos < 10) {
                minutos = '0' + minutos;
            }
            if (hora < 10) {
                hora = '0' + hora;
            } var horaActual = hora + ':' + minutos;
            $("#hora").val(horaActual);

            /* Evita el ingreso de más de 255 caracteres */
            $("#detalles").on('input', function (event) {
                var detalles = $(this).val();
                var detalleMensaje = document.getElementById('detalle-mensaje');
                detalleMensaje.innerText = '';

                if (detalles.length === 255) {
                    detalleMensaje.innerText = 'Limite alcanzado.';
                } else {
                    if (detalles.length > 255) {
                        detalleMensaje.innerText = 'El texto no debe ser mayor a 255 caracteres';
                        event.preventDefault();
                    }
                }
            });

            /*Controlador de hora*/
            $("#hora").on('input', function (event) {
                var valor = $(this).val();
                var mensaje = document.getElementById('hora-mensaje');
                mensaje.innerText = '';
                var hora = parseInt(valor.split(':')[0]);
                var minutos = parseInt(valor.split(':')[1]);
                var tiempoEnMinutos = (hora * 60) + minutos;
                var tiempoMinimo = (7 * 60) + 30;
                var tiempoMaximo = (17 * 60);
                if (tiempoEnMinutos < tiempoMinimo || tiempoEnMinutos > tiempoMaximo) {
                    mensaje.innerText = 'El horario de atencion es de 7:30 a 17:00';
                    event.preventDefault();
                }
            });

            $("#horaF").on('input', function (event) {
                var valor = $(this).val();
                var mensaje = document.getElementById('hora-mensajeF');
                mensaje.innerText = '';
                var hora = parseInt(valor.split(':')[0]);
                var minutos = parseInt(valor.split(':')[1]);
                var tiempoEnMinutos = (hora * 60) + minutos;
                var tiempoMinimo = (7 * 60) + 30;
                var tiempoMaximo = (17 * 60);
                if (tiempoEnMinutos < tiempoMinimo || tiempoEnMinutos > tiempoMaximo) {
                    mensaje.innerText = 'El horario de atencion es de 7:30 a 17:00';
                    event.preventDefault();
                }
            });

            /* Fecha Valida */
            function esFinDeSemana(fecha) {
                var diaNormal = fecha.getDay();
                if (diaNormal === 6 || diaNormal === 0) {
                    return true;
                } else {
                    return false;
                }
            }

            var hoy = new Date();
            var mensajeFecha = document.getElementById('fecha-mensaje');
            mensajeFecha.innerText = '';

            if (esFinDeSemana(hoy) === true) {
                mensajeFecha.innerText = 'Solo dias laborales de Lunes a Viernes';
            }

            function configurarFechaMinima() {
                var hoy = new Date();
                var fechaMinima = hoy.toISOString().split('T')[0];
                document.getElementById('fechaF').setAttribute('min', fechaMinima);
            }

            /* Fecha valida finalización */
            $("#fechaF").on('change', function () {
                var fechaFinalizacionStr = $(this).val(); // Obtener la fecha como cadena 'YYYY-MM-DD'
                var mensajeFecha = document.getElementById('fecha-mensajeF');
                mensajeFecha.innerText = '';

                var partesFecha = fechaFinalizacionStr.split('-');
                var fechaFinalizacion = new Date(partesFecha[0], partesFecha[1] - 1, partesFecha[2]); // Año, Mes (0-indexado), Día

                if (esFinDeSemana(fechaFinalizacion) === true) {
                    mensajeFecha.innerText = 'Solo dias laborales de Lunes a Viernes';
                }
            });

            /* Cargar tipo de solicitud */
            $("#opcion").change(function () {
                $tipo = $(this).val();
                $("#opcion option[value='']").remove();
                if ($tipo === 'Preventiva') {
                    $esCorrectivo = true;
                    $("#preventivo").removeClass("tipoOcultar").addClass("tipoMostrar");
                    $("#correctivo").removeClass("tipoMostrar").addClass("tipoOcultar");
                } else if ($tipo === 'Correctiva') {
                    $esCorrectivo = false;
                    $('input[type="checkbox"][name="tipoMantenimiento"]').prop('checked', false);
                    $("#correctivo").removeClass("tipoOcultar").addClass("tipoMostrar");
                    $("#preventivo").removeClass("tipoMostrar").addClass("tipoOcultar");
                } else {
                    $("#preventivo").removeClass("tipoMostrar").addClass("tipoOcultar");
                    $("#correctivo").removeClass("tipoMostrar").addClass("tipoOcultar");
                }
            });
            /* Checkbox */
            $('input[type="checkbox"][name="tipoMantenimiento"]').on('change', function () {
                $('input[type="checkbox"][name="tipoMantenimiento"]').not(this).prop('checked', false);
            });
            $('input[type="checkbox"][name="impresora"]').on('change', function () {
                $('input[type="checkbox"][name="impresora"]').not(this).prop('checked', false);
            });

            /* Envio de datos con ajax */
            $("#formSolicitud").on('submit', function (event) {
                event.preventDefault();
                var detalles = $("#detalles").val();
                var hora = $("#hora").val();
                var horaMensaje = $('#hora-mensaje').text();
                var horaMensajeF = $('#hora-mensajeF').text();
                var fechaMensaje = $('#fecha-mensaje').text();
                var fechaMensajeF = $('#fecha-mensajeF').text();
                var ipMensaje = $('#ip-mensaje').text();
                var detalleMensaje = $('#detalle-mensaje').text();
                var enviarMensaje = document.getElementById('submit-mensaje');
                enviarMensaje.innerText = '';

                /* Checkbox */
                if ($esCorrectivo) {
                    var checkboxesTipo = document.querySelectorAll('input[name="tipoMantenimiento"]');
                    var isCheckedTipo = Array.prototype.slice.call(checkboxesTipo).some(function (checkbox) {
                        return checkbox.checked;
                    });
                    if (!isCheckedTipo) {
                        enviarMensaje.innerText = 'Por favor, seleccione el tipo de mantenimiento.';
                        event.preventDefault();
                        return;
                    }
                }

                var checkboxes = document.querySelectorAll('input[name="impresora"]');
                var isChecked = Array.prototype.slice.call(checkboxes).some(function (checkbox) {
                    return checkbox.checked;
                });
                if (!isChecked) {
                    enviarMensaje.innerText = 'Por favor, seleccione si la impresora esta funcionando.';
                    event.preventDefault();
                    return;
                }

                if (detalles.length > 255 || horaMensaje || fechaMensaje || fechaMensajeF || horaMensajeF || ipMensaje) {
                    enviarMensaje.innerText = 'Por favor, corrige los errores en el formulario antes de enviarlo.';
                    event.preventDefault();
                }


                codigo = $("#codigoCargar").val();
                mac = $("#mac").val();
                ip = $("#ip").val();
                tipoSolicitud = $("#opcion").val();
                encargado = $("#encargado option:selected").data("nombre");
                tipoMantenimiento = [];
                $("input[name='tipoMantenimiento']:checked").each(function () {
                    tipoMantenimiento.push($(this).val());
                });
                responsableBien = $("#responsableBien").val();
                departamento = $("#departamento").val();
                cedula = $("#cedulaTec").val();
                cargo = $("#cargo").val();
                let componentes = [];

                $("#componentes-body tr").each(function () {
                    let fila = $(this);
                    let componente = {
                        id: fila.find("td:eq(0) input").val(),
                        nombre: fila.find("td:eq(1) input").val(),
                        descripcion: fila.find("td:eq(2) input").val(),
                        serie: fila.find("td:eq(3) input").val(),
                        observacion: fila.find("td:eq(4) input").val()
                    };
                    componentes.push(componente);
                });

                let cambios = [];

                // Iterar sobre cada fila en el tbody
                $("#componentes-Cambio-body tr").each(function () {
                    let fila = $(this);
                    let cambio = {
                        id: fila.find("td:eq(0) input").val(),
                        fechaCambio: fila.find("td:eq(1) input").val(),
                        nombreComponente: fila.find("td:eq(2) input").val(),
                        descripcion: fila.find("td:eq(3) input").val(),
                        serie: fila.find("td:eq(4) input").val()
                    };
                    cambios.push(cambio);
                });

                fechaSolicitud = $("#fecha").val();
                horaSolicitud = $("#hora").val();
                fechaSolicitudF = $("#fechaF").val();
                horaSolicitudF = $("#horaF").val();
                impresora = [];
                $("input[name='impresora']:checked").each(function () {
                    impresora.push($(this).val());
                });
                $.ajax({
                    url: "Rest.php",
                    type: "POST",
                    contentType: 'application/json',
                    data: JSON.stringify({
                        codigo: codigo,
                        mac: mac,
                        ip: ip,
                        tipoSolicitud: tipoSolicitud,
                        tipoMantenimiento: JSON.stringify(tipoMantenimiento),
                        responsableBien: responsableBien,
                        departamento: departamento,
                        cedula: cedula,
                        cargo: cargo,
                        encargado: encargado,
                        componentes: componentes,
                        cambios: cambios,
                        fechaSolicitud: fechaSolicitud,
                        horaSolicitud: horaSolicitud,
                        fechaSolicitudF: fechaSolicitudF,
                        horaSolicitudF: horaSolicitudF,
                        detalles: detalles,
                        impresora: JSON.stringify(impresora)
                    }),
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success' && !isNaN(data.data)) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: 'Solicitud ingresada con éxito. ID: ' + data.data
                            }).then(function () {
                                window.location.href = 'index.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo conectar con el servidor. Intente nuevamente más tarde.'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo conectar con el servidor. Intente nuevamente más tarde.'
                        });
                    }
                });
            });

            $("#encargado").change(function () {
                let Encargadoid = $(this).val();
                $("#encargado option[value='']").remove();

                let op = 1;
                $.ajax({
                    url: "Rest.php",
                    type: "GET",
                    data: { op: op, encargado_id: Encargadoid },
                    success: function (response) {
                        let resultado = JSON.parse(response);
                        $("#cedulaTec").val(resultado.NOM01CEDUAL);
                        $("#cargo").val(resultado.NOMBRE_CARGO);
                    }, error: function (xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", status, error);
                    }
                });
            });

            $("#departamento").on('change', function () {
                $("#departamento option[value='']").remove();
                let departamento = $(this).val().trim();
                let op = 2;
                $.ajax({
                    url: "Rest.php",
                    type: "GET",
                    data: {
                        op: op,
                        departamento: departamento
                    },
                    success: function (response) {
                        $("#responsableBien").html(response);
                    }, error: function (xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", status, error);
                    }
                });
            });

            /* Validar ip */
            $("#ip").on('input', function () {
                var ip = $(this).val();
                var mensajeIP = document.getElementById('ip-mensaje');

                if (esIpValida(ip) || ip === '') {
                    mensajeIP.innerText = '';
                } else {
                    mensajeIP.innerText = 'IP no válida.';
                }
            });

            function esIpValida(ip) {
                var regex = /^(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}$/;
                return regex.test(ip);
            }
        });

    </script>

    <script>


        $("#codigo").on('input', function () {
            this.value = this.value.replace(/[^0-9.]/g, '');

            if (this.value && this.value.includes('.')) {
                $("#btn-cargar-codigo").addClass("habilitado");
            } else {
                $("#btn-cargar-codigo").removeClass("habilitado");
            }
        });
    </script>

    <!-- Agregar nueva fila Componentes del bien-->
    <script>
        function agregarFila() {
            var tablaBody = document.getElementById("componentes-body");
            var rowCount = tablaBody.rows.length;
            var row = tablaBody.insertRow(-1);

            for (var i = 0; i < 5; i++) {
                var cell = row.insertCell(i);
                var input = document.createElement("input");
                input.type = "text";
                if (i === 0) {
                    input.value = rowCount + 1;
                    input.disabled = true;
                }
                cell.appendChild(input);
            }
        }

        function eliminarFila() {
            var tablaBody = document.getElementById("componentes-body");
            if (tablaBody.rows.length > 1) {
                tablaBody.deleteRow(-1);
            }
        }
    </script>

    <!-- Agregar nueva fila cambios de componentes-->
    <script>
        function agregarFilaCambios() {
            var tablaBody = document.getElementById("componentes-Cambio-body");
            var rowCount = tablaBody.rows.length;
            var row = tablaBody.insertRow(-1);

            for (var i = 0; i < 5; i++) {
                var cell = row.insertCell(i);
                var input = document.createElement("input");
                if (i === 0) {
                    input.type = "text";
                    input.value = rowCount + 1;
                    input.disabled = true;
                } else if (i === 1) {
                    input.type = "text";
                    input.classList.add("date-input");
                    input.readOnly = true;
                    input.required = true;
                } else {
                    input.type = "text";
                }

                cell.appendChild(input);
            }
            inicializarDatePicker();
        }

        function eliminarFilaCambios() {
            var tablaBody = document.getElementById("componentes-Cambio-body");
            if (tablaBody.rows.length > 1) {
                tablaBody.deleteRow(-1);
            }
        }

        function inicializarDatePicker() {
            $(".date-input").datepicker({
                loseText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                weekHeader: 'Sm',
                minDate: 0,
                beforeShowDay: $.datepicker.noWeekends
            });
        }
    </script>
</body>

</html>