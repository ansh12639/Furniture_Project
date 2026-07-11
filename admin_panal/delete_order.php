<?php
include __DIR__ . '/../db_connection.php'; // Include your database connection file

$id = $_GET['id'];

// Delete order
$sql = "DELETE FROM `orders` WHERE `id` = $id";

if ($conn->query($sql) === TRUE) {
    header('Location: manage_orders.php');
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
