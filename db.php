<?php
$url = getenv("DATABASE_URL");

if (!$url) {
    die("DATABASE_URL not set");
}

$parts = parse_url($url);

$host = $parts['host'];
$user = $parts['user'];
$pass = $parts['pass'];
$db   = ltrim($parts['path'], '/');
$port = $parts['port'];

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>