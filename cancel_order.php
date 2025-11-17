
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html?error=required");
    exit();
}

if (!isset($_GET['order_id'])) {
    header("Location: orders.php?error=missing_order_id");
    exit();
}

$username = $_SESSION['username'];
$orderId = $_GET['order_id'];
$tableName = 'orders_' . preg_replace('/[^a-zA-Z0-9_]/', '', $username);

include "db_connection.php";

try {
    // Check if table exists
    $tableCheck = $conn->query("SHOW TABLES LIKE '$tableName'");
    if ($tableCheck->num_rows === 0) {
        throw new Exception("Order table does not exist.");
    }

    // Delete the order
    $stmt = $conn->prepare("DELETE FROM `$tableName` WHERE `order_id` = ?");
    $stmt->bind_param("s", $orderId);

    if ($stmt->execute()) {
        header("Location: orders.php?success=order_cancelled");
        exit();
    } else {
        throw new Exception("Failed to cancel order.");
    }
} catch (Exception $e) {
    error_log("Error cancelling order: " . $e->getMessage());
    header("Location: orders.php?error=cancellation_failed");
    exit();
} finally {
    $conn->close();
}
?>
