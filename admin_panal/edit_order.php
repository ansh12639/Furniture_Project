<?php
include __DIR__ . '/../db_connection.php';

$id = $_GET['order_id'] ?? '';

$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];

    $update = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $update->bind_param("ss", $status, $id);

    if ($update->execute()) {
        header("Location: view_order.php?order_id=" . urlencode($id));
        exit;
    } else {
        $error = "Failed to update order.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Order</title>
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
        .lux-header {
            font-size: 2.2rem;
            font-weight: bold;
            color: #3b2f63;
        }
        .form-label {
            font-weight: 600;
            color: #555;
        }
        .btn-save {
            background-color: #3b2f63;
            border: none;
        }
        .btn-save:hover {
            background-color: #2a2046;
        }
        .btn-back {
            background-color: #888;
            border: none;
        }
        .btn-back:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="lux-header mb-4">Edit Order Status</h1>
    <a href="view_order.php?order_id=<?= urlencode($id) ?>" class="btn btn-back text-white mb-4">← Back to Order</a>

    <?php if ($order): ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post" class="lux-card">
            <div class="mb-3">
                <label for="status" class="form-label">Order Status</label>
                <select name="status" id="status" class="form-select">
                    <?php
                    $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
                    foreach ($statuses as $s):
                    ?>
                        <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>>
                            <?= ucfirst($s) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-save text-white">Save Changes</button>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">Order not found.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
