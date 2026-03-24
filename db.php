<?php
$host = "mysql.railway.internal";
$user = "root";
$pass = "vZEXDTBzvlcomKzdICMhNCgJLRDoxDLV";
$db   = "railway";
$port = 3306;

// Create connection
$conn = new mysqli($host, $user, $pass, $db, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>