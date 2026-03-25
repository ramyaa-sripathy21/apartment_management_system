<?php
$host = "centerbeam.proxy.rlwy.net";
$port = 38513;
$user = "root";
$password = "vZEXDTBzvlcomKzdICMhNCgJLRDoxDLV";
$database = "railway";

$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>