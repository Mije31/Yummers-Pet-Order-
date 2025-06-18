<?php
include 'config.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="product.css">
</head>
<body>

<header>
  <div class="logo">
    <a href="home.php"><img src="yummers logo.png" alt=""></a>
  </div>

  <div class="search-container">
    <div class="search-bar">
      <span class="search-icon"></span>
      <input type="text" placeholder="Search Yummers">
    </div>
  </div>

  <div class="user-actions">
    <a href="profile.php" class="user-action">
      <span class="icon">👤</span>
      <p>Welcome <span><?php echo $_SESSION['first_name']; ?></span></p>
    </a>
    <a href="cart.php" class="user-action">
      <span class="icon">🛒</span>
      <span>Basket</span>
    </a>
  </div>

  

</header>

<nav class="main-nav">
  <a href="#" class="nav-item"><span class="menutoggle" id="menutoggle">🏠Shop</span></a>

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
  <div class="overlay" id="overlay"></div>

  <a href="mypets.php" class="nav-item"><span class="icon">🐾</span><span>My Pets</span></a>
  <a href="product.php" class="nav-item"><span class="icon">📅</span><span>Products</span></a>
  <a href="support.php" class="nav-item"><span class="icon">💬</span><span>Support</span></a>
 

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

<div class="container">
  <!-- Filter Sidebar -->
  <form method="GET" action="product.php" class="filters">
    <h2>Filters</h2>

    <!-- Search -->
    <div class="filter-section">
      <h2>Search Products</h2> <br>
      <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </div> <br> <br>

    <!-- Categories -->
    <div class="filter-section">
      <h3>Categories</h3>
      <?php
        $all_categories = ['Dog', 'Cat', 'Fish', 'Reptile', 'Bird', 'Small Animal'];
        foreach ($all_categories as $cat) {
          $checked = in_array($cat, $_GET['category'] ?? []) ? 'checked' : '';
          echo "<label><input type='checkbox' name='category[]' value='$cat' $checked> " . ucfirst($cat) . "</label><br>";
        }
      ?>
    </div> <br>

    <!-- Price Range -->
    <div class="filter-section">
      <h3>Price Range</h3>
      <input type="number" name="min_price" placeholder="Min" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>"> <br> <br>
      <input type="number" name="max_price" placeholder="Max" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
    </div> <br> <br>

      <!-- Currency Converter-->
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
    

    <!-- Submit Buttons -->
    <button type="submit" class="apply-btn">Apply</button>
    <button type="button" onclick="window.location='product.php'" class="reset-btn">Reset All Filters</button>
  </form>

  <!-- Product Display -->
  <div class="gallery">
    <?php
    // Fetch Filters
    $search = $_GET['search'] ?? '';
    $categories = $_GET['category'] ?? [];
    $min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
    $max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 0;
    $rating = isset($_GET['rating']) ? (int)$_GET['rating'] : 0;

    // Build Query
    $sql = "SELECT * FROM products WHERE 1=1 ";
    $params = [];
    $types = "";

    if ($search !== '') {
        $sql .= " AND product_name LIKE ? ";
        $params[] = "%$search%";
        $types .= "s";
    }

    if (!empty($categories)) {
        $placeholders = implode(',', array_fill(0, count($categories), '?'));
        $sql .= " AND product_category IN ($placeholders) ";
        foreach ($categories as $cat) {
            $params[] = $cat;
            $types .= "s";
        }
    }

    if ($min_price > 0) {
        $sql .= " AND product_price >= ? ";
        $params[] = $min_price;
        $types .= "d";
    }

    if ($max_price > 0) {
        $sql .= " AND product_price <= ? ";
        $params[] = $max_price;
        $types .= "d";
    }

    if ($rating > 0) {
        $sql .= " AND product_rating >= ? ";
        $params[] = $rating;
        $types .= "i";
    }

    $sql .= " ORDER BY product_id DESC";

    $stmt = $conn->prepare($sql);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-item">';
            echo '<img src="Uploads/' . htmlspecialchars($row['file']) . '" alt="' . htmlspecialchars($row['product_name']) . '">';
            echo '<p>' . htmlspecialchars($row['product_name']) . '</p>';
            echo '<p>' . htmlspecialchars($row['product_category']) . '</p>';
            echo '<p class="product-price" data-gbp="' . htmlspecialchars($row['product_price']) . '">£' . htmlspecialchars($row['product_price']) . '</p>';
           echo '<form method="post" action="add_to_cart.php" class="add-to-cart-form">';
            echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
            echo '<input type="number" name="quantity" value="1" min="1" class="quantity-input">';
            echo '<button type="submit" class="add-to-cart-btn">Add to Cart</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found</p>';
    }

    $stmt->close();
    ?>
  </div>
</div>

<div id="cart-popup" class="popup">
  Product added to cart!
</div>


<script src="script.js"></script>
<script src="product.js"></script>

</body>
</html>
