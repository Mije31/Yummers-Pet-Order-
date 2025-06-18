<?php
session_start();
require 'config.php';

$message = '';

if (!isset($_SESSION['email'])) {
    header("Location: forgot_password.php");
    exit;
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
    $user_otp = mysqli_real_escape_string($conn, trim($_POST['otp']));

    $sql = "SELECT * FROM password_resets 
            WHERE email = '$email' AND otp = '$user_otp' AND used = 0 AND expires_at > NOW() 
            ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Mark OTP as used
        $id = $row['id'];
        mysqli_query($conn, "UPDATE password_resets SET used = 1 WHERE id = $id");

        $_SESSION['otp_verified'] = true;
        header("Location: reset_password.php");
        exit;
    } else {
        $message = "Invalid or expired OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Verify OTP</title>
<link rel="stylesheet" href="forgotten.css">
</head>
<body>
    <div class="container">
<h2>Verify OTP</h2>
<p>OTP has been sent to your email: <?php echo htmlspecialchars($email); ?></p>
<p style="color:red;"><?php echo $message; ?></p>
<form method="POST">
    <label for="otp">Enter OTP:</label><br />
    <input type="text" name="otp" id="otp" required /><br /><br />
    <input type="submit" value="Verify OTP" />
</form> </div>

</body>
</html>
