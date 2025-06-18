<?php
session_start();
require 'config.php';

if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true || !isset($_SESSION['email'])) {
    header("Location: forgot_password.php");
    exit;
}

$message = '';
$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['confirm_password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $message = "Password should be at least 6 characters.";
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Update password in users table
        $sql = "UPDATE users SET password = '" . mysqli_real_escape_string($conn, $password_hash) . "' WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'";
        if (mysqli_query($conn, $sql)) {
            //redirect to login page
            header("Location: login.php");
            exit();
        } else {
            $message = "Failed to update password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Reset Password</title>
<link rel="stylesheet" href="forgotten.css">
</head>
<body>
<div class="container">
<h2>Reset Password</h2>
<form method="POST">
    <label for="password">New Password:</label><br/> <br>
    <input type="password" name="password" id="password" required /><br /><br />
    <label for="confirm_password">Confirm Password:</label><br /> <br>
    <input type="password" name="confirm_password" id="confirm_password" required /><br /><br />
    <input type="submit" value="Reset Password" />
</form>
<p style="color:red;"><?php echo $message; ?></p> </div>
</body>
</html>
