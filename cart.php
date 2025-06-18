<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Initialize cart session
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

$currency = $_COOKIE['currency'] ?? 'GBP';
$symbols = [
    'USD' => '$', 'EUR' => '€', 'GBP' => '£',
    'INR' => '₹', 'JPY' => '¥', 'NGN' => '₦', 'CAD' => 'C$'
];
$symbol = $symbols[$currency] ?? $currency;

// Handle quantity update and removal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['action']) && isset($_POST['product_id'])) {
    $id = $_POST['product_id'];
    $action = $_POST['action'];
    $email = $_SESSION['email'];

    // fetch quantity in database
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_email = ? AND product_id = ?");
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $quantity = $row['quantity'] ?? 0;

    if ($action === 'increase') {
      $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
      if ($quantity > 0) {
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_email = ? AND product_id = ?");
      } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_email, product_id, quantity) VALUES (?, ?, 1)");
      }
    } elseif ($action === 'decrease') {
      if (isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id] > 1) {
        $_SESSION['cart'][$id]--;
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity - 1 WHERE user_email = ? AND product_id = ?");
      }
    } elseif ($action === 'remove') {
      unset($_SESSION['cart'][$id]);
      $stmt = $conn->prepare("DELETE FROM cart WHERE user_email = ? AND product_id = ?");
    }

    if (isset($stmt)) {
      $stmt->bind_param("si", $email, $id);
      $stmt->execute();
    }
  }
  // Redirect to the same page to prevent form resubmission
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

$cart = $_SESSION['cart'];
$total = 0;
?>
  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
    
</head>
<body>
<!-- Header -->
  <header>
    <div class="logo">
      <a href="home.php"><img src="yummers logo.png" alt=""></a>
    </div>
    
    <div class="currency-selector" >
  <label for="currency">Currency: </label>
  <select id="currency" onchange="convertPrices()">
    <option value="GBP" selected>GBP (£)</option>
    <option value="USD">USD ($)</option>
    <option value="EUR">EUR (€)</option>
    <option value="INR">INR (₹)</option>
    <option value="JPY">JPY (¥)</option>
    <option value="NGN">NGN (N)</option>
    <option value="CAD">CAD (C$)</option>
  </select>
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

      <nav class="sidebarnav">
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
    </div>
  </nav> <br> <br>

    <!--Main Content -->

   <div class="container">
  <h1>Your Shopping Cart</h1>
  
  <?php if (empty($cart)): ?>
    <div class="empty-cart">Your cart is empty. <a href="product.php">Start shopping</a>.</div>
  <?php else: ?>
    <ul class="cart-list">
      <?php foreach ($cart as $product_id => $quantity): ?>
        <?php
        $stmt = $conn->prepare("SELECT product_name, product_price, file FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $subtotal = $product['product_price'] * $quantity;
        $total += $subtotal;
        ?>
        <li class="cart-item">
          <img src="Uploads/<?= htmlspecialchars($product['file']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="cart-thumb">
          <div class="product-info">
            <div class="product-name"><?= htmlspecialchars($product['product_name']) ?></div>
            <div class="price" data-gbp="<?= $product['product_price'] ?>">Price: £<?= number_format($product['product_price'], 2) ?></div>
            
            
            <div class="quantity-controls">
              <form method="post" style="display: inline;">
                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                <input type="hidden" name="action" value="decrease">
                <button type="submit" class="qty-btn">-</button>
              </form>
              
              <span class="quantity"><?= $quantity ?></span>
              
              <form method="post" style="display: inline;">
                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                <input type="hidden" name="action" value="increase">
                <button type="submit" class="qty-btn">+</button>
              </form>
            </div>
            
            <div class="subtotal" data-gbp="<?= $subtotal ?>">Subtotal: £<?= number_format($subtotal, 2) ?></div>
          </div>
          
          <form method="post">
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
            <input type="hidden" name="action" value="remove">
            <button type="submit" class="remove-btn">✖ Remove</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
    
    <div class="cart-summary">
      <p class="total" data-gbp="<?= $total ?>">Total: £<?= number_format($total, 2) ?></p>
      <div class="cart-actions">
        <a href="product.php" class="continue-btn">← Continue Shopping</a>
        <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
      </div>
    </div>
  <?php endif; ?>
</div> <br> <br>

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

    <script src="script.js"></script>
    <script src="cart.js"></script>
    <script src="product.js"></script>
</body>
</html>