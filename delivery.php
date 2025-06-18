<?php
include 'config.php'; // Include the database configuration file
session_start(); // Start the session
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery Service</title>
  <link rel="stylesheet" href="delivery.css">
  
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
          <li><a href="#"><span class="icon">Food Subscriptions</span></a></li>
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

    <!-- Main Content -->

    <div class="container">
        <div class="tracking-section" id="tracking-section">
            <h2>Track Your Order</h2>
            <div class="search-box">
                <input type="text" id="tracking-number" placeholder="Enter your tracking number">
                <button id="track-btn">Track</button>
            </div>
            
            <div class="tracking-results" id="tracking-results">
                <div class="package-details">
                    <div class="detail-group">
                        <div class="detail-label">Tracking Number</div>
                        <div class="detail-value" id="result-tracking-number">PT12345678</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Estimated Delivery</div>
                        <div class="detail-value" id="result-delivery-date">April 24, 2025</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            <span class="status-label status-transit" id="result-status">In Transit</span>
                        </div>
                    </div>
                </div>
                
                <div class="timeline">
                    <div class="timeline-line"></div>
                    <div class="timeline-item">
                        <div class="timeline-point active"></div>
                        <div class="timeline-date">April 21, 2025 - 9:30 AM</div>
                        <div class="timeline-title">Package in transit</div>
                        <div class="timeline-desc">Your package is on its way to the delivery address</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-point active"></div>
                        <div class="timeline-date">April 20, 2025 - 3:45 PM</div>
                        <div class="timeline-title">Arrived at sorting facility</div>
                        <div class="timeline-desc">San Francisco Distribution Center</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-point active"></div>
                        <div class="timeline-date">April 19, 2025 - 10:15 AM</div>
                        <div class="timeline-title">Package picked up</div>
                        <div class="timeline-desc">Carrier has picked up the package</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-point active"></div>
                        <div class="timeline-date">April 18, 2025 - 5:20 PM</div>
                        <div class="timeline-title">Shipping label created</div>
                        <div class="timeline-desc">Sender prepared the package for shipment</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="recent-shipments" id="recent-shipments">
            <h2>Recent Shipments</h2>
            <div class="shipment-card">
                <div class="shipment-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="8" x2="8" y2="8"></line>
                        <line x1="16" y1="12" x2="8" y2="12"></line>
                        <line x1="16" y1="16" x2="8" y2="16"></line>
                    </svg>
                </div>
                <div class="shipment-info">
                    <div class="shipment-id">PT12345678</div>
                    <div class="shipment-title">Package from Amazon</div>
                    <div class="status-label status-transit">In Transit</div>
                </div>
            </div>
            <div class="shipment-card">
                <div class="shipment-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="8" x2="8" y2="8"></line>
                        <line x1="16" y1="12" x2="8" y2="12"></line>
                        <line x1="16" y1="16" x2="8" y2="16"></line>
                    </svg>
                </div>
                <div class="shipment-info">
                    <div class="shipment-id">PT87654321</div>
                    <div class="shipment-title">Electronics from eBay</div>
                    <div class="status-label status-delivered">Delivered</div>
                </div>
            </div>
            <div class="shipment-card">
                <div class="shipment-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="8" x2="8" y2="8"></line>
                        <line x1="16" y1="12" x2="8" y2="12"></line>
                        <line x1="16" y1="16" x2="8" y2="16"></line>
                    </svg>
                </div>
                <div class="shipment-info">
                    <div class="shipment-id">PT23456789</div>
                    <div class="shipment-title">Books from Barnes & Noble</div>
                    <div class="status-label status-pending">Processing</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
 <footer class="footer">
    <div class="footer-container">
        <!-- Customer support column -->
        <div class="footer-column">
            <h3 class="footer-heading">Customer support</h3>
            <ul class="footer-links">
                <li class="footer-link"><a href="#">Track my order</a></li>
                <li class="footer-link"><a href="#">Contact us</a></li>
                <li class="footer-link"><a href="#">Click & Collect and Delivery</a></li>
                <li class="footer-link"><a href="#">Returns</a></li>
                <li class="footer-link"><a href="#">Find a store</a></li>
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
                <li class="footer-link"><a href="#">About Pets at Home</a></li>
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
              <li class="footer-link"><a href="#">Personalised offers & savings</a></li>
            </ul>
            
            <a href=""><button class="join-button">Join now</button></a>
            
            <div class="social-icons">
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
            </div>
        </div>
    </div>
  
    <!-- Pets logo -->
    <div>
        <img src="yummers logo.png" alt="Pets at Home Logo" class="pets-logo">
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



  
<script src="script.js"></script>
<!-- <script src="delivery.js"></script> -->



</body>
</html>