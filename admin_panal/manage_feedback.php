<?php
session_start();
include __DIR__ . '/../db_connection.php'; // Include your database connection file

// ⭐⭐⭐ Handle form submission ⭐⭐⭐
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_email']) && isset($_SESSION['user_name'])) {
        $your_name = $_SESSION['user_name'];
        $email = $_SESSION['user_email'];
        $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

        if (empty($message)) {
            die("Message cannot be empty.");
        }

        $stmt = $conn->prepare("INSERT INTO `contact_messages` (`your_name`, `email`, `message`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $your_name, $email, $message);

        if ($stmt->execute()) {
            echo "Feedback submitted successfully!";
        } else {
            echo "Failed to submit feedback.";
        }

        $stmt->close();
    } else {
        echo "User not logged in.";
    }
}

// ⭐⭐⭐ Fetch feedback messages ⭐⭐⭐
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1>Manage Feedback</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">Back</a>
        </div>

        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Your Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['your_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <a href="delete_feedback.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this feedback?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">No feedback found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$conn->close();
?>
