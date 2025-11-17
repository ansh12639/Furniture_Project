

<?php
include "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']); // Sanitize input

    // Fetch product price
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'price' => floatval($product['price'])]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Product not found']);
    }

    $stmt->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

$conn->close();
?>