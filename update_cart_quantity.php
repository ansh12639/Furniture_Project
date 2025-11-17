<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$username = $_SESSION['username'];
$cartTable = "cart_" . $username;
$productId = $_POST['product_id'] ?? '';
$quantity = (int)($_POST['quantity'] ?? 0);

if (empty($productId) || $quantity < 1) {
    echo json_encode(['success' => false, 'message' => 'Invalid product or quantity']);
    exit;
}

try {
    // Fetch product price
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    $totalPrice = $quantity * $product['price'];

    // Update quantity and total_price
    $stmt = $conn->prepare("UPDATE `$cartTable` SET quantity = ?, total_price = ? WHERE product_id = ?");
    $stmt->bind_param("idi", $quantity, $totalPrice, $productId);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Cart updated', 'new_total' => $totalPrice]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error updating cart: ' . $e->getMessage()]);
}
?>
