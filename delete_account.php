<?php
include 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require 'C:/xampp/htdocs/Index/vendor/autoload.php'; // Adjust path if file is in subfolder


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$user_id = $_SESSION['id'];
$user_email = $_SESSION['email'];

// Generate token
$token = bin2hex(random_bytes(32));
$token_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

// Save token in DB
$sql = "UPDATE users SET delete_token = ?, token_expiry = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $token, $token_expiry, $user_id);
$stmt->execute();
$stmt->close();

// Send confirmation email with Outlook SMTP
$mail = new PHPMailer(true);

try {
    // $mail->SMTPDebug = 2; // Set to 2 for verbose debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'emmaplay73@gmail.com';        // Replace with your Outlook email
    $mail->Password = 'rjhl ieus utlj ofvc';  // Use App Password if 2FA is enabled
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('emmaplay73@gmail.com', 'Yummers'); 
    $mail->addAddress($user_email);

   $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$domain = $_SERVER['HTTP_HOST'];
$delete_link = "$protocol://$domain/Index/confirm_delete.php?delete_token=$token";

    $mail->isHTML(true);
    $mail->Subject = 'Confirm Account Deletion';
    $mail->Body = "Click the link below to permanently delete your account:<br><br>
                   <a href='$delete_link'>$delete_link</a><br><br>
                   This link will expire in 1 hour.<br>If you did not request this, ignore the email.";

    $mail->send();

      echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Email Sent</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f6f8;
                text-align: center;
                padding: 50px;
            }
            .container {
                background-color: #fff;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                max-width: 500px;
                margin: auto;
            }
            h2 {
                color: #2c3e50;
            }
            p {
                color: #555;
                font-size: 16px;
            }
            a {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #3498db;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            a:hover {
                background-color: #2980b9;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Confirmation Email Sent</h2>
            <p>A confirmation email has been sent to <strong>$user_email</strong>.</p>
            <p>Please check your inbox and follow the link to delete your account.</p>
            <a href='homes.php'>Back to Home</a>
        </div>
    </body>
    </html>
    ";


    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

//  header("Location: homes.php"); // Redirect to profile page after successful update
//     exit();

$conn->close();
?>
