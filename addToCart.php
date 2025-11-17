<?php
session_start();
require_once 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit();
}

$productId = (int)$data['id'];
$quantity = (int)$data['quantity'];

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$userId = $_SESSION['id'] ?? null;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User ID is missing from session.']);
    exit();
}


$username = $_SESSION['username'];
$tableName = "cart_" . $username;

// Fetch the product from products table
$productQuery = $conn->prepare("SELECT `id`, `name`, `price`, `image_path` FROM `products` WHERE `id` = ?");
$productQuery->bind_param("i", $productId);
$productQuery->execute();
$productResult = $productQuery->get_result();

if ($productResult->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Product not found.']);
    exit();
}

$product = $productResult->fetch_assoc();
$productQuery->close();

$totalPrice = $product['price'] * $quantity;

// Create user cart table if it doesn't exist
$createTableSQL = "
    CREATE TABLE IF NOT EXISTS `$tableName` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `total_price` DECIMAL(10,2) NOT NULL,

  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

";

if (!$conn->query($createTableSQL)) {
    echo json_encode(['success' => false, 'message' => 'Failed to create cart table.']);
    exit();
}

// 🔥 Check if product already exists in cart
$checkCartSQL = "SELECT * FROM `$tableName` WHERE `product_id` = ?";
$checkStmt = $conn->prepare($checkCartSQL);
$checkStmt->bind_param("i", $productId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // 🚀 Product exists → Update quantity + total
    $existing = $checkResult->fetch_assoc();
    $newQuantity = $existing['quantity'] + $quantity;
    $newTotal = $product['price'] * $newQuantity;

    $updateSQL = "UPDATE `$tableName` SET `quantity` = ?, `total` = ? WHERE `product_id` = ?";
    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bind_param("idi", $newQuantity, $newTotal, $productId);
    $updateStmt->execute();
    $updateStmt->close();
} else {
    // 🚀 Product not exists → Insert new row
    $insertSQL = "
        INSERT INTO `$tableName` (`user_id`, `product_id`, `quantity`, `total_price`)
        VALUES (?, ?, ?, ?)
    ";
    $insertStmt = $conn->prepare($insertSQL);
    $insertStmt->bind_param(
        "iiid",
        $userId,
        $productId,
        $quantity,
        $totalPrice
    );
    
    $insertStmt->execute();
    $insertStmt->close();
}

$checkStmt->close();

// Now fetch updated cart count
$countResult = $conn->query("SELECT SUM(quantity) AS total_quantity FROM `$tableName`");
$row = $countResult->fetch_assoc();
$count = (int) ($row['total_quantity'] ?? 0);

echo json_encode(['success' => true, 'count' => $count]);
?>
