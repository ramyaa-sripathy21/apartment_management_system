<?php
$url = getenv("mysql://root:vZEXDTBzvlcomKzdICMhNCgJLRDoxDLV@centerbeam.proxy.rlwy.net:38513/railway");

$db = parse_url($url);

$host = $db['host'];
$user = $db['user'];
$pass = $db['pass'];
$dbname = ltrim($db['path'], '/');
$port = $db['port'];

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>