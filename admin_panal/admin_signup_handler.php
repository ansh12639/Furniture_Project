<?php
session_start();
include __DIR__ . '/../db_connection.php'; // Make sure your DB connection path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Check if username already exists
    $checkQuery = $conn->prepare("SELECT `id` FROM `admin_users` WHERE `username` = ?");
    $checkQuery->bind_param("s", $username);
    $checkQuery->execute();
    $checkQuery->store_result();

    if ($checkQuery->num_rows > 0) {
        // Username already taken
        header("Location: admin_signup.php?error=Username already exists");
        exit();
    } else {
        // Insert new admin
        $insertQuery = $conn->prepare("INSERT INTO `admin_users` (`username`,`password`) VALUES (?, ?)");
        $insertQuery->bind_param("ss", $username, $password);

        if ($insertQuery->execute()) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            $_SESSION['username'] = $username; // Keep in sync with admin_login_handler and dashboard check
            header("Location: admin_dashboard.php");
            exit();
        } else {
            die("Registration failed: " . $conn->error);
        }
    }
}
?>
