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
  <title>Search Results</title>
  <link rel="stylesheet" href="style2.css" />
  <link rel="stylesheet" href="products.css" />
  <link rel="stylesheet" href="search_Results.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

</head>

<body>
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
          <li><a href="/Furniture_Project/index.php#category">Categories</a></li>
          <li><a href="/Furniture_Project/index.php#images">Products</a></li>
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

  <main role="main">
    <section id="results" class="gallery" aria-live="polite" aria-relevant="additions"></section>
    <p id="noResultsMessage" class="visually-hidden" aria-live="polite">No results found.</p>
  </main>

  <script src="search.js"></script>
  <script src="search_Results.js"></script>
  <script src="detailsPage.js"></script>
</body>

</html>