<?php
$url = getenv("DATABASE_URL");

if (!$url) {
    die("DATABASE_URL not found");
}

echo "URL FOUND<br>";

$parts = parse_url($url);

print_r($parts);
exit();