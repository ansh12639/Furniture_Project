<?php
include 'C:\xampp\htdocs\Furniture_Project\db_connection.php';
session_start(); // Required for session messages

// Check if ID is set
if (!isset($_GET['id'])) {
    $_SESSION['message'] = "No application selected!";
    $_SESSION['messageClass'] = "bg-danger";
    header("Location: manage_job_applications.php");
    exit();
}

$id = intval($_GET['id']); // Protect from SQL Injection

// Fetch the application by ID
$sql = "SELECT * FROM `job_applications` WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    $_SESSION['message'] = "Application not found!";
    $_SESSION['messageClass'] = "bg-danger";
    header("Location: manage_job_applications.php");
    exit();
}

$application = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4">Edit Job Application</h1>
    <a href="manage_job_applications.php" class="btn btn-secondary mb-3">Back</a>

    <form action="update_application.php" method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow rounded">
        <input type="hidden" name="id" value="<?php echo $application['id']; ?>">

        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name:</label>
            <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo htmlspecialchars($application['full_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($application['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Position:</label>
            <input type="text" id="position" name="position" class="form-control" value="<?php echo htmlspecialchars($application['position']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Resume:</label><br>
            <?php if (!empty($application['resume_path'])): ?>
                <a href="../<?php echo $application['resume_path']; ?>" target="_blank" class="btn btn-info btn-sm">View Current Resume</a>
            <?php else: ?>
                <span class="text-muted">No Resume Uploaded</span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="resume" class="form-label">Upload New Resume (PDF only):</label>
            <input type="file" id="resume" name="resume" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image:</label><br>
            <?php if (!empty($application['image_path'])): ?>
                <img src="../<?php echo $application['image_path']; ?>" width="80" height="80" class="img-thumbnail">
            <?php else: ?>
                <span class="text-muted">No Image Uploaded</span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Upload New Image (jpg/png):</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Application</button>
    </form>
</div>

</body>
</html>
