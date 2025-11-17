<?php 

session_start();
$loggedIn = isset($_SESSION['username']);
$username = $loggedIn ? $_SESSION['username'] : null;


header("Content-Type: application/json");

include "db_connection.php";

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Product ID is required."]);
    exit();
}

$id = intval($_GET['id']);

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT `id`, `image_path`, `name`, `info`, `price`, `description`, `quantity` FROM `products` WHERE `id` = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Product not found."]);
}

$stmt->close();
$conn->close();







?>