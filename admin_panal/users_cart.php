<?php
include 'C:\xampp\htdocs\Furniture_Project\db_connection.php';

// Handle delete
if (isset($_POST['delete_product_id']) && isset($_POST['table_name'])) {
    $productId = intval($_POST['delete_product_id']);
    $tableName = mysqli_real_escape_string($conn, $_POST['table_name']);

    mysqli_query($conn, "DELETE FROM `$tableName` WHERE product_id = $productId");
    echo "<script>alert('Product deleted successfully!'); window.location.href='users_cart.php';</script>";
    exit();
}

// Get all cart tables
$cartTablesQuery = mysqli_query($conn, "SHOW TABLES LIKE 'cart_%'");
$cartTables = [];

while ($row = mysqli_fetch_row($cartTablesQuery)) {
    $cartTables[] = $row[0];
}
?>



<?php
$cartTablesCount = count($cartTables); // Already fetched all tables above
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Users Cart Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body class="bg-light">

    <div class="container py-5">
        <h1>🛒 Users Cart Items</h1>
        <p class="text-muted mb-4">Total User Carts: <strong><?= $cartTablesCount ?></strong></p>


        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">Back</a>
        </div>

        <?php if (!empty($cartTables)) { ?>
            <?php foreach ($cartTables as $table) { ?>
                <div class="card mb-4 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
                        <h5 class="mb-0"><?= htmlspecialchars($table) ?></h5>
                        <input type="text" class="form-control form-control-sm w-25 search-box" placeholder="Search...">
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-hover bg-white mb-0 cart-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cartItemsQuery = mysqli_query($conn, "
                                SELECT c.*, p.name, p.image_path 
                                FROM `$table` c 
                                JOIN products p ON c.product_id = p.id
                            ");

                                $grandTotal = 0;
                                while ($item = mysqli_fetch_assoc($cartItemsQuery)) {
                                    $grandTotal += $item['total_price'];
                                ?>
                                    <tr>
                                        <td><?= $item['product_id'] ?></td>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td>₹<?= number_format($item['total_price'], 2) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>₹<?= number_format($item['total_price'], 2) ?></td>
                                        <td><img src="<?= htmlspecialchars($item['image_path']) ?>" width="60" height="60" alt="Product"></td>
                                        <td>
                                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                <input type="hidden" name="delete_product_id" value="<?= $item['product_id'] ?>">
                                                <input type="hidden" name="table_name" value="<?= $table ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary">
                                    <th colspan="4" class="text-end">Grand Total:</th>
                                    <th colspan="3">₹<?= number_format($grandTotal, 2) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="card-footer bg-light text-end">
                        <form method="post" action="download_cart.php" target="_blank" class="d-inline">
                            <input type="hidden" name="table_name" value="<?= $table ?>">
                            <button type="submit" class="btn btn-success btn-sm">Download CSV</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-info">No user carts available.</div>
        <?php } ?>
    </div>

    <script>
        // Search filter inside each cart
        $(document).ready(function() {
            $('.search-box').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $(this).closest('.card').find('.cart-table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

</body>

</html>