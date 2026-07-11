<?php
session_start();
$loggedIn = isset($_SESSION['username']);
$username = $loggedIn ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>carpet page</title>
  <link rel="stylesheet" href="style2.css" />
  <link rel="stylesheet" href="products.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>
  <!-- header start  -->
  <header>
    <div class="navbar">
      <a href="index.php" class="logo" aria-label="Elegant Furniture Home">
        🪑<span>Elegant</span> Furniture
      </a>

      <form class="search-container" role="search" id="searchForm">
        <input type="search" id="searchInput" placeholder="Search here..." aria-label="Search furniture"
          minlength="1" />
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
                <i class="fa-solid fa-user"></i> <?= htmlspecialchars($username) ?>
              </a></li>
              <?php else: ?>
            <li><a href="login.html"><i class="fa-solid fa-user"></i> Login</a></li>
          <?php endif; ?>
          <li class="cart">
            <a href="cart_onclick.php"><i class="fa-solid fa-bag-shopping"></i></a><span class="cartcount" aria-label="Items in cart">0</span>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <!-- header end  -->

  <!-- feuture products section start -->
  <section class="feuture-products" id="carpet-items-container">
    <div id="images" class="gallery"></div>
  </section>
  <!-- feuture products section end -->

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
  <!-- footer section end -->
  <script src="items.js"></script>
  <script src="carpet.js"></script>
  <script src="detailsPage.js"></script>
  <script src="search.js"></script>
</body>

</html>