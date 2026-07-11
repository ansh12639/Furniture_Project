<?php
include __DIR__ . '/../db_connection.php';

// SQL to get monthly sales summary
$sql = "SELECT 
            DATE_FORMAT(order_date, '%Y-%m') AS month,
            COUNT(*) AS total_orders,
            SUM(total_amount) AS total_sales
        FROM `orders`
        WHERE status NOT IN ('cancelled') -- Exclude cancelled
        GROUP BY month
        ORDER BY month DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Monthly Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Monthly Sales Report</h1>
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Month</th>
                    <th>Total Orders</th>
                    <th>Total Sales (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['month']; ?></td>
                            <td><?= $row['total_orders']; ?></td>
                            <td><?= number_format($row['total_sales'], 2); ?></td>
                        </tr>
                <?php }
                } else { ?>
                    <tr>
                        <td colspan="3" class="text-center">No sales data available.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>

</html>
