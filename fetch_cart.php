<?php
session_start();
include "db_connection.php";

$cart = $_SESSION['cart'] ?? [];

$products = [];

if (!empty($cart)) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");

    $cartKeys = array_keys($cart);
    $stmt->bind_param(str_repeat('i', count($cart)), ...$cartKeys);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $row['quantity'] = $cart[$row['id']];
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);
?>
