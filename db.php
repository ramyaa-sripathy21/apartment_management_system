<?php
// Railway MySQL connection

$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$pass = getenv("MYSQLPASSWORD");
$db   = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");

// Create connection
$conn = new mysqli($host, $user, $pass, $db, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>