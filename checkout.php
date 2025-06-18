<?php
session_start();
include 'config.php';

if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$currency = $_SESSION['currency'] ?? 'GBP';
$cart = $_SESSION['cart'];
$total = 0;
$items = [];

foreach ($cart as $product_id => $quantity) {
    $stmt = $conn->prepare("SELECT product_name, product_price FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    $subtotal = $product['product_price'] * $quantity;
    $total += $subtotal;

    $items[] = [
        'id' => $product_id,
        'name' => $product['product_name'],
        'price' => $product['product_price'],
        'quantity' => $quantity,
        'subtotal' => $subtotal
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="checkout.css">
  <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
  <div class="checkout-container">
    <h1>Checkout</h1>

    <form id="payment-form" class="checkout-form">
      <div class="section">
        <h2>Billing Information</h2>
        <label>
          Full Name
          <input type="text" name="name" required>
        </label>
        <label>
          Email Address
          <input type="email" name="email" required>
        </label>
        <label>
          Address
          <textarea name="address" rows="3" required></textarea>
        </label>
      </div>

      <div class="section">
        <h2>Order Summary</h2>
        <ul class="order-summary">
          <?php foreach ($items as $item): ?>
            <li>
              <span><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></span>
              <span><?= $currency ?> <?= number_format($item['subtotal'], 2) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="order-total">
          <strong>Total:</strong>
          <strong><?= $currency ?> <?= number_format($total, 2) ?></strong>
        </div>
      </div>

      <div class="section">
        <h2>Card Details</h2>
        <div id="card-element" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></div>
        <div id="card-errors" style="color: red; margin-top: 5px;"></div>
      </div>

      <div class="section">
        <button type="submit" class="pay-btn">Pay Now</button> 
        
      </div>
      
    </form>
    <a href="cart.php"><button class="pay-btn">Cancel</button></a>
  </div>

  <script>
    const stripe = Stripe('pk_live_51QLVd7KsqidmZvbDYvU1yUZTrMAKlv5YbSALhoidFAfAYMzZ1remNPSVkvbi9K3GaN6w1AgYzaYU5yrWMMPqhSKY00KCVFqrO5'); // Replace with your actual Stripe publishable key
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    card.on('change', function(event) {
        document.getElementById('card-errors').textContent = event.error ? event.error.message : '';
    });

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const name = form.name.value;
        const email = form.email.value;
        const address = form.address.value;

        const response = await fetch('process_payment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ name, email, address })
        });

        const data = await response.json();
        if (data.status !== 'success') {
            alert(data.message);
            return;
        }

        const { error, paymentIntent } = await stripe.confirmCardPayment(data.clientSecret, {
            payment_method: {
                card: card,
                billing_details: {
                    name: name,
                    email: email,
                    address: {
                        line1: address
                    }
                }
            }
        });

        if (error) {
            alert('Payment failed: ' + error.message);
        } else if (paymentIntent.status === 'succeeded') {
            alert('✅ Payment successful!');
            window.location.href = 'payment_success.php'; // Optional: redirect to a thank-you page
        }
    });
  </script>
</body>
</html>
