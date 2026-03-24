<?php
// Railway connection (NO localhost)

$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$pass = getenv("MYSQLPASSWORD");
$db   = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");

// Fallback (for safety)
if (!$host) {
    $host = "containers-us-west-xxx.railway.app"; // replace if needed
    $user = "root";
    $pass = "your_password";
    $db   = "railway";
    $port = 3306;
}

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>