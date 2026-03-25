<?php
$host = "centerbeam.proxy.rlwy.net";
$user = "root";
$pass = "DeKvUstBhzRMBiOdsJmbwCjjiUzIvpAb";
$db   = "railway";
$port = 58624;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>