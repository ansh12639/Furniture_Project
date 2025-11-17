<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.html?error=required");
  exit();
}

$username = $_SESSION['username'];
$tableName = 'orders_' . preg_replace('/[^a-zA-Z0-9_]/', '', $username);

include "db_connection.php";

$orders = [];

try {
  // Check if user's order table exists
  $tableCheck = $conn->query("SHOW TABLES LIKE '$tableName'");
  if ($tableCheck->num_rows > 0) {
    $result = $conn->query("
    SELECT o.*, p.name, p.info AS info, p.price, p.image_path AS image_url 
    FROM `$tableName` o 
    LEFT JOIN products p ON o.product_id = p.id 
    ORDER BY o.order_date DESC
  ");
  

    if ($result) {
      $orders = $result->fetch_all(MYSQLI_ASSOC);
    }
  }
} catch (Exception $e) {
  // Log the error later
  error_log("Error fetching orders: " . $e->getMessage());
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Your Orders - Elegant Furniture</title>
  <link rel="stylesheet" href="dashboard.css">
  <style>
    .order-container {
      padding: 20px;
    }

    .order-card {
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      background-color: #fff;
      transition: 0.3s ease;
    }

    .order-card:hover {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .order-card img {
      width: 120px;
      height: auto;
      margin-right: 20px;
      border-radius: 10px;
    }

    .order-details {
      flex: 1;
    }

    .order-details h3 {
      margin: 0 0 10px 0;
    }

    .order-buttons {
      margin-top: 10px;
    }

    .order-buttons button {
      margin-right: 10px;
      padding: 8px 14px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      transition: background-color 0.3s ease;
    }

    .order-buttons button:hover {
      background-color: #0056b3;
    }

    .no-orders {
      text-align: center;
      padding: 50px;
      color: #777;
      font-size: 18px;
    }

    .back-link {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 20px;
      background: #333;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.3s;
    }

    .back-link:hover {
      background: #555;
    }

    @media (max-width: 768px) {
      .order-card {
        flex-direction: column;
        align-items: flex-start;
      }

      .order-card img {
        margin-bottom: 10px;
        width: 100%;
        max-width: 250px;
      }

      .order-buttons button {
        margin-bottom: 10px;
        width: 100%;
      }
    }
  </style>
</head>

<body>

  <div class="dashboard">
    <h1>Your Orders</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'order_cancelled'): ?>
      <p style="color: green; text-align:center;">✅ Order cancelled successfully!</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === 'cancellation_failed'): ?>
      <p style="color: red; text-align:center;">❌ Failed to cancel the order. Please try again.</p>
    <?php endif; ?>


    <div class="order-container">
      <?php if (empty($orders)): ?>
        <div class="no-orders">
          <p>😢 You haven't purchased anything yet.</p>
          <a href="index.php" class="back-link">🛋️ Start Shopping</a>
        </div>
      <?php else: ?>
        <?php foreach ($orders as $order): ?>
          <div class="order-card">
            <img src="<?= htmlspecialchars($order['image_url']) ?>" alt="<?= htmlspecialchars($order['name']) ?>">
            <div class="order-details">
              <h3><?= htmlspecialchars($order['name']) ?></h3>
              <p><strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']) ?></p>
              <p><strong>Info:</strong> <?= htmlspecialchars($order['info']) ?></p>
              <p><strong>Price:</strong> ₹<?= number_format($order['price'], 2) ?></p>
              <p><strong>Quantity:</strong> <?= (int)$order['quantity'] ?></p>
              <p><strong>Ordered On:</strong> <?= htmlspecialchars($order['order_date']) ?></p>

              <div class="order-buttons">
                <button onclick="reorderProduct('<?= htmlspecialchars($order['order_id']) ?>')">🔄 Reorder</button>
                <button onclick="downloadInvoice('<?= htmlspecialchars($order['order_id']) ?>')">📄 Download Invoice</button>
                <button onclick="cancelOrder('<?= htmlspecialchars($order['order_id']) ?>')" style="background-color: #dc3545;">❌ Cancel Order</button>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <a href="dashboard.php" class="back-link">🔙 Back to Dashboard</a>
  </div>

  <script>
    function reorderProduct(orderId) {
      // Later you can send a POST request to server
      alert("Reordering product with Order ID: " + orderId);
    }

    function downloadInvoice(orderId) {
      // Redirect to a dummy invoice download for now
      window.location.href = "download_invoice.php?order_id=" + encodeURIComponent(orderId);
    }

    function cancelOrder(orderId) {
      if (confirm("Are you sure you want to cancel this order?")) {
        // Redirect to cancel_order.php (you'll need to create it)
        window.location.href = "cancel_order.php?order_id=" + encodeURIComponent(orderId);
      }
    }
  </script>

</body>

</html>