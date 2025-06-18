<?php
include 'config.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If you installed via Composer, include autoload
require 'C:/xampp/htdocs/Index/vendor/autoload.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current hashed password from DB
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify old password
    if (!password_verify($current_password, $hashed_password)) {
        echo "<script>alert('Current password is incorrect.'); window.history.back();</script>";
        exit();
    }

    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New passwords do not match.'); window.history.back();</script>";
        exit();
    }

    // Update password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $update_stmt->bind_param("ss", $new_hashed_password, $email);

    if ($update_stmt->execute()) {
        // Send email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
             
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Use Gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'emmaplay73@gmail.com'; // Your Gmail address
    $mail->Password = 'rjhl ieus utlj ofvc';    // Your Gmail App Password (see note below)
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;                            // TCP port to connect to

            // Recipients
            $mail->setFrom('emmaplay73@gmail.com', 'Yummers');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Password Has Been Changed';
            $mail->Body    = "
                <p>Hello,</p>
                <p>This is a confirmation that your password has been successfully updated.</p>
                <p>If you did not make this change, please contact support immediately.</p>
                <p>Regards,<br>Your Site Team</p>
            ";
            $mail->AltBody = "Hello,\n\nThis is a confirmation that your password has been successfully updated.\n\nIf you did not make this change, please contact support immediately.\n\nRegards,\nYummers";

            $mail->send();

            echo "<script>
                    alert('Password updated successfully. A confirmation email has been sent.');
                    window.location.href = 'profile.php';
                  </script>";
        } catch (Exception $e) {
            // Email sending failed, but password updated
            echo "<script>
                    alert('Password updated, but email could not be sent. Mailer Error: {$mail->ErrorInfo}');
                    window.location.href = 'profile.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Error updating password.');
                window.history.back();
              </script>";
    }

    $update_stmt->close();
    $conn->close();
}
?>
