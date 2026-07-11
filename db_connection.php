<?php
// Supports both Docker (env vars) and local XAMPP (fallback defaults)
$host = getenv('DB_HOST')     ?: "localhost";
$user = getenv('DB_USER')     ?: "root";
$pass = getenv('DB_PASSWORD') ?: "";
$db   = getenv('DB_NAME')     ?: "furniture_db";
$port = (int)(getenv('DB_PORT') ?: 3306);

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>