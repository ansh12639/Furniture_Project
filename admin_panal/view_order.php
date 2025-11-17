<?php
include 'C:\xampp\htdocs\Furniture_Project\db_connection.php';

$id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

$stmt = $conn->prepare("
    SELECT orders.*, users.email 
    FROM orders 
    JOIN users ON orders.user_id = users.id 
    WHERE orders.order_id = ?
");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
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
    <h1 class="lux-header mb-4">Order Overview</h1>
    <a href="manage_orders.php" class="btn btn-back text-white mb-4">← Back to Orders</a>

    <?php if ($order): ?>
        <div class="lux-card">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="lux-label">Order ID:</p>
                    <p class="lux-value"><?= htmlspecialchars($order['order_id']) ?></p>
                </div>
                <div class="col-md-6">
                    <p class="lux-label">User Email:</p>
                    <p class="lux-value"><?= htmlspecialchars($order['email']) ?></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="lux-label">Product ID:</p>
                    <p class="lux-value"><?= htmlspecialchars($order['product_id']) ?></p>
                </div>
                <div class="col-md-6">
                    <p class="lux-label">Quantity:</p>
                    <p class="lux-value"><?= htmlspecialchars($order['quantity']) ?></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="lux-label">Total Amount:</p>
                    <p class="lux-value">$<?= htmlspecialchars($order['total_amount']) ?></p>
                </div>
                <div class="col-md-6">
                    <p class="lux-label">Order Date:</p>
                    <p class="lux-value"><?= htmlspecialchars($order['order_date']) ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p class="lux-label">Status:</p>
                    <p>
                        <span class="badge px-3 py-2 
                            <?= match ($order['status']) {
                                'pending' => 'bg-warning text-dark',
                                'processing' => 'bg-primary',
                                'shipped' => 'bg-info text-dark',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default => 'bg-secondary',
                            } ?>">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Order not found.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
