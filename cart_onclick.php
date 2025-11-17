<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

require_once 'db_connection.php';

$username = htmlspecialchars($_SESSION['username']);
$tableName = "cart_" . $username;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $productId = $_POST['product_id'] ?? null;

    if (!$productId || !in_array($action, ['remove', 'payment'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM `$tableName` WHERE `product_id` = ?");
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        $responseMessage = ($action === 'payment') ? 'Payment successful!' : 'Item removed from cart';
        echo json_encode(['status' => 'success', 'message' => $responseMessage]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database operation failed']);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Elegant Furniture - Premium furniture store offering stylish chairs, beds, sofas, and carpets." />
  <meta name="keywords" content="furniture, elegant furniture, chairs, beds, sofas, carpets" />
  <title>Cart | Elegant Furniture</title>

  <link rel="stylesheet" href="style2.css" />
  <link rel="stylesheet" href="products.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
      margin: 0;
      color: #333;
    }

    #cart-container {
      max-width: 1100px;
      margin: 30px auto;
      padding: 20px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      overflow: hidden;
      border-radius: 12px;
    }

    th,
    td {
      padding: 18px;
      text-align: center;
      vertical-align: middle;
      font-size: 1rem;
    }

    th {
      background-color: #007bff;
      color: white;
      font-size: 1.05rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      border-bottom: 2px solid #dee2e6;
    }

    td {
      background: #fefefe;
      border-bottom: 1px solid #f1f1f1;
    }

    img {
      width: 75px;
      height: 75px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .action-buttons button {
      margin: 4px;
      padding: 10px 18px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    .proceed-btn {
      background: #28a745;
      color: white;
    }

    .proceed-btn:hover {
      background: #218838;
      transform: translateY(-2px);
    }

    .remove-btn {
      background: #dc3545;
      color: white;
    }

    .remove-btn:hover {
      background: #c82333;
      transform: translateY(-2px);
    }

    .empty-message {
      text-align: center;
      font-size: 1.3rem;
      color: #6c757d;
      margin: 60px 0;
    }

    #total-price {
      margin-top: 20px;
      text-align: right;
      font-size: 1.6rem;
      font-weight: bold;
      color: #343a40;
    }

    #decrease,
    #increase {
      background: #007bff;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
    }

    #decrease:hover,
    #increase:hover {
      background: #0056b3;
    }
  </style>
</head>

<body>

  <!-- Header Section -->
  <header>
    <div class="navbar">
      <a href="index.php" class="logo" aria-label="Elegant Furniture Home">
        🪑<span>Elegant</span> Furniture
      </a>

      <form class="search-container" id="searchForm" role="search">
        <input type="search" id="searchInput" placeholder="Search here..." aria-label="Search furniture" minlength="1" />
        <button type="submit" aria-label="Search">
          <i class="fas fa-search"></i>
        </button>
      </form>

      <nav>
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="/Furniture_Project/index.php#category">Categories</a></li>
          <li><a href="/Furniture_Project/index.php#images">Products</a></li>
          <li><a href="aboutUs.php">About</a></li>
          <li><a href="contactUs.php">Contact</a></li>
          <li><a href="dashboard.php"><i class="fa-solid fa-user"></i> <?= $username ?></a></li>
          <li class="cart">
            <a href="cart_onclick.php"><i class="fa-solid fa-bag-shopping"></i></a>
            <span class="cartcount" aria-label="Items in cart">0</span>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Cart Container -->
  <main>
    <div id="cart-container"></div>
    <div id="total-price"></div>
  </main>

  <!-- JavaScript Section -->
  <script>
    async function loadCart() {
      try {
        const response = await fetch('get_cart_items.php');
        const data = await response.json();
        const container = document.getElementById('cart-container');
        const totalPriceDiv = document.getElementById('total-price');

        container.innerHTML = '';
        totalPriceDiv.innerHTML = '';

        let grandTotal = 0;
        let table = `<table>
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>`;

        if (data.success && data.cart.length > 0) {
          data.cart.reverse().forEach(item => {
            grandTotal += parseFloat(item.total_price);
            table += `
<tr id="product-${item.product_id}">
  <td><img src="${item.image_path}" alt="${item.name}" /></td>
  <td>${item.name}</td>
  <td>Rs ${item.total_price}</td>
  <td>
  <button id="decrease" onclick="decreaseQuantity(${item.product_id})">-</button>
  <input 
    type="text" 
    id="quantity-${item.product_id}" 
    value="${item.quantity}" 
    readonly 
    style="width: 50px; text-align: center; font-size: 16px; margin: 0 8px;" 
  />
  <button id="increase" onclick="increaseQuantity(${item.product_id}, ${item.stock})">+</button>
  <div id="error-${item.product_id}" style="color: red; font-size: 12px; margin-top: 5px;"></div>
</td>

  <td>Rs <span id="total-${item.product_id}">${item.total_price}</span></td>
  <td class="action-buttons">
    <button class="proceed-btn" onclick="proceedToPayment(${item.product_id})">Proceed to Payment</button>
    <button class="remove-btn" onclick="removeFromCart(${item.product_id})">Remove</button>
  </td>
</tr>`;

          });
        } else {
          table += `
        <tr>
          <td colspan="6" style="text-align: center; padding: 50px 0; font-size: 20px; font-weight: bold;">
            Your cart is empty!
          </td>
        </tr>`;
        }

        table += `
      <tr>
        <td colspan="6" style="text-align: right; font-size: 20px; font-weight: bold;">
          Grand Total: Rs <span id="grand-total">${grandTotal.toFixed(2)}</span>
        </td>
      </tr>`;

        table += `</tbody></table>`;

        container.innerHTML = table;
        totalPriceDiv.innerHTML = '';

        updateCartCount();

      } catch (error) {
        console.error('Error loading cart:', error);
      }
    }



    async function removeFromCart(productId) {
      try {
        const response = await fetch('cart_onclick.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `action=remove&product_id=${productId}`
        });
        const result = await response.json();
        alert(result.message);
        loadCart();
      } catch (error) {
        console.error('Error removing item:', error);
      }
    }

    function proceedToPayment(productId) {
      fetch('get_cart_items.php')
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const selectedProduct = data.cart.find(item => item.product_id == productId);

            if (selectedProduct) {
              const checkoutUrl = `checkout.html?product_id=${selectedProduct.product_id}&quantity=${selectedProduct.quantity}&price=${selectedProduct.price}`;
              window.location.href = checkoutUrl;
            } else {
              console.error('Product not found in cart');
            }
          }
        })
        .catch(error => {
          console.error('Error fetching cart:', error);
        });
    }

    // Load cart on page load
    document.addEventListener('DOMContentLoaded', loadCart);
    document.addEventListener("DOMContentLoaded", updateCartCount);


    function updateCartCount() {
      fetch('get_cart_count.php')
        .then(response => response.json())
        .then(data => {
          const cartCountElement = document.querySelector('.cartcount');
          if (cartCountElement) {
            cartCountElement.textContent = data.count;
          }
        })
        .catch(error => {
          console.error('Error fetching cart count:', error);
        });
    }

    async function increaseQuantity(productId, stock) {
      const quantityElement = document.getElementById(`quantity-${productId}`);
      const errorElement = document.getElementById(`error-${productId}`);
      let currentQuantity = parseInt(quantityElement.textContent);

      if (currentQuantity < stock) {
        currentQuantity++;
        quantityElement.textContent = currentQuantity;
        errorElement.textContent = "";

        await updateQuantityInDatabase(productId, currentQuantity);
      } else {
        errorElement.textContent = "Insufficient stock";
      }
    }

    async function decreaseQuantity(productId) {
      const quantityElement = document.getElementById(`quantity-${productId}`);
      const errorElement = document.getElementById(`error-${productId}`);
      let currentQuantity = parseInt(quantityElement.textContent);

      if (currentQuantity > 1) {
        currentQuantity--;
        quantityElement.textContent = currentQuantity;
        errorElement.textContent = "";

        await updateQuantityInDatabase(productId, currentQuantity);
      }
    }

    async function updateQuantityInDatabase(productId, newQuantity) {
      try {
        const response = await fetch('update_cart_quantity.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `product_id=${productId}&quantity=${newQuantity}`
        });

        const result = await response.json();
        if (result.success) {
          // Update the total price displayed for this product
          document.getElementById(`total-${productId}`).textContent = (result.new_total).toFixed(2);

          // Update grand total
          loadCart();
        } else {
          alert(result.message || 'Failed to update quantity');
        }
      } catch (error) {
        console.error('Error updating quantity:', error);
      }
    }
  </script>

</body>

</html>