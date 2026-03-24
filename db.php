<?php
$url = getenv("DATABASE_URL");

if (!$url) {
    die("DATABASE_URL missing");
}

$db = parse_url($url);

if (!$db || !isset($db['host'])) {
    die("Invalid DATABASE_URL");
}

$host = $db['host'];
$user = $db['user'];
$pass = $db['pass'];
$dbname = ltrim($db['path'], '/');
$port = $db['port'];

$conn = new mysqli("localhost", "root", "", "your_database_name");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>