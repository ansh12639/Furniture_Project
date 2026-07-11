<?php
// Supports both Docker (env vars) and hosting default fallbacks (InfinityFree)
$host = getenv('DB_HOST')     ?: "sql308.infinityfree.com";
$user = getenv('DB_USER')     ?: "if0_42385444";
$pass = getenv('DB_PASSWORD') ?: "Ansh1vish";
$db   = getenv('DB_NAME')     ?: "if0_42385444_furniture_db";
$port = (int)(getenv('DB_PORT') ?: 3306);

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>