<?php
include __DIR__ . '/../db_connection.php'; // Include your database connection file

// Get the user ID safely
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Delete the user securely
$stmt = $conn->prepare("DELETE FROM `users` WHERE `id` = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: manage_users.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
