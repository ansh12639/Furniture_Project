<?php
session_start();
header("Content-Type: application/json");

include "db_connection.php";


// session_start();
// header("Content-Type: application/json");

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

echo json_encode(['success' => true, 'cart' => $cart]);

// $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// $cartItems = [];

// foreach ($cart as $productId => $quantity) {
//     $stmt = $conn->prepare("SELECT `id`, `name`, `image_path`, `price` FROM `products` WHERE `id` = ?");
//     $stmt->bind_param("i", $productId);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     if ($row = $result->fetch_assoc()) {
//         $row['quantity'] = $quantity;
//         $cartItems[] = $row;
//     }
//     $stmt->close();
// }

// echo json_encode($cartItems);

// $conn->close();
?>