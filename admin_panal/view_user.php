<?php
include __DIR__ . '/../db_connection.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f3f1f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .lux-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .lux-label {
            font-weight: 600;
            color: #555;
        }
        .lux-value {
            font-size: 1.1rem;
            color: #2d2d2d;
        }
        .lux-header {
            font-size: 2.2rem;
            font-weight: bold;
            color: #3b2f63;
        }
        .btn-back {
            background-color: #3b2f63;
            border: none;
        }
        .btn-back:hover {
            background-color: #2a2046;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="lux-header mb-4">User Overview</h1>
    <a href="manage_users.php" class="btn btn-back text-white mb-4">← Back to Users</a>

    <?php if ($user): ?>
        <div class="lux-card">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="lux-label">User ID:</p>
                    <p class="lux-value"><?= htmlspecialchars($user['id']) ?></p>
                </div>
                <div class="col-md-6">
                    <p class="lux-label">Username:</p>
                    <p class="lux-value"><?= htmlspecialchars($user['username']) ?></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="lux-label">Email:</p>
                    <p class="lux-value"><?= htmlspecialchars($user['email']) ?></p>
                </div>
                <div class="col-md-6">
                    <p class="lux-label">Registered On:</p>
                    <p class="lux-value"><?= htmlspecialchars($user['created_at'] ?? 'N/A') ?></p>
                </div>
            </div>

            <?php if (!empty($user['address'])): ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="lux-label">Address:</p>
                    <p class="lux-value"><?= nl2br(htmlspecialchars($user['address'])) ?></p>
                </div>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <p class="lux-label">Role:</p>
                    <p>
                        <span class="badge px-3 py-2 
                            <?= isset($user['role']) && $user['role'] === 'admin' ? 'bg-primary' : 'bg-success' ?>">
                            <?= isset($user['role']) ? ucfirst(htmlspecialchars($user['role'])) : 'User' ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">User not found.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>