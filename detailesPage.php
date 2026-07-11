<?php
session_start();
$loggedIn = isset($_SESSION['username']);
$username = $loggedIn ? $_SESSION['username'] : null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Elegant Furniture - Premium furniture store offering stylish chairs, beds, sofas, and carpets. Transform your living space with our luxury collection." />
  <meta name="keywords" content="furniture, elegant furniture, chairs, beds, sofas, carpets, luxury furniture" />
  <title>Elegant Furniture | Premium Home Furniture Collection</title>
  <link href="style2.css" rel="stylesheet">
  </link>
  <link href="detailsPage.css" rel="stylesheet">
  </link>
  <link rel="stylesheet" href="products.css">
  <link rel="stylesheet" href="search_Results.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

</head>

<body>
  <!-- <h1>Products Details</h1> -->
  <header>
    <div class="navbar">
      <a href="index.php" class="logo" aria-label="Elegant Furniture Home">
        🪑<span>Elegant</span> Furniture
      </a>

      <form class="search-container" role="search" id="searchForm">
        <input type="search" id="searchInput" placeholder="Search here..." aria-label="Search furniture" minlength="1" />
        <button type="submit" aria-label="Search">
          <i class="fas fa-search" aria-hidden="true"></i>
        </button>
      </form>
      <nav>
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="index.php#category">Categories</a></li>
          <li><a href="index.php#images">Products</a></li>
          <li><a href="aboutUs.php">About</a></li>
          <li><a href="contactUs.php">Contact</a></li>
          <?php if ($loggedIn): ?>
          <li><a href="dashboard.php">
              <i class="fa-solid fa-user"></i>
              <?= htmlspecialchars($username) ?>
            </a></li>
          <?php else: ?>
          <li><a href="login.html"><i class="fa-solid fa-user"></i> Login</a></li>
          <?php endif; ?>


          <li class="cart">
            <a href="cart_onclick.php"><i class="fa-solid fa-bag-shopping"></i></a><span class="cartcount"
              aria-label="Items in cart">0</span>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <!------------------------------ Single product details------------------------------>
  <!-- <div class="small-container single-product">
        <h2 class="title">Product Details</h2>
        <div id="product" class="detail">
            
        </div> -->

  <div id="loading" role="status" aria-live="polite" style="display:none;">Loading product details...</div>
  <div id="error-message" role="alert" style="display:none; color: red;"></div>
  <div id="product-container" class="card" aria-live="polite" aria-atomic="true"></div>

  <!-- foote section start  -->
  <footer>
    <footer>
      <div class="footer-wrapper">
        <div class="footer-column brand">
          <h2>🛋️ Elegant Furniture</h2>
          <p>Creating cozy, modern, and elegant spaces for every home.</p>
          <div class="social-icons">
            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" /></a>
            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram" /></a>
            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="Twitter" /></a>
          </div>
        </div>

        <div class="footer-column">
          <h3>Explore</h3>
          <ul>
            <li><a href="chairpage.php">Chair</a></li>
            <li><a href="bedpage.php">Bed</a></li>
            <li><a href="sofapage.php">Sofa</a></li>
            <li><a href="carpetpage.php">Carpet</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3>Company</h3>
          <ul>
            <li><a href="aboutUs.php">About Us</a></li>
            <li><a href="careers.html">Careers</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3>Get in Touch</h3>
          <p>Email: hello@elegantfurniture.com</p>
          <p>Phone: +91 98765 43210</p>
          <p>Address: Bandra, Mumbai</p>
        </div>
      </div>

      <div class="footer-bottom">
        &copy; 2025 Elegant Furniture | Crafted with ❤️ by Ansh Bhai
      </div>
    </footer>
  </footer>
  </div>
  <!-- footer section end -->

  <script>
    // Find all user icon list items
    const userItems = [...document.querySelectorAll('.nav-links .fa-user')];
  
    if (userItems.length > 1) {
      // Keep the one that has text like "Login" or a username next to it
      const validUserItems = userItems.filter(icon => {
        const parentLink = icon.closest('a');
        return parentLink && parentLink.textContent.trim().length > 5;
      });
  
      // Remove any other icon-containing <li> that's a duplicate
      userItems.forEach(icon => {
        const parentLink = icon.closest('a');
        const parentLI = icon.closest('li');
        const text = parentLink?.textContent.trim();
  
        const isDuplicate = !text || text.length <= 2 || (validUserItems.length > 0 && icon !== validUserItems[0]);
  
        if (isDuplicate && parentLI) {
          parentLI.remove();
        }
      });
    }

  </script>





<script src="items.js"></script>
<script src="script.js"></script>
<script src="search_Results.js"></script>
<script src="detailsPage.js"></script>
<script src="products.js"></script>
<script src="search.js"></script>

</body>

</html>