<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us | Furniture Store</title>
  <link rel="stylesheet" href="style2.css" />
  <link rel="stylesheet" href="products.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

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
          <li><a href="index.php#category">Categories</a></li>
          <li><a href="index.php#images">Products</a></li>
          <li><a href="aboutUs.php">About</a></li>
          <li><a href="contactUs.php">Contact</a></li>
          <?php if ($username): ?>
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
  <div class="about-container">
    <h1 style="text-align: center; margin-bottom: 40px">Contact Us</h1>
    <div class="contact-section">
      <div class="contact-info">
        <h2>Get in Touch</h2>
        <div class="info-item">
          <strong>Address:</strong>
          123 Furniture Street, Interior City, India
        </div>
        <div class="info-item">
          <strong>Phone:</strong>
          +91 9876543210
        </div>
        <div class="info-item">
          <strong>Email:</strong>
          contact@furnishop.com
        </div>
        <div class="info-item">
          <strong>Working Hours:</strong>
          Mon - Sat: 9:00 AM - 7:00 PM
        </div>
      </div>

      <div class="contact-form">
        <h2>Send a Message</h2>
        <form action="send_message.php" method="post">
          <input type="text" name="your_name" placeholder="Your Name" value="<?= htmlspecialchars($username) ?>" required />
          <input type="email" name="email" placeholder="Your Email" value="<?= htmlspecialchars($email) ?>" required />
          <textarea name="message" placeholder="Your Message" required></textarea>
          <button type="submit">Send Message</button>
        </form>
      </div>


    </div>
  </div>

  <!-- Google Map -->
  <div class="map-container">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.690759003062!2d90.40714317435633!3d23.79468548650261!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7c7bda8d3db%3A0xa3793895a647f8f5!2sFurniture%20Shop!5e0!3m2!1sen!2sin!4v1712903163899!5m2!1sen!2sin"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
  </div>
  <!-- foote section start  -->

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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    <?php if (isset($_GET['success'])): ?>
      Swal.fire({
        icon: 'success',
        title: 'Message Sent!',
        text: 'Thank you for contacting us!',
        confirmButtonText: 'OK'
      });
    <?php endif; ?>
  </script>


  <!-- footer section end -->
  <script src="search.js"></script>
  <script src="detailsPage.js"></script>

</body>

</html>