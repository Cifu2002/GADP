<?php
$batchFilePath = 'run_java.bat';

$command = "cmd /c \"$batchFilePath\"";

$output = shell_exec($command);

$ip = '';
$mac = '';

if ($output === null) {
    $error = error_get_last();
    echo "Error al ejecutar el comando: " . $error['message'];
} else {
   
    if (preg_match('/IP: ([\d\.]+)/', $output, $ip_matches)) {
        $ip = $ip_matches[1];
    }
    if (preg_match('/MAC: ([\w-]+)/', $output, $mac_matches)) {
        $mac = $mac_matches[1];
    }


    header("Location: index.php?ip=" . urlencode($ip) . "&mac=" . urlencode($mac));
    exit;
}

?>
