<?php
include 'C:\xampp\htdocs\Furniture_Project\db_connection.php';
session_start(); // Required to read session message

// Fetch job applications along with user ID (or username/email if preferred)
$sql = "
    SELECT ja.*, u.id AS user_id, u.email AS user_email
    FROM job_applications ja
    LEFT JOIN users u ON ja.user_id = u.id
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Job Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
    <!-- Success Message Toast -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
            <div id="liveToast" class="toast align-items-center text-white <?php echo $_SESSION['messageClass']; ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.getElementById('liveToast');
                if (toastEl) {
                    var toast = new bootstrap.Toast(toastEl, {
                        autohide: true,
                        delay: 3000
                    });
                    toast.show();
                }
            });
        </script>
        <?php unset($_SESSION['message'], $_SESSION['messageClass']); ?>
    <?php endif; ?>

    <div class="container py-5">
        <h1 class="mb-4">Manage Job Applications</h1>
        <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Back</a>
        <a href="add_application.php" class="btn btn-success mb-3">Add New Application</a>

        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Resume</th>
                    <th>Applied At</th>
                    <th>Image</th>
                    <th>User ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['position']); ?></td>
                        <td>
                            <?php if (!empty($row['resume_path'])): ?>
                                <a href="<?php echo '../' . $row['resume_path']; ?>" target="_blank" class="btn btn-info btn-sm">View Resume</a>
                            <?php else: ?>
                                <span class="text-muted">No Resume</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['applied_at']; ?></td>
                        <td>
                            <?php if (!empty($row['image_path'])): ?>
                                <img src="<?php echo '../' . $row['image_path']; ?>" width="50" height="50" class="img-thumbnail">
                            <?php else: ?>
                                <span class="text-muted">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['user_id'] ?? 'N/A'); ?></td>
                        <td>
                            <a href="edit_application.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_application.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
