<?php
include 'config.php'; // Include the database configuration file
session_start(); // Start the session
if (!isset($_SESSION['email'])) {
    
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Pets</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
<!-- Header -->    
    <header>
        <div class="logo">
          
          <a href="home.php"><img src="yummers logo.png" alt=""></a>
        </div>
        
        <div class="search-container">
          <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Search Yummers">
          </div>
        </div>
        
        <div class="user-actions">
          <a href="profile.php" class="user-action">
            <span class="icon">👤</span>
            <p>Welcome <span><?php echo $_SESSION['first_name'];?></span></p>
          </a>
          <a href="cart.php" class="user-action">
            <span class="icon">🛒</span>
            <span>Basket</span>
          </a>
        </div>
        
      </header>

<!-- Main Navigation -->
  <nav class="main-nav">
    
    <a href="#" class="nav-item">
      <span class="menutoggle" id="menutoggle">🏠Shop</span>
      
    </a>

    <!-- Sidebar Menu -->
     <div class="sidebar" id="sidebar">
      <div class="sidebarheader">
        <h2>Shop Yummers</h2>
        <button class="closebtn" id="closebtn">&times;</button>
      </div>

      <nav class="sidebarnav" >
        <ul>
          <li><a href="home.php"><span class="icon">Home</span></a></li>
          <li><a href="product.php"><span class="icon">Products A-Z</span></a></li>
          <li><a href="delivery.php"><span class="icon">Track Your Delivery</span></a></li>
          <li><a href="support.php"><span class="icon">Chat with us</span></a></li>

        </ul>
      </nav>
      <div class="sidefooter" id="login">
        <a href="logout.php"><span class="icons" id="login">Logout</span></a>

        


      </div>
     </div>

     <!-- Overlay -->
      <div class="overlay" id="overlay"></div>
    
    <a href="mypets.php" class="nav-item">
      <span class="icon">🐾</span>
      <span>My Pets</span>
    </a>
    <a href="product.php" class="nav-item">
      <span class="icon">📅</span>
      <span>Products</span>
    </a>
    <a href="support.php" class="nav-item">
      <span class="icon">💬</span>
      <span>Support</span>
    </a>
    

    <div class="user-actions">
        <div class="theme-switch-wrapper">
          <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox" />
            <div class="slider">
              <div class="slider-icons">
                <span>☀️</span>
                <span>🌙</span>
              </div>
            </div>
          </label>
        </div>
    </nav>

<!-- Promo Banner -->
  <div class="promo-banner">
    <div class="promo-item">
      <span class="promo-text">Get 10% off your first order!</span>
      <a href="mypets.php" class="promo-link">Join Pets Club</a>
    </div>
    <div class="promo-item">
      <span class="free-text">Free</span>
      <a href="product.php" class="promo-link">Click & Collect</a>
      <span class="promo-text">in as little as 1 hour</span>
    </div>
    <div class="promo-item">
      <span class="free-text">Free</span>
      <a href="product.php" class="promo-link">standard delivery</a> 
      <span class="promo-text">over £39</span>
    </div>
  </div> <br>

  <!-- Main Content -->
  <div class="main-content">
    <h1>Unlock your pet's potential</h1>
    <p>Let us get to know you and your pet by becoming part of Pets Club.</p>
    <div class="cta-buttons">
        <a href="#" class="cta-primary">Join Pets Club</a>
        <a href="support.php" class="cta-secondary">Learn more</a>
    </div>
</div>

  
  
  <!-- Footer -->
 <footer class="footer">
  <div class="footer-container">
      <!-- Customer support column -->
      <div class="footer-column">
          <h3 class="footer-heading">Customer support</h3>
          <ul class="footer-links">
              <li class="footer-link"><a href="delivery.php">Track my order</a></li>
              <li class="footer-link"><a href="support.php">Contact us</a></li>
              <li class="footer-link"><a href="support.php">Click & Collect and Delivery</a></li>
              <li class="footer-link"><a href="support.php">Returns</a></li>
              
          </ul>
      </div>

      <!-- About your pets column -->
      <div class="footer-column">
          <h3 class="footer-heading">About your pets</h3>
          <ul class="footer-links">
              <li class="footer-link"><a href="#">Pets Grooming</a></li>
              <li class="footer-link"><a href="#">Pet insurance</a></li>
              <li class="footer-link"><a href="#">Veterinary surgeries</a></li>
              <li class="footer-link"><a href="#">Free kids workshops</a></li>
          </ul>
      </div>

      <!-- About us column -->
      <div class="footer-column">
          <h3 class="footer-heading">About us</h3>
          <ul class="footer-links">
              <li class="footer-link"><a href="#">About Yummers</a></li>
              <li class="footer-link"><a href="#">Careers</a></li>
              <li class="footer-link"><a href="#">Responsibility</a></li>
              <li class="footer-link"><a href="#">Responsible retailing</a></li>
              <li class="footer-link"><a href="#">Responsible pet sourcing</a></li>
          </ul>
      </div>

      <!-- Join our Pets Club column -->
      <div class="footer-column">
          <h3 class="footer-heading">Join our Pets Club</h3>
          <ul class="footer-links">
            <li class="footer-link"><a href="mypets.php">Personalised offers & savings</a></li>
          </ul>
          
          <a href=""><button class="join-button">Join now</button></a>
          
          <!-- <div class="social-icons">
              <a href="#" class="social-icon">
                  <i class="fab fa-instagram"></i>
              </a>
              <a href="#" class="social-icon">
                  <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                  <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                  <i class="fab fa-youtube"></i>
              </a>
          </div> -->
      </div>
  </div>

  <!-- Pets logo -->
  <div>
      <img src="yummers logo.png" alt=" Yummers Logo" class="pets-logo">
  </div>

  <!-- Footer bottom section -->
  <div class="footer-bottom">
      <p>© 2025 Yummers Ltd  All rights reserved.</p>
      
      <div class="footer-legal-links">
          <span class="footer-legal-link"><a href="#">Terms & Conditions</a></span>
          <span class="footer-legal-link"><a href="#">Privacy policy</a></span>
          <span class="footer-legal-link"><a href="#">Cookies</a></span>
          <span class="footer-legal-link"><a href="#">Modern Slavery Statement</a></span>
      </div>
  </div>

  <!-- Back to top button -->
  <div class="back-to-top">
      <a href="#top">↑</a>
  </div>
</footer>
</body>
<script src="script.js"></script>
</html>