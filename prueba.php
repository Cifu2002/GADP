<?php
// Obtener IP de la máquina
$ip = getHostByName(getHostName());

// Obtener MAC de la máquina (ejemplo para Windows)
$mac = shell_exec("getmac /v /fo list | findstr /C:\"Dirección física\"");
$mac = trim($mac);

// Mostrar IP y MAC
echo "IP: " . $ip . "<br>";
echo "MAC: " . $mac . "<br>";
?>
