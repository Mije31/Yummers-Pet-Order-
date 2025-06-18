<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: admin_log.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Delete product
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    // Redirect back with success
    header("Location: remove_product_form.php");
    exit();
} else {
    echo "Invalid request.";
}
