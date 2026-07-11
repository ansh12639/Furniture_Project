<?php
include __DIR__ . '/../db_connection.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM job_applications WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Application deleted successfully!";
        $_SESSION['messageClass'] = "bg-success";
        header("Location: manage_job_applications.php");
        exit;
    } else {
        $_SESSION['message'] = "Error deleting application: " . $conn->error;
        $_SESSION['messageClass'] = "bg-danger";
        header("Location: manage_job_applications.php");
        exit;
    }
} else {
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['messageClass'] = "bg-danger";
    header("Location: manage_job_applications.php");
    exit;
}
