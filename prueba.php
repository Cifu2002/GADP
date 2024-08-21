<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="enviar.php" method="POST">
        <input type="text" value="1" id="solicitudID" name="solicitudID">
        <input type="text" value="123446567" id="codigo" name="codigo">

        <input type="text" value="A:ADASDAS:A" id="mac" name="mac">

        <input type="text" value="Correctiva" id="tipoSolicitud" name="tipoSolicitud">
        <input type="text" value="HARDWARE" id="tipoMantenimientoString" name="tipoMantenimientoString">

        <input type="text" value="Diana Quevedo" id="responsableBien" name="responsableBien">
        <input type="text" value="Dispensario Medico" id="departamento" name="departamento">

        <input type="text" value="Esteban Ismael Cifuentes Salinas" id="encargado" name="encargado">
        <input type="date" value="2024-08-20" id="fechaSolicitud" name="fechaSolicitud">

        <input type="time" value="09:00" id="horaSolicitud" name="horaSolicitud">
        <input type="date" value="2024-08-20" id="fechaSolicitudF" name="fechaSolicitudF">

        <input type="time" value="09:30" id="horaSolicitudF" name="horaSolicitudF">
        <input type="text" value="Esto es una prueba de generar un pdf" id="detalles" name="detalles">

        <input type="text" value="si" id="impresoraString" name="impresoraString">

        <button type="submit">enviar</button>
    </form>

</body>

</html>