<?php
session_start();
include "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;
    $total = $_POST['total'] ?? 0;

    if (!$product_id) {
        die("Invalid Request: Missing product_id!");
    }

    // Ensure user session is valid
    if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
        die("User not logged in!");
    }

    $username = $_SESSION['username'];
    $user_email = $_SESSION['email'];
    $user_table = 'orders_' . preg_replace('/[^a-zA-Z0-9_]/', '', $username);

    // Fetch user_id
    $userResult = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$userResult) {
        die("Prepare failed for user lookup: " . $conn->error);
    }
    $userResult->bind_param("s", $user_email);
    $userResult->execute();
    $userData = $userResult->get_result();
    if ($userData->num_rows === 0) {
        die("User not found in database.");
    }
    $user = $userData->fetch_assoc();
    $user_id = $user['id'];

    $order_id = uniqid("ORD_"); // Unique order ID

    // Fetch product details
    $productStmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    if (!$productStmt) {
        die("Prepare failed for product lookup: " . $conn->error);
    }
    $productStmt->bind_param("i", $product_id);
    $productStmt->execute();
    $productResult = $productStmt->get_result();
    if ($productResult->num_rows === 0) {
        die("Product not found!");
    }
    $product = $productResult->fetch_assoc();
    $price_at_order = $product['price']; // Optional: log price at time of order

    // Create user-specific order table if it doesn't exist
    $createUserTableSQL = "
        CREATE TABLE IF NOT EXISTS `$user_table` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id VARCHAR(255) NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            price_at_order DECIMAL(10,2) NOT NULL,
            order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ";
    if (!$conn->query($createUserTableSQL)) {
        die("Error creating user-specific order table: " . $conn->error);
    }

    // Insert into main orders table
    $insertOrderStmt = $conn->prepare("INSERT INTO `orders` (`order_id`, `product_id`, `user_id`, `quantity`, `total_amount`) VALUES (?, ?, ?, ?, ?)");
    if (!$insertOrderStmt) {
        die("Prepare failed for orders insert: " . $conn->error);
    }
    $insertOrderStmt->bind_param("siiid", $order_id, $product_id, $user_id, $quantity, $total);
    $insertOrderStmt->execute();

    // Insert into user-specific order table
    $insertUserStmt = $conn->prepare("INSERT INTO `$user_table` (`order_id`, `product_id`, `quantity`, `price_at_order`) VALUES (?, ?, ?, ?)");
    if (!$insertUserStmt) {
        die("Prepare failed for user order insert: " . $conn->error);
    }
    $insertUserStmt->bind_param("siid", $order_id, $product_id, $quantity, $price_at_order);
    $insertUserStmt->execute();

    // Save order_id in session
    $_SESSION['order_id'] = $order_id;

    // Cleanup
    $userResult->close();
    $productStmt->close();
    $insertUserStmt->close();
    $insertOrderStmt->close();
    $conn->close();

    // Redirect to dashboard
    header("Location: dashboard.php?success=1&order_id=$order_id");
    exit();
} else {
    header("Location: cart_onclick.php");
    exit();
}
?>
