<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html?error=required");
  exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard - ShopNow</title>
  <link rel="stylesheet" href="dashboard.css">
  <style>
    /* Toast styles */
    .toast {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #4BB543; /* Green Success */
      color: white;
      text-align: center;
      border-radius: 8px;
      padding: 16px;
      position: fixed;
      z-index: 9999;
      left: 50%;
      bottom: 30px;
      font-size: 16px;
      transition: all 0.5s ease-in-out;
    }

    .toast.show {
      visibility: visible;
      bottom: 50px;
      opacity: 1;
    }
  </style>
</head>

<body>
  <div class="dashboard">
    <h1 id="greeting">Hello, <?= htmlspecialchars($username) ?> 👋</h1>
    <p>Welcome to your ShopNow Furniture Dashboard.</p>

    <?php
    if (isset($_SESSION['order_id'])) {
        echo "<h2>Thank you for your order!</h2>";
        echo "<p>Your Order ID is: <strong>" . htmlspecialchars($_SESSION['order_id']) . "</strong></p>";
        unset($_SESSION['order_id']);
    }
    ?>

    <div class="nav">
      <a href="index.php">🛋️ Browse Furniture</a>
      <a href="orders.php">📦 Your Orders</a>
      <a href="profile.php">👤 Profile</a>
      <a href="http://localhost/Furniture_Project/admin_panal/admin_login.php">🔧 Admin Panel</a> <!-- Add Admin Panel link here -->
      <a href="logout.php" class="logout">🚪 Logout</a>
    </div>
  </div>

  <!-- Toast Div -->
  <div id="successToast" class="toast">
    🎉 Order placed successfully!
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      console.log("Dashboard loaded");

      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('success') && urlParams.get('success') === '1') {
        const toast = document.getElementById("successToast");
        toast.classList.add("show");

        // Hide the toast after 3 seconds
        setTimeout(() => {
          toast.classList.remove("show");
        }, 3000);
      }
    });
  </script>

</body>

</html>
