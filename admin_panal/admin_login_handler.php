<?php
session_start();
include __DIR__ . '/../db_connection.php';// Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $query = "SELECT * FROM `admins` WHERE `username` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Plain password comparison (NO HASHING)
    if ($user && ($password === $user['password'] || password_verify($password, $user['password']))) { 
        $_SESSION["id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: admin_dashboard.php");
        exit(); 
    } else {
        header("Location: admin_login.php?error=invalid");
        exit();
    }
}
?>
