<?php
$ip = isset($_GET['ip']) ? $_GET['ip'] : 'No disponible';
$mac = isset($_GET['mac']) ? $_GET['mac'] : 'No disponible';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>IP: <?php echo htmlspecialchars($ip); ?></h1>
    <h1>MAC: <?php echo htmlspecialchars($mac); ?></h1>
</body>
</html>
