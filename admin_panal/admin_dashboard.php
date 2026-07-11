<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}
include __DIR__ . '/../db_connection.php';


// Count total cart items across all user cart tables
// Count total cart items across all user cart tables
$cartTablesQuery = mysqli_query($conn, "SHOW TABLES LIKE 'cart_%'");
$cartTables = mysqli_num_rows($cartTablesQuery);





// Counts
$productCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `products`"))['count'];
$orderCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `orders`"))['count'];
$userCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `users`"))['count'];
$job_applicationsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `job_applications`"))['count'];
$contact_messagesCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `contact_messages`"))['count'];


// Monthly orders for chart
$monthlyOrders = [];
for ($i = 1; $i <= 12; $i++) {
    $result = mysqli_fetch_assoc(mysqli_query(
        $conn,
        "SELECT COUNT(*) AS count FROM `orders` WHERE MONTH(order_date) = $i"

    ));
    $monthlyOrders[] = $result['count'];
}

// Recent 5 orders
// Recent 5 orders
$recentOrdersQuery = mysqli_query($conn, "
    SELECT orders.order_id AS order_id, orders.order_date, orders.product_id, products.name AS product_name, orders.status
    FROM orders
    JOIN products ON orders.product_id = products.id
    ORDER BY orders.order_date DESC
    LIMIT 5
");


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 2rem;
            position: fixed;
            width: 250px;
            color: white;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }

        .sidebar i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .card-stats {
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .text-muted{
            color: #6c757d !important;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4 class="text-center mb-4">🛋️ Admin Panel</h4>
            <a href="manage_products.php"><i class="bi bi-box-seam"></i> Manage Products</a>
            <a href="manage_orders.php"><i class="bi bi-cart-check"></i> Manage Orders</a>
            <a href="manage_users.php"><i class="bi bi-people"></i> Manage Users</a>
            <a href="manage_job_applications.php"><i class="bi bi-file-earmark-person"></i> Job Applications</a>
            <a href="users_cart.php"><i class="bi bi-basket"></i> Users Cart Items</a>
            <a href="manage_feedback.php"><i class="bi bi-chat-left-text"></i> Manage Feedback</a>
            <a href="sales_report.php"><i class="bi bi-bar-chart-line"></i> Sales Report</a>
            <a href="admin_logout.php" class="">Logout</a>

        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1 class="mb-4">Dashboard Overview</h1>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card card-stats p-3">
                        <h5><i class="bi bi-box-seam text-primary"></i> Total Products</h5>
                        <p class="fs-4"><?= $productCount ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats p-3">
                        <h5><i class="bi bi-cart-check text-success"></i> Orders</h5>
                        <p class="fs-4"><?= $orderCount ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats p-3">
                        <h5><i class="bi bi-people text-warning"></i> Users</h5>
                        <p class="fs-4"><?= $userCount ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats p-3">
                        <h5><i class="bi bi-file-earmark-person text-primary"></i> Job-Applications</h5>
                        <p class="fs-4"><?= $job_applicationsCount ?></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-stats p-3">
                        <h5><i class="bi bi-basket text-danger"></i> Users Cart Items</h5>
                        <p class="fs-4"><?= $cartTables ?></p>

                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card card-stats p-3">
                        <h5><i class="bi bi-basket text-info"></i> Manage Feedback</h5>
                        <p class="fs-4"><?= $contact_messagesCount?></p>

                    </div>
                </div>


            </div>

            <!-- Charts and Activity -->
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card p-3">
                        <h5 class="mb-3">📊 Monthly Orders</h5>
                        <canvas id="ordersChart" height="150"></canvas>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card p-3">
                        <h5 class="mb-3">🧾 Recent Orders</h5>
                        <ul class="list-group">
                            <?php while ($order = mysqli_fetch_assoc($recentOrdersQuery)) { ?>
                                <?php
                                $statusIcon = '';
                                $tooltip = '';

                                if ($order['status'] === 'shipped') {
                                    $statusIcon = 'bi-truck';
                                    $tooltip = 'Order Shipped';
                                } elseif ($order['status'] === 'pending') {
                                    $statusIcon = 'bi-clock-history';
                                    $tooltip = 'Order Pending';
                                } elseif ($order['status'] === 'cancelled') {
                                    $statusIcon = 'bi-x-circle';
                                    $tooltip = 'Order Cancelled';
                                }
                                ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Order #<?= $order['order_id'] ?></strong><br>
                                        <small class="text-muted">ProductNAME: <?= $order['product_name'] ?> (OrderID: <?= $order['order_id'] ?>)</small>
                                    </div>
                                    <span class="text-muted">
                                        <i class="bi <?= $statusIcon ?> me-1 text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $tooltip ?>"></i>
                                        <?= date('M d, Y', strtotime($order['order_date'])) ?>
                                    </span>


                                </li>
                            <?php } ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Script -->
    <script>
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Orders',
                    data: <?= json_encode($monthlyOrders) ?>,
                    backgroundColor: 'rgba(13, 110, 253, 0.7)',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>


</body>

</html>