<?php
$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$password = getenv("DB_PASS");
$db = getenv("DB_NAME");

$conn = new mysqli($host, $user, $password, $db);
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
