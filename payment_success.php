<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require 'C:/xampp/htdocs/Index/vendor/autoload.php'; // Adjust path if file is in subfolder


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_SESSION['email'];

// Generate a unique Order ID
$order_id = uniqid('ORD-');
$_SESSION['order_id'] = $order_id;

// Fetch all items from the cart
$stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];

    // Get product price
    $price_stmt = $conn->prepare("SELECT product_price FROM products WHERE product_id = ?");
    $price_stmt->bind_param("i", $product_id);
    $price_stmt->execute();
    $product = $price_stmt->get_result()->fetch_assoc();

    $price = $product['product_price'];
    $total_price = $price * $quantity;

    // Insert order
    $insert_stmt = $conn->prepare("INSERT INTO orders (order_id, user_email, product_id, quantity, total_price) VALUES (?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("ssiid", $order_id, $email, $product_id, $quantity, $total_price);
    $insert_stmt->execute();

}

// Clear the cart
$delete_stmt = $conn->prepare("DELETE FROM cart WHERE user_email = ?");
$delete_stmt->bind_param("s", $email);
$delete_stmt->execute();

unset($_SESSION['cart']);





$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Use Gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'emmaplay73@gmail.com'; // Your Gmail address
    $mail->Password = 'rjhl ieus utlj ofvc';    // Your Gmail App Password (see note below)
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('emmaplay73@gmail.com', 'Yummers');
    $mail->addAddress($email); // User's email from session

    // Content

   $message = "
    <h2>Thank you for your order!</h2>
    <p>Your payment was successful, and your order has been placed.</p>
    <p><strong>Order ID:</strong> $order_id</p>
    <br>
    <p>Regards,<br>Yummers Team</p>
";
    
    $mail->isHTML(true);
    $mail->Subject = 'Order Confirmation - Yummers';
    $mail->Body = $message;

    $mail->send();
} catch (Exception $e) {
    error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
}



?>
<!-- Display confirmation page -->
<style>
    body {
        background: #f9fafb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .container {
        background: white;
        padding: 30px 40px;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        max-width: 420px;
        text-align: center;
    }
    h2 {
        color: #2c3e50;
        margin-bottom: 15px;
    }
    p {
        font-size: 1.1rem;
        color: #555;
        margin: 10px 0;
    }
    .order-id {
        font-weight: 700;
        color: #27ae60;
        font-size: 1.25rem;
        margin: 15px 0 30px;
    }
    a.button {
        display: inline-block;
        padding: 12px 30px;
        background-color: #3498db;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease;
        font-size: 1rem;
    }
    a.button:hover {
        background-color: #2980b9;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Payment Successful!</h2>
    <p>Your order has been placed.</p>
    <p class="order-id">Order ID: <?php echo htmlspecialchars($order_id); ?></p>
    <a href="home.php" class="button" action="schedule_email.php">Return to Home</a>
</div>

</body>
</html>

