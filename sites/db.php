<?php
    $servername = "localhost";
    $username = "admin@gmail.com";
    $password = "adminw23bif";
    $dbname = "MuayadAndBertan";
    // Verbindung erstellen
    $db = new mysqli($servername,$username,$password,$dbname);
    // Verbindungsfehlermeldung
    if($db->connect_error){
        echo "Error connecting to $dbname: " .  $db->connect_error;
        exit(1);
    }
?>