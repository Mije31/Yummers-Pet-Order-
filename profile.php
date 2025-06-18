<?php
include 'config.php'; // Include the database configuration file
session_start(); // Start the session




if (isset($_SESSION['update_success'])) {
    $msg = $_SESSION['update_success'];
    echo "<script>alert('$msg');</script>";
    unset($_SESSION['update_success']);
}

if (isset($_SESSION['update_error'])) {
    $msg = $_SESSION['update_error'];
    echo "<script>alert('$msg');</script>";
    unset($_SESSION['update_error']);
}



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
  <title>Profile</title>
  <!-- <link rel="stylesheet" href="home.css"> -->
  <link rel="stylesheet" href="profile.css">
  <script src="script.js"></script>
</head>
<body >
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
      <a href="#" class="user-action">
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


    <div class="profile-sidebar">
        <div class="sidebarr-header">
            <h3>Hi <span><?php echo $_SESSION['first_name'];?></span></h3>
        </div>
        
        <a href="#" class="menu-item">
            <div class="item-content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                My account
            </div>
        </a>
        
        <a href="profile.php" class="menu-item active with-arrow">
            <div class="item-content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Personal Details
            </div>
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </a>
        
        <a href="#" class="menu-item"> 
            <div class="item-content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                    <path d="M14 2v6h6"></path>
                    <path d="M16 13H8"></path>
                    <path d="M16 17H8"></path>
                    <path d="M10 9H8"></path>
                </svg>
                My pets
            </div>
        </a>
        
        <a href="order_history.php" class="menu-item" id = "orders-tab">
            <div class="item-content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"></path>
                </svg>
                Orders
            </div>
        </a>
        
        <a href="#" class="menu-item">
            <div class="item-content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                My subscription plans
            </div>
        </a>
        
        <a href="#" class="menu-item" id="settings-tab">
            <div class="item-content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"></path>
                </svg>
                Settings
            </div>
        </a>
        
        <a href="logout.php" class="menu-item" style="color: #d63031;">
            <div class="item-content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                Sign out
            </div>
        </a>

        <a href="delete_account.php" class="menu-item"  style="color: #d63031;"  onclick="return confirm('Are you sure you want to delete your account? A conficrmation email will be sent. This action cannot be undone.');">
  <svg xmlns="http://www.w3.org/2000/svg" 
       viewBox="0 0 24 24" 
       width="20" height="20" 
       fill="none" stroke="currentColor" 
       stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="3 6 5 6 21 6"></polyline>
    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
    <path d="M10 11v6"></path>
    <path d="M14 11v6"></path>
    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
  </svg>
  Delete Account
</a>

    </div>
    
    <div class="main-contents" id="main-contents">
        <h1 class="page-title">Personal Details</h1>
        
        <div class="details-section">
            <h2 class="section-title">Contact details</h2>
            <div class="detaill-card">
                <div><?php echo $_SESSION['first_name'];?> <?php echo $_SESSION['last_name'];?></div>
                <div class="contact-info"><?php echo $_SESSION['phone_number'];?></div>
                <div class="contact-info"><?php echo $_SESSION['email'];?></div>
                <a href="#" class="edit-button" >
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
        
        <div class="details-section">
            <h2 class="section-title">My address</h2>
            <div class="detaill-card">
                <div class="tag">Default</div>
                <div><?php echo $_SESSION['first_name'];?> <?php echo $_SESSION['last_name'];?></div>
                <div class="contact-info"><?php echo $_SESSION['phone_number'];?></div>
                <div class="address-info"><?php echo $_SESSION['address'];?></div>
                
            </div>
            
            <a href="#" class="add-button">
                Add an address
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
            </a>
        </div> <br>

<form action="update.php" method="POST">
    <div class="form-group" id="contact-details">
        <label class="form-label">First name <span class="required">*</span></label>
        <div class="input-wrapper">
            <input type="text" name="first_name" class="form-input error" placeholder="First name" value="<?php echo $_SESSION['first_name']; ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label">Last name <span class="required">*</span></label>
        <div class="input-wrapper">
            <input type="text" name="last_name" class="form-input error" placeholder="Last name" value="<?php echo $_SESSION['last_name']; ?>">
        </div>
        <div class="error-message"></div>
    </div>
    
    <div class="form-group">
        <label class="form-label">Mobile number <span class="required">*</span></label>
        <div class="input-wrapper">
            <input type="tel" name="phone_number" class="form-input error" placeholder="+447565733004" value="<?php echo $_SESSION['phone_number']; ?>">
        </div>
        <div class="error-message"></div>
    </div>
    
    <div class="form-group">
        <label class="form-label">Email address</label>
        <input type="email" name="email" class="form-input" value="<?php echo $_SESSION['email']; ?>">
    </div>

     <div class="form-group">
        <label class="form-label">Home Address</label>
        <input type="text" name="address" class="form-input" value="<?php echo $_SESSION['address']; ?>">
    </div>
    
    <button type="submit" class="save-button">Save</button>
    <button  class="cancel-button">Cancel</button>
</form>   

<div class="details-section" id="settings-section">
  <h2 class="section-title">Change Password</h2>
  <form action="update_password.php" method="POST">
    <div class="form-group">
      <label for="current_password">Current Password</label>
      <input type="password" name="current_password" class="form-input" required>
    </div>

    <div class="form-group">
      <label for="new_password">New Password</label>
      <input type="password" name="new_password" class="form-input" required>
    </div>

    <div class="form-group">
      <label for="confirm_password">Confirm New Password</label>
      <input type="password" name="confirm_password" class="form-input" required>
    </div>

    <button type="submit" class="save-button">Update Password</button>
  </form>
</div>


    </div>

    
    
<script src="profile.js"></script>

</body>
</html>