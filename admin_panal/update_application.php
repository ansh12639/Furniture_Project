<?php
include 'C:\xampp\htdocs\Furniture_Project\db_connection.php';
session_start();

// Make sure form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $position = $conn->real_escape_string($_POST['position']);

    // Initialize resume and image paths
    $resume_path = "";
    $image_path = "";

    // Fetch current data
    $sqlFetch = "SELECT * FROM `job_applications` WHERE id = $id";
    $resultFetch = $conn->query($sqlFetch);
    if ($resultFetch->num_rows != 1) {
        $_SESSION['message'] = "Application not found!";
        $_SESSION['messageClass'] = "bg-danger";
        header("Location: manage_job_applications.php");
        exit();
    }
    $currentData = $resultFetch->fetch_assoc();

    // Handle Resume Upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $resume_ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
        if ($resume_ext == "pdf") {
            $resume_path = "uploads/resumes/" . uniqid() . "_" . basename($_FILES['resume']['name']);
            move_uploaded_file($_FILES['resume']['tmp_name'], "../" . $resume_path);
        } else {
            $_SESSION['message'] = "Resume must be a PDF file.";
            $_SESSION['messageClass'] = "bg-danger";
            header("Location: edit_application.php?id=$id");
            exit();
        }
    } else {
        $resume_path = $currentData['resume_path'];
    }

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($image_ext, ['jpg', 'jpeg', 'png'])) {
            $image_path = "uploads/images/" . uniqid() . "_" . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], "../" . $image_path);
        } else {
            $_SESSION['message'] = "Image must be a JPG or PNG file.";
            $_SESSION['messageClass'] = "bg-danger";
            header("Location: edit_application.php?id=$id");
            exit();
        }
    } else {
        $image_path = $currentData['image_path'];
    }

    // Update the database
    $sqlUpdate = "UPDATE `job_applications` 
                  SET full_name='$full_name', 
                      email='$email', 
                      position='$position', 
                      resume_path='$resume_path', 
                      image_path='$image_path' 
                  WHERE id = $id";

    if ($conn->query($sqlUpdate)) {
        $_SESSION['message'] = "Application updated successfully!";
        $_SESSION['messageClass'] = "bg-success";
    } else {
        $_SESSION['message'] = "Error updating application: " . $conn->error;
        $_SESSION['messageClass'] = "bg-danger";
    }

    header("Location: manage_job_applications.php");
    exit();
} else {
    $_SESSION['message'] = "Invalid request!";
    $_SESSION['messageClass'] = "bg-danger";
    header("Location: manage_job_applications.php");
    exit();
}
?>
