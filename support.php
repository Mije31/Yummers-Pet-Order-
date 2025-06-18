<?php
include 'config.php'; // Include the database configuration file
session_start(); // Start the session
if (!isset($_SESSION['email'])) {
    // You should redirect to login page here
    // header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yummers</title>
  <link rel="stylesheet" href="support.css">
  <script src="script.js"></script>
  <!-- Removed script tag here - we'll add it at the end of the body -->
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

      <nav class="sidebarnav">
        <ul>
          <li><a href="home.php"><span class="icon">Home</span></a></li>
          <li><a href="#"><span class="icon">Food Subscriptions</span></a></li>
          <li><a href="product.php"><span class="icon">Products A-Z</span></a></li>
          <li><a href="delivery.php"><span class="icon">Track Your Delivery</span></a></li>
          <li><a href="#"><span class="icon">Chat with us</span></a></li>
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

  <!-- Main Content -->
  <div class="hero-content">
    <h1>Where's my order?</h1>
    <div class="form-container">
        <input type="email" placeholder="Email address *" required>
        <input type="text" placeholder="Order number *" required>
        <button>Track my order</button>
    </div>
  </div>

  <div class="common-questions">
    <h2>Common questions</h2>

    <div class="tabs">
        <div class="tab active" onclick="showForm('collection-delivery')">Collection & Delivery</div>
        <div class="tab" onclick="showForm('refunds-returns')">Refunds & Returns</div>
        <div class="tab" onclick="showForm('pets-club')">Pets Club</div>
        <div class="tab" onclick="showForm('subscription-repeat-orders')">Subscription & Repeat Orders</div>
        <div class="tab" onclick="showForm('website-app-support')">Website & App Support</div>
        <div class="tab" onclick="showForm('pets')">Pets</div>
        <div class="tab" onclick="showForm('other')">Other</div>
    </div>

    <div class="faq-list" id="collection-delivery">
        <div class="faq-item">
            <div class="faq-question">
                <span>1. Where is my order?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>To track your order, you have a couple of convenient options:</p>
                <ul>
                    <li>Already Signed In? Just head over to 'My Account' and find your order details there.</li>
                    <li>Not signed in or guest order? Use the tracking feature <a href="#">here</a>. Just make sure to have your order number and email address ready.</li>
                </ul>
                <p>And don't forget, if you're browsing our support page, you can use the handy 'Where is My Order' section to quickly track your order by entering your order number and email address.</p>
                <p>We are currently transitioning to our new warehouse, and there may be a delay to a small number of orders. Please bear with us during this time.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>2. How long do home delivery orders take?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>Our standard home delivery typically takes 2-4 business days from the time your order is processed. Premium delivery options are available at checkout for faster service.</p>
                <p>Please note that delivery times may vary based on your location and current demand. During peak periods and holidays, delivery might take slightly longer.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>3. How long does Click & Collect take?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>Our Click & Collect service is usually ready within 2 hours during store opening hours for in-stock items. You'll receive a confirmation email when your order is ready for collection.</p>
                <p>For orders placed outside of store hours, your items will be ready for collection when the store next opens.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>4. How long do I have to collect my Click & Collect order?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>You have 7 days to collect your Click & Collect order from the time you receive the "ready for collection" notification.</p>
                <p>If you're unable to collect within this timeframe, please contact our customer service team, and we can arrange to hold your order for longer.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>5. Can I book a delivery slot?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>Yes, you can book a specific delivery slot during checkout for an additional fee. We offer morning, afternoon, and evening slots on most weekdays.</p>
                <p>Premium delivery services with time-specific slots are available in selected postcodes. Enter your postcode during checkout to see available options.</p>
            </div>
        </div>
    </div>

    <div class="faq-list" id="refunds-returns" style="display: none;">
        <div class="faq-item">
            <div class="faq-question">
                <span>1. What is your return policy?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>Our return policy allows you to return most items within 30 days of purchase for a full refund or exchange, provided they are in their original condition with all tags and packaging intact. Certain perishable goods or personalized items may not be eligible for return. Please see our full <a href="#">Returns & Exchanges</a> policy for details.</p>
            </div>
        </div>
        </div>

    <div class="faq-list" id="pets-club" style="display: none;">
        <div class="faq-item">
            <div class="faq-question">
                <span>1. What are the benefits of joining the Pets Club?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>As a member of our Pets Club, you'll enjoy a range of exclusive benefits, including discounts on selected products, early access to sales and promotions, personalized recommendations based on your pet's needs, and invitations to special events. You'll also earn points on every purchase, which can be redeemed for future discounts. Learn more and <a href="#">join the Pets Club today</a>!</p>
            </div>
        </div>
        </div>

    <div class="faq-list" id="subscription-repeat-orders" style="display: none;">
        <div class="faq-item">
            <div class="faq-question">
                <span>1. How do subscriptions work?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>Our subscription service allows you to schedule regular deliveries of your pet's favorite items, ensuring you never run out. Simply select the subscription option on eligible product pages and choose your preferred delivery frequency. You'll receive a discount on every subscription order, and you can easily manage or cancel your subscriptions at any time through your account. <a href="#">Explore our subscription options</a>.</p>
            </div>
        </div>
        </div>

    <div class="faq-list" id="website-app-support" style="display: none;">
        <div class="faq-item">
            <div class="faq-question">
                <span>1. I'm having trouble logging into my account. What should I do?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>If you're having trouble logging in, please ensure that you've entered your email address and password correctly. If you've forgotten your password, you can use the "Forgot Password" link on the login page to reset it. If you continue to experience issues, please contact our customer support team via our <a href="#">contact form</a> or by phone at [Phone Number].</p>
            </div>
        </div>
        </div>

    <div class="faq-list" id="pets" style="display: none;">
        <div class="faq-item">
            <div class="faq-question">
                <span>1. What types of pets do you offer products for?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>We offer a wide variety of products for dogs, cats, small animals (like hamsters and rabbits), fish, reptiles, and birds & wildlife. You can browse our shop by pet type to find exactly what you need.</p>
            </div>
        </div>
        </div>

    <div class="faq-list" id="other" style="display: none;">
        <div class="faq-item">
            <div class="faq-question">
                <span>1. How can I contact customer service?</span>
                <div class="icon">+</div>
            </div>
            <div class="faq-answer">
                <p>You can contact our customer service team through several channels. Please visit our <a href="#">Contact Us</a> page for our phone number, email address, and a contact form. Our team is available during [Business Hours] to assist you with any questions or concerns.</p>
            </div>
        </div>
        </div>
</div>

 <div class="chat-container">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" width="150" height="200">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
</svg>
        
        <h1 class="chat-title">Live chat</h1>
        
        <p class="chat-description">Our Pets Experts are ready to answer your questions.</p>
        
        <button class="btn-chat" onclick ="support()" >Chat now</button>
        
        <p class="availability-label">Live chat available:</p>
        
        <table class="hours-table">
            <tr>
                <td>Monday - Friday</td>
                <td>9am - 8pm</td>
            </tr>
            <tr>
                <td>Saturday</td>
                <td>9am - 6pm</td>
            </tr>
            <tr>
                <td>Sunday</td>
                <td>9am - 6pm</td>
            </tr>
            <tr>
                <td>Bank holidays</td>
                <td>9am - 6pm</td>
            </tr>
        </table>
    </div>
    
    <!-- Help Categories Section -->
    <section class="help-section">
        <h2>Home of help</h2>
        <p>Have a look below we are sure you will find what you are looking for.</p>
        
        <div class="help-categories">
            <!-- First row of categories -->
            <div class="category-card">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#0072b0">
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                    </svg>
                </div>
                <div class="delivery" onclick = "delivery()"><h3 class="category-title">Collection & Delivery</h3>
                <div  class="category-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
            </div></div>
            </div>
            
            <div class="category-card">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#0072b0">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                    </svg>
                </div>
                <div class="refunds" onclick = "refunds()"><h3 class="category-title">Refunds & Returns</h3>
                <div class="category-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
</div>
            </div></div>
            
            <div class="category-card">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#0072b0">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                        <path d="M12 7v6l2.25 2.25.75-.75L13.5 13V7z"/>
                    </svg>
                </div>
                <div class="subscription" onclick = "subscription()"><h3 class="category-title">Subscriptions & Repeat Orders</h3>
                <div class="category-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
</div>
            </div></div>
            
            <!-- Second row of categories -->
            <div class="category-card">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#0072b0">
                        <path d="M4.5 9.5C5.88 9.5 7 10.62 7 12s-1.12 2.5-2.5 2.5S2 13.38 2 12s1.12-2.5 2.5-2.5zM9 12c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3zm1.5-4.5c1.38 0 2.5 1.12 2.5 2.5s-1.12 2.5-2.5 2.5S8 11.38 8 10s1.12-2.5 2.5-2.5zm4.5 0c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3zm2.5 4.5c1.38 0 2.5 1.12 2.5 2.5s-1.12 2.5-2.5 2.5-2.5-1.12-2.5-2.5 1.12-2.5 2.5-2.5zm4.5 0c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3z"/>                    
                    </svg>
                </div>
                <div class="pets" onclick = "petsclub()"><h3 class="category-title">Pets Club</h3>
                <div class="category-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
                </div>
            </div></div>
            
            <div class="category-card">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#0072b0">
                        <path d="M4.5 9.5C5.88 9.5 7 10.62 7 12s-1.12 2.5-2.5 2.5S2 13.38 2 12s1.12-2.5 2.5-2.5zM9 12c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3zm6 0c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3zm6 0c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3z"/>
                    </svg>
                </div>
                <h3 class="category-title">Pets</h3>
                <a href="#" class="category-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
                </a>
            </div>
            
            <div class="category-card">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#0072b0" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
</svg>
                </div>
                <h3 class="category-title">Website & App Support</h3>
                <a href="#" class="category-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
                </a>
            </div>
            
            <div class="category-card">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#0072b0">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/>
                    </svg>
                </div>
                <h3 class="category-title">Other</h3>
                <a href="#" class="category-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
                </a>
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

<script src="support.js"></script> 
 
</body>
</html>