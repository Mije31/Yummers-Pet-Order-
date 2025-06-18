<?php
session_start();
require 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:/xampp/htdocs/Index/vendor/autoload.php';

$message = '';

$sendTime = date('Y-m-d H:i:s', strtotime('+2 hours')); // or any delay you want
$stmt = $conn->prepare("INSERT INTO scheduled_emails (recipient_email, subject, body, send_at) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $email, $subject, $message, $sendTime);
$stmt->execute();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        $message = "Email not registered.";
    } else {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Insert OTP record
        $sql_insert = "INSERT INTO password_resets (email, otp, expires_at, used) VALUES ('$email', '$otp', '$expires_at', 0)";
        mysqli_query($conn, $sql_insert);

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
    
// Set email format to HTML
    $mail->setFrom('emmaplay73@gmail.com', 'Yummers');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset OTP';
    $mail->Body = "Your OTP is: $otp. It expires in 10 minutes.";
    $mail->send();

    $_SESSION['email'] = $email;
    header("Location: verify_otp.php");
} catch (Exception $e) {

    $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Forgot Password</title>
<link rel="stylesheet" href="forgotten.css">
</head>
<body>
    <div class="container">
<h2>Forgot Password</h2>
<form method="POST">
    <p style="color:red;"><?php echo $message; ?></p>
    <label for="email">Enter your registered email:</label> <br><br/>
    <input type="email" name="email" placeholder="Enter email address" id="email" required /><br /><br />
    <button type="submit" name="register">Send OTP</button>
    <p>Back to <a href="login.php">Login</a></p></div>
</form>

</body>
</html>
