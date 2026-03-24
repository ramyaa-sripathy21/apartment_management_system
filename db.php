<?php
$host = "enterbeam.proxy.rlwy.net";
$user = "root";
$pass = "vZEXDTBzvIcomKzdICMhNCgJlRDoxDLV";
$db   = "railway";
$port = 38513;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>