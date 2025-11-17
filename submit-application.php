<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ✅ Retrieve user ID from session
    if (!isset($_SESSION['user_id'])) {
        echo "<h2>❌ You must be logged in to submit an application.</h2>";
        exit;
    }

    $userId = $_SESSION['user_id'];
    $fullName = htmlspecialchars($_POST["full_name"]);
    $email = htmlspecialchars($_POST["email"]);
    $position = htmlspecialchars($_POST["position"]);

    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // === Resume Upload ===
    $resume = $_FILES["resume"];
    $resumeName = basename($resume["name"]);
    $resumePath = $uploadDir . time() . "_resume_" . $resumeName;
    $resumeExt = strtolower(pathinfo($resumePath, PATHINFO_EXTENSION));
    $allowedResumeExts = ["pdf", "doc", "docx"];

    // === Image Upload ===
    $image = $_FILES["image"];
    $imageName = basename($image["name"]);
    $imagePath = $uploadDir . time() . "_img_" . $imageName;
    $imageExt = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
    $allowedImageExts = ["jpg", "jpeg", "png"];

    // === Validation ===
    $errors = [];

    if (!in_array($resumeExt, $allowedResumeExts)) {
        $errors[] = "Invalid resume file type. Only PDF, DOC, DOCX allowed.";
    }

    if (!in_array($imageExt, $allowedImageExts)) {
        $errors[] = "Invalid image file type. Only JPG, JPEG, PNG allowed.";
    }

    if ($resume["size"] > 5 * 1024 * 1024) {
        $errors[] = "Resume is too large. Max size is 5MB.";
    }

    if ($image["size"] > 3 * 1024 * 1024) {
        $errors[] = "Image is too large. Max size is 3MB.";
    }

    if (empty($errors)) {
        if (
            move_uploaded_file($resume["tmp_name"], $resumePath) &&
            move_uploaded_file($image["tmp_name"], $imagePath)
        ) {
            // ✅ Insert with user_id included
            $stmt = $conn->prepare("INSERT INTO `job_applications` (`full_name`, `email`, `position`, `resume_path`, `image_path`, `user_id`) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $fullName, $email, $position, $resumePath, $imagePath, $userId);

            if ($stmt->execute()) {
                header("Location: careers.html?success=1");
                exit;
            } else {
                echo "<h2>❌ Database error: " . $stmt->error . "</h2>";
            }

            $stmt->close();
        } else {
            echo "<h2>❌ File upload failed. Please try again.</h2>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>❌ $error</p>";
        }
    }
}

$conn->close();
