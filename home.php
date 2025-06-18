<?php
include 'config.php'; // DB connection

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$search_results = [];
$search_query = '';

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_query = trim($_GET['search']);
    $search_query_escaped = mysqli_real_escape_string($conn, $search_query);

    $sql = "
        SELECT * FROM products 
        WHERE product_name LIKE '%$search_query_escaped%' 
        OR product_category LIKE '%$search_query_escaped%'
    ";

    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $search_results[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Yummers</title>
  <link rel="stylesheet" href="home.css" />
  <script src="script.js"></script>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="logo">
      <a href="home.php"><img src="yummers logo.png" alt="Yummers Logo" /></a>
    </div>

    <div class="search-container">
      <form method="GET" action="home.php" class="search-bar-form">
        <div class="search-bar">
          <span class="search-icon">🔍</span>
          <input
            type="text"
            name="search"
            placeholder="Search Yummers"
            value="<?= htmlspecialchars($search_query) ?>"
          />
        </div>
      </form>
    </div>

    <div class="user-actions">
      <a href="profile.php" class="user-action">
        <span class="icon">👤</span>
        <p>Welcome <span><?= htmlspecialchars($_SESSION['first_name']) ?></span></p>
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
  </div>
  <br />

  <!-- Hero Section -->
  <section class="hero">
    <div class="slider-container">
      <div class="slider">
        <div class="slide">
          <img src="yummershome1.jpg" alt="Slide 1" />
        </div>
      </div>
    </div>

    <div class="hero-content">
      <div class="easy-repeat">
        <span class="repeat-icon">↻</span>
        <span>Easy Meals</span>
      </div>
      <h2 class="hero-title">Save up to 10% on every order.</h2>
      <p class="hero-subtitle">
        Subscribe and save 10% when you Click & Collect or 5% on deliveries.
      </p>
      <button class="shop-now-btn">Shop now</button>
    </div>
  </section>

    <!-- Search Results Section -->
  <?php if (!empty($search_query)): ?>
    <section class="search-results">
      <h2>Search Results for "<?= htmlspecialchars($search_query) ?>"</h2>

      <?php if (!empty($search_results)): ?>
        <div class="featured-items">
          <?php foreach ($search_results as $product): ?>
            <div class="featured-item">
              <div class="featured-image">
                <img src="Uploads/<?= htmlspecialchars($product['file']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" />

                <a href="product.php ?id=<?= $product['product_id'] ?>" class="shop-btn">View Product</a>
              </div>
              <h4><?= htmlspecialchars($product['product_name']) ?></h4>
              <p><?= htmlspecialchars($product['product_category']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p>No results found.</p>
      <?php endif; ?>
    </section>
  <?php endif; ?>

  <!-- Shop For Section -->
  <section class="shop-section">
    <div class="section-header">
      <h2 class="section-title">Shop for</h2>
      <div class="category-tabs">
        <button class="tab" onclick="showForm('all-pets')">All pet types</button>
        <button class="tab" onclick="showForm('my-pets')">My pets</button>
      </div>
    </div>

    <div class="pet-categories active" id="all-pets">
      <a href="product.php" class="pet-category">
        <div class="category-image">
          <img src="dog.jpg" alt="Dog" />
        </div>
        <span class="category-name">Dog</span>
      </a>
      <a href="product.php" class="pet-category">
        <div class="category-image">
          <img src="cat.jpg" alt="Cat" />
        </div>
        <span class="category-name">Cat</span>
      </a>
      <a href="product.php" class="pet-category">
        <div class="category-image">
          <img src="hamsters.jpg" alt="Small Animal" />
        </div>
        <span class="category-name">Small Animal</span>
      </a>
      <a href="product.php" class="pet-category">
        <div class="category-image">
          <img src="fish.jpg" alt="Fish" />
        </div>
        <span class="category-name">Fish</span>
      </a>
      <a href="product.php" class="pet-category">
        <div class="category-image">
          <img src="reptile.jpg" alt="Reptile" />
        </div>
        <span class="category-name">Reptile</span>
      </a>
      <a href="product.php" class="pet-category">
        <div class="category-image">
          <img src="bird.jpg" alt="Bird & Wildlife" />
        </div>
        <span class="category-name">Bird & Wildlife</span>
      </a>
    </div>

    <div class="pet-categories" id="my-pets">
      <div class="sign-in-section">
        <h3 class="sign-in-title">
          <a href="#" class="link">Sign in</a> for a personalised experience.
        </h3>
        <p class="sign-in-subtitle">
          Don't have an account? <a href="#" class="link">Join today</a>
        </p>
        <button class="learn-button">Learn more</button>
      </div>
    </div>
  </section>


  
  <!-- New and Featured Section -->
  <section class="featured-section">
    <h2 class="featured-title">New and featured</h2>
    
    <div class="featured-items">
      <div class="featured-item">
        <span class="featured-label">New</span>
        <div class="featured-image">
         <a href="product.php"><img src="turkey&cran.jpg" alt=""></a>
          <a href="product.php" class="shopsnow-btn">Shop now</a>
        </div>
      </div>
      <div class="featured-item">
        <span class="featured-label">New</span>
        <div class="featured-image">
         <a href="product.php"><img src="cheddarcheese.jpg" alt=""></a>
          <a href="product.php" class="shopsnow-btn">Shop now</a>
        </div>
      </div>
      <div class="featured-item">
        <span class="featured-label">New</span>
        <div class="featured-image">
         <a href="product.php"><img src="chicken&beef.jpg" alt=""></a>
          <a href="product.php" class="shopsnow-btn">Shop now</a>
        </div>
      </div>
      <div class="featured-item">
        <span class="featured-label">New</span>
        <div class="featured-image">
         <a href="product.php"><img src="skin&coat.jpg" alt=""></a>
          <a href="product.php" class="shopsnow-btn">Shop now</a>
        </div>
      </div>
      <div class="featured-item">
        <span class="featured-label">-10%</span>
        <div class="featured-image">
         <a href="product.php"><img src="salmon&lamb.jpg" alt=""></a>
          <a href="product.php" class="shopsnow-btn">Shop now</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Yummers club Section -->
  <section class="pets-club">
    <div class="pets-club-left">
        <div class="club-logo">
            Yummers <div class="club-badge">Club</div>
        </div>
        <h2 class="club-title">Sign Up. Start Saving.</h2>
        <p class="club-description">Don't miss out, join Pets Club now to unlock tailored offers just for you.</p>
        <div class="club-buttons">
            <a href="mypets.php" class="club-primary-btn">Sign up for tailored offers</a>
            <a href="product.php" class="club-secondary-btn">View top offers</a>
        </div>
        <a href="support.php" class="learn-more">Learn more</a>
    </div>
    <div class="curved-shape"></div>
    <div class="pets-club-right">
        <div class="offer-cards">
            <div class="offer-card">
                <div class="offer-label">Offer</div>
                <img src="Gemini_Generated_Image_jypchvjypchvjypc.jpeg" alt="Dog food" class="offer-image">
                <h4 class="offer-title">Save 30% on selected Royal Canin Puppy & Kitten Food</h4>
                <p class="offer-validity">Valid until 22 May 2025</p>
                <a href="product.php" class="shop-btn">Shop now</a>
            </div>
            <div class="offer-card">
                <div class="offer-label">Offer</div>
                <img src="Gemini_Generated_Image_roz3dfroz3dfroz3.jpeg" alt="Cat food" class="offer-image">
                <h4 class="offer-title">Now £4 on Cat food</h4>
                <p class="offer-validity">Valid until 22</p>
                <a href="product.php" class="shop-btn">Shop now</a>
            </div>
        </div>
        
    </div>
</section>

<!-- Best Sellers -->
<section class="featured-section">
  <h2 class="featured-title">Best Sellers</h2>
  
  <div class="featured-items">
    <div class="featured-item">
      <span class="featured-label">New</span>
      <div class="featured-image">
        <a href="product.php"><img src="digestive.jpg" alt=""></a>
        <a href="product.php" class="shopsnow-btn">Shop now</a>
      </div>
    </div>
    <div class="featured-item">
      <span class="featured-label">New</span>
      <div class="featured-image">
        <a href="product.php"><img src="sal&sweetpotato.jpg" alt=""></a>
        <a href="product.php" class="shopsnow-btn">Shop now</a>
      </div>
    </div>
    <div class="featured-item">
      <span class="featured-label">New</span>
      <div class="featured-image">
        <a href="product.php"><img src="beefliver.jpg" alt=""></a>
        <a href="product.php" class="shopsnow-btn">Shop now</a>
      </div>
    </div>
    <div class="featured-item">
      <span class="featured-label">New</span>
      <div class="featured-image">
        <a href="product.php"><img src="chicken.jpg" alt=""></a>
        <a href="product.php" class="shopsnow-btn">Shop now</a>
      </div>
    </div>
    <div class="featured-item">
      <span class="featured-label">-10%</span>
      <div class="featured-image">
        <a href="product.php"><img src="heart.jpg" alt=""></a>
        <a href="product.php" class="shopsnow-btn">Shop now</a>
      </div>
    </div>
  </div>
</section>

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
</html>