<?php
include __DIR__ . '/../db_connection.php';

// Get search filters from the query string
$searchEmail = $_GET['search_email'] ?? '';
$searchStatus = $_GET['search_status'] ?? '';

// Build the SQL query with optional filters
$sql = "SELECT orders.*, users.email 
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        WHERE 1";

if (!empty($searchEmail)) {
    $escapedEmail = $conn->real_escape_string($searchEmail);
    $sql .= " AND users.email LIKE '%$escapedEmail%'";
}

if (!empty($searchStatus)) {
    $escapedStatus = $conn->real_escape_string($searchStatus);
    $sql .= " AND orders.status = '$escapedStatus'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f3f1f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .lux-header {
            font-size: 2.5rem;
            font-weight: bold;
            color: #3b2f63;
        }
        .table-wrapper {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #3b2f63;
            color: white;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .table th {
            font-weight: bold;
        }
        .table td {
            font-size: 0.9rem;
        }
        .table tr:hover {
            background-color: #f1f1f1;
        }
        .btn-edit {
            background-color: #3b2f63;
            color: white;
            border: none;
        }
        .badge {
            padding: 0.4em 0.7em;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4">Manage Orders</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="admin_dashboard.php" class="btn btn-secondary">Back</a>
    </div>

    <!-- Search/Filter Form -->
    <form method="GET" class="mb-4 row g-3">
        <div class="col-md-4">
            <input type="text" name="search_email" class="form-control" placeholder="Search by Email"
                   value="<?= htmlspecialchars($searchEmail) ?>">
        </div>
        <div class="col-md-4">
            <select name="search_status" class="form-select">
                <option value="">All Statuses</option>
                <?php
                $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
                foreach ($statuses as $status) {
                    $selected = ($searchStatus === $status) ? 'selected' : '';
                    echo "<option value=\"$status\" $selected>" . ucfirst($status) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-4 d-flex">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="manage_order.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="table-wrapper">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Email</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['order_id']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['product_id']) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td>$<?= htmlspecialchars($row['total_amount']) ?></td>
                        <td><?= htmlspecialchars($row['order_date']) ?></td>
                        <td>
                            <span class="badge 
                                <?= match ($row['status']) {
                                    'pending' => 'bg-warning',
                                    'processing' => 'bg-primary',
                                    'shipped' => 'bg-info',
                                    'delivered' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary',
                                } ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="view_order.php?order_id=<?= $row['order_id'] ?>" class="btn btn-sm btn-outline-dark">View</a>
                            <a href="edit_order.php?order_id=<?= $row['order_id'] ?>" class="btn btn-sm btn-edit">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">No orders found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
