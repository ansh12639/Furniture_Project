<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(['count' => 0]);
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$tableName = "cart_" . $username;

// Check if the table exists
$checkTable = $conn->query("SHOW TABLES LIKE '$tableName'");
if ($checkTable->num_rows == 0) {
    echo json_encode(['count' => 0]);
    exit();
}

// Count the number of products
$result = $conn->query("SELECT SUM(quantity) as total_quantity FROM `$tableName`");
$row = $result->fetch_assoc();

$count = (int) ($row['total_quantity'] ?? 0);

echo json_encode(['count' => $count]);
?>
