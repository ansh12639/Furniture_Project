<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$username = $_SESSION['username'];
$tableName = "cart_" . $username;

// Check if table exists
$checkTable = $conn->query("SHOW TABLES LIKE '$tableName'");
if ($checkTable->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Cart table not found']);
    exit();
}

// Join cart with products to get name and image_path
$sql = "
    SELECT c.*, p.name, p.image_path 
    FROM `$tableName` c 
    JOIN products p ON c.product_id = p.id
";

$result = $conn->query($sql);

$cartItems = [];

while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

echo json_encode(['success' => true, 'cart' => $cartItems]);
?>
