<?php
include __DIR__ . '/../db_connection.php';
session_start();

if (isset($_POST['submit'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $applied_at = date('Y-m-d H:i:s');

    // Handle file uploads (optional: resume and image)
    $resume_path = '';
    $image_path = '';

    if (isset($_FILES['resume']['tmp_name']) && $_FILES['resume']['tmp_name'] != '') {
        $resume_filename = time() . '_resume_' . basename($_FILES['resume']['name']);
        $resume_destination = 'uploads/' . $resume_filename;
        move_uploaded_file($_FILES['resume']['tmp_name'], $resume_destination);
        $resume_path = $resume_destination;
    }

    if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != '') {
        $image_filename = time() . '_img_' . basename($_FILES['image']['name']);
        $image_destination = 'uploads/' . $image_filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_destination);
        $image_path = $image_destination;
    }

    $sql = "INSERT INTO job_applications (full_name, email, position, resume_path, applied_at, image_path)
            VALUES ('$full_name', '$email', '$position', '$resume_path', '$applied_at', '$image_path')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Application added successfully!";
        $_SESSION['messageClass'] = "bg-success";
        header("Location: manage_job_applications.php");
        exit;
    } else {
        $_SESSION['message'] = "Error adding application: " . $conn->error;
        $_SESSION['messageClass'] = "bg-danger";
        header("Location: manage_job_applications.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Add New Application</h1>
        <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Position</label>
                <input type="text" name="position" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Resume (PDF)</label>
                <input type="file" name="resume" class="form-control" accept=".pdf">
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Image (JPG/PNG)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" name="submit" class="btn btn-success">Add Application</button>
            <a href="manage_job_applications.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>