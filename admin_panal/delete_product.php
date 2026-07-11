<?php
include __DIR__ . '/../db_connection.php';// Include your database connection file

$id = $_GET['id'];

$sql = "DELETE FROM `products` WHERE `id`=$id";
if ($conn->query($sql) === TRUE) {
    header("Location: manage_products.php");
} else {
    echo "Error deleting product: " . $conn->error;
}
?>
