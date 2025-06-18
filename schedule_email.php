<?php
session_start();
include 'config.php';
require 'C:/xampp/htdocs/Index/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$now = date('Y-m-d H:i:s');
echo "Current time: $now<br>";

// Send scheduled one-time emails
$stmt = $conn->prepare("SELECT * FROM scheduled_emails WHERE send_at <= ? AND sent = 0");
$stmt->bind_param("s", $now);
$stmt->execute();
$emails = $stmt->get_result();

echo "Scheduled emails found: " . $emails->num_rows . "<br>";

while ($email = $emails->fetch_assoc()) {
    echo "Sending email to: " . $email['recipient_email'] . "<br>";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'emmaplay73@gmail.com';
        $mail->Password = 'rjhl ieus utlj ofvc';  // Use env variable instead
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('emmaplay73@gmail.com', 'Yummers');
        $mail->addAddress($email['recipient_email']);
        $mail->isHTML(true);
        $mail->Subject = $email['subject'];
        $mail->Body = $email['body'];

        $mail->send();
        echo "Scheduled email sent successfully.<br>";

        $update = $conn->prepare("UPDATE scheduled_emails SET sent = 1 WHERE id = ?");
        $update->bind_param("i", $email['id']);
        $update->execute();

         header("Location: home.php"); // Redirect to home page after successful login
            exit();

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo . "<br>";
    }
}

// Send recurring delivery status emails
$yesterday = date('Y-m-d H:i:s', strtotime('-10 minute'));
$recurring = $conn->prepare("SELECT * FROM orders WHERE delivery_status != 'Delivered' AND (last_email_sent_at IS NULL OR last_email_sent_at <= ?)");
$recurring->bind_param("s", $yesterday);
$recurring->execute();
$orders = $recurring->get_result();

echo "Recurring orders to notify: " . $orders->num_rows . "<br>";

while ($order = $orders->fetch_assoc()) {
    echo "Sending delivery status to: " . $order['user_email'] . " for Order ID: " . $order['order_id'] . "<br>";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'emmaplay73@gmail.com';
        $mail->Password = 'rjhl ieus utlj ofvc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('emmaplay73@gmail.com', 'Yummers');
        $mail->addAddress($order['user_email']);
        $mail->isHTML(true);
        $mail->Subject = "Delivery Status for Order " . $order['order_id'];
        $mail->Body = "Hello, your order <b>{$order['order_id']}</b> is currently <b>{$order['delivery_status']}</b>. We will update you once it is delivered.";

        $mail->send();
        echo "Recurring status email sent.<br>";

        // Update last_email_sent_at
        // Make sure your orders table PK column is 'id' or change accordingly
        $update = $conn->prepare("UPDATE orders SET last_email_sent_at = ? WHERE id = ?");
        $update->bind_param("si", $now, $order['id']);
        $update->execute();

    } catch (Exception $e) {
        echo "Mailer Error (recurring): " . $mail->ErrorInfo . "<br>";
    }
}
?>
