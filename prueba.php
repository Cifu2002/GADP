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
<script>
    fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            console.log("IP Pública: " + data.ip);
        });
</script>
<script>
    const pc = new RTCPeerConnection();
    pc.createDataChannel("");
    pc.createOffer(pc.setLocalDescription.bind(pc), () => {});

    pc.onicecandidate = function(event) {
        if (event.candidate) {
            const ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3})/;
            const ip_address = ip_regex.exec(event.candidate.candidate)[1];
            console.log("IP Local: " + ip_address);
        }
    };
</script>
