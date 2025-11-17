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
  <meta name="description" content="Elegant Furniture - Premium furniture store offering stylish chairs, beds, sofas, and carpets. Transform your living space with our luxury collection." />
  <meta name="keywords" content="furniture, elegant furniture, chairs, beds, sofas, carpets, luxury furniture" />
  <title>Elegant Furniture | Premium Home Furniture Collection</title>
</head>
<link rel="stylesheet" href="style2.css" />
<link rel="stylesheet" href="products.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;500&display=swap" rel="stylesheet">


<body>
  <!-- header start  -->
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
          <li><a href="#category">Categories</a></li>
          <li><a href="#images">Products</a></li>
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

  <!-- hero section start  -->
  <div class="hero-slider">
    <div
      class="slide active"
      style="background-image: url(./Images/slide4.jpg)">
      <div class="overlay">
        <div>
          <h1>Stylish Wooden Furniture</h1>
          <p>Upgrade your living space with modern comfort.</p>
        </div>
      </div>
    </div>

    <div class="slide" style="background-image: url('./Images/slide5.jpg')">
      <div class="overlay">
        <div>
          <h1>Elegant Sofa Sets</h1>
          <p>Luxury and style in every corner of your home.</p>
        </div>
      </div>
    </div>

    <div
      class="slide"
      style="background-image: url('./Images/spacejoy-.jpg')">
      <div class="overlay">
        <div>
          <h1>Modern Bedroom Designs</h1>
          <p>Where relaxation meets style.</p>
        </div>
      </div>
    </div>

    <!-- <div
      class="slide"
      style="background-image: url('./Images/slider.png')">
      <div class="overlay">
        <div>
          <h1>Modern Bedroom Designs</h1>
          <p>Where relaxation meets style.</p>
        </div>
      </div>
    </div> -->



    <!-- Navigation -->
    <a class="prev" onclick="changeSlide(-1)">❮</a>
    <a class="next" onclick="changeSlide(1)">❯</a>
  </div>
  <!-- hero section end -->

  <!-- category section start  -->
  <section class="category-section" id="category">
    <h2>Shop by Category</h2>
    <div class="category-grid">
      <a href="chairpage.php">
        <div class="category">
          <i class="fas fa-chair"></i>
          <h3>Chair</h3>
        </div>
      </a>
      <a href="bedpage.php">
        <div class="category">
          <i class="fas fa-bed"></i>
          <h3>Bed</h3>
        </div>
      </a>

      <a href="sofapage.php">
        <div class="category">
          <i class="fas fa-couch"></i>
          <h3>Sofa</h3>
        </div>
      </a>

      <a href="carpetpage.php">
        <div class="category">
          <i class="fas fa-rug"></i>
          <h3>Carpet</h3>
        </div>
      </a>
    </div>
  </section>
  <!-- category section end  -->
  <!-- feuture products section start -->
  <h2 class="section-title">🛋️ Our Top Products</h2>
  <div id="images" class="gallery"></div>

  <!-- feuture products section end -->

  <!-- banner section start-->
  <div class="banner">
    <div class="banner-content">
      <h1>Furniture That Speaks Style</h1>
      <p>
        Discover timeless furniture pieces that bring warmth, elegance, and
        comfort to your home. Handcrafted with love and designed for modern
        living.
      </p>
    </div>
  </div>
  <!-- banner section end -->

  <!-- foote section start  -->
  <footer>
    <footer>
      <div class="footer-wrapper">
        <div class="footer-column brand">
          <h2>🛋️ Elegant Furniture</h2>
          <p>Creating cozy, modern, and elegant spaces for every home.</p>
          <div class="social-icons">
            <a href="#"><img
                src="https://cdn-icons-png.flaticon.com/512/733/733547.png"
                alt="Facebook" /></a>
            <a href="#"><img
                src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png"
                alt="Instagram" /></a>
            <a href="#"><img
                src="https://cdn-icons-png.flaticon.com/512/733/733579.png"
                alt="Twitter" /></a>
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

  <script>
    let lastScrollTop = 0;
    const searchContainer = document.querySelector('.search-container');
    const nav = document.querySelector('nav');

    window.addEventListener('scroll', function() {
      const currentScroll = window.scrollY;

      // Sticky nav behavior
      if (currentScroll > 50) {
        nav.classList.add('scrolled');
      } else {
        nav.classList.remove('scrolled');
      }

      // Hide search container when scrolling down
      if (currentScroll > lastScrollTop) {
        // Scrolling down
        searchContainer.classList.add('hidden');
      } else {
        // Scrolling up
        searchContainer.classList.remove('hidden');
      }

      lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // For Mobile or negative scrolling
    });
  </script>



  <script src="items.js"></script>
  <script src="script.js"></script>
  <script src="detailsPage.js"></script>
  <script src="carpet.js"></script>
  <script src="products.js"></script>
  <script src="search.js"></script>
</body>

</html> 