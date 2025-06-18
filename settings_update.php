<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $marketing_emails = $_POST['marketing_emails'] ?? 'no';
    $dark_mode = isset($_POST['dark_mode']) ? 'on' : 'off';

    if (!empty($new_password) && $new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $email = $_SESSION['email']; // assuming email is unique

        $sql = "UPDATE users SET password = ?, marketing_emails = ?, dark_mode = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $hashed_password, $marketing_emails, $dark_mode, $email);

        if ($stmt->execute()) {
            $_SESSION['marketing_emails'] = $marketing_emails;
            $_SESSION['dark_mode'] = $dark_mode;
            header("Location: profile.php");
            exit;
        } else {
            echo "Error updating settings.";
        }
    } else {
        echo "Passwords do not match or are empty.";
    }
}
?>
