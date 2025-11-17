<?php
session_start();
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $query = "SELECT * FROM `users` WHERE `username` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user && $password == $user['password']) {
        $_SESSION["id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"]; // ✅ Add this line to store the email
        header("Location: dashboard.php");
        exit(); 
    } else {
        header("Location: login.html?error=invalid");
        exit();
    }
}



?>
