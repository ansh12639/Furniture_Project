<?php
ini_set('display_errors', 0);
error_reporting(0);

include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username         = trim($_POST["username"]);
    $email            = trim($_POST["email"]);
    $password         = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Basic validation
    if ($password !== $confirm_password) {
        // echo "Passwords do not match. <a href='signup.html'>Try again</a>";
        header("Location: signup.html?error=password_mismatch");
        exit();
    }

    // Hash password
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $checkQuery = "SELECT `username`, `email` FROM `users` WHERE `username` = ? OR `email` = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param("ss", $username, $email);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        $existing = $result->fetch_assoc();
        if ($existing['username'] === $username) {
            header("Location: signup.html?error=username_exists");
        } else {
            header("Location: signup.html?error=email_exists");
        }
        $stmtCheck->close();
        exit();
    }
    $stmtCheck->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    try {
        $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: login.html?success=registration_successful");
            exit();
        } else {
            $stmt->close();
            header("Location: signup.html?error=registration_failed");
            exit();
        }
    } catch (Exception $e) {
        error_log("Signup error: " . $e->getMessage());
        header("Location: signup.html?error=registration_failed");
        exit();
    }
}
?>
