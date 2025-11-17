<?php
session_start(); // Required to access session variables
include 'C:\xampp\htdocs\Furniture_Project\db_connection.php';

// Retrieve form inputs safely
$username = $_POST['your_name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

// Check if user is logged in (assumes login sets $_SESSION['email'])
$user_id = null;

if (!empty($_SESSION['email'])) {
    $sessionEmail = $_SESSION['email'];
    
    // Look up user ID from users table
    $stmtUser = $conn->prepare("SELECT `id` FROM `users` WHERE `email` = ?");
    $stmtUser->bind_param("s", $sessionEmail);
    $stmtUser->execute();
    $result = $stmtUser->get_result();

    if ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
    }
    $stmtUser->close();
}

// Prepare insert statement with or without user_id
if ($user_id !== null) {
    $stmt = $conn->prepare("INSERT INTO `contact_messages` (`user_id`, `your_name`, `email`, `message`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $username, $email, $message);
} else {
    $stmt = $conn->prepare("INSERT INTO `contact_messages` (`your_name`, `email`, `message`) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $message);
}

// Execute insert
if ($stmt->execute()) {
    echo "Message saved successfully.";
} else {
    echo "Failed to save message. Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
