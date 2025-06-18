<?php
require 'vendor/autoload.php'; // Adjust path if needed

use Dotenv\Dotenv;
use Stripe\Stripe;

session_start();
include 'config.php';

// Load .env for Stripe keys
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Set Stripe Secret Key
Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// Validate form POST data
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['name'], $_POST['email'], $_POST['address'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid form submission.']);
    exit();
}

// Collect form data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$address = trim($_POST['address']);

// Retrieve cart from session
if (empty($_SESSION['cart'])) {
    echo json_encode(['status' => 'error', 'message' => 'Cart is empty or total is zero.']);
    exit();
}

// Calculate total from database
function calculateCartTotalGBP($conn) {
    $total = 0;
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $conn->prepare("SELECT product_price FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($product = $result->fetch_assoc()) {
            $total += $product['product_price'] * $quantity;
        }
    }
    return $total * 100; // Convert to pence
}

// Currency handling
$currency = $_COOKIE['currency'] ?? 'GBP';
$allowedCurrencies = ['GBP', 'USD', 'EUR', 'INR', 'JPY', 'NGN', 'CAD'];
if (!in_array($currency, $allowedCurrencies)) {
    $currency = 'GBP';
}

// Optional: convert to other currencies
function convertCurrency($amountPence, $targetCurrency) {
    if ($targetCurrency === 'GBP') return $amountPence;

    $response = @file_get_contents("https://api.exchangerate-api.com/v4/latest/GBP");
    if ($response === false) return $amountPence;

    $data = json_decode($response, true);
    if (!isset($data['rates'][$targetCurrency])) return $amountPence;

    $rate = $data['rates'][$targetCurrency];
    return round($amountPence * $rate);
}

$cartTotalGBP = calculateCartTotalGBP($conn);
if ($cartTotalGBP <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Cart is empty or total is zero.']);
    exit();
}

$convertedAmount = convertCurrency($cartTotalGBP, $currency);

try {
    $intent = \Stripe\PaymentIntent::create([
        'amount' => $convertedAmount,
        'currency' => strtolower($currency),
        'receipt_email' => $email,
        'description' => 'Yummers Pet Food Order',
        'metadata' => [
            'customer_name' => $name,
            'customer_address' => $address
        ]
    ]);

    echo json_encode([
        'status' => 'success',
        'clientSecret' => $intent->client_secret,
        'message' => 'Payment initialized. Complete payment on frontend.'
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Stripe error: ' . $e->getMessage()]);
}
?>
