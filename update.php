<?php
session_start();
require_once 'config.php'; // Include the database configuration file


// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $first_name = sanitize_input($_POST['first_name']);
    $last_name = sanitize_input($_POST['last_name']);
    $phone_number = sanitize_input($_POST['phone_number']);
    $email = sanitize_input($_POST['email']);
    $address = sanitize_input($_POST['address']);

    // Validate input data (ROBUST VALIDATION)
    if (empty($first_name)) {
        $_SESSION['update_error'] = "First name is required";
        header("Location: profile.php");
        exit();
    }
    if (empty($last_name)) {
        $_SESSION['update_error'] = "Last name is required";
        header("Location: profile.php");
        exit();
    }
    if (empty($phone_number)) {
        $_SESSION['update_error'] = "Phone number is required";
        header("Location: profile.php");
        exit();
    }
    if (empty($email)) {
        $_SESSION['update_error'] = "Email is required";
        header("Location: profile.php");
        exit();
    }
    if (empty($address)) {
        $_SESSION['update_error'] = "Address is required";
        header("Location: profile.php");
        exit();
    }

    // Update the user data, include address.
    $sql = "UPDATE users SET first_name = ?, last_name = ?, phone_number = ?, address = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind parameters.  Corrected the order to match the SQL query.
    $stmt->bind_param("sssss", $first_name, $last_name, $phone_number, $address, $email);

    // Execute the statement
    if ($stmt->execute()) {
        // Update successful
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['phone_number'] = $phone_number;
        $_SESSION['email'] = $email;
        $_SESSION['address'] = $address;
        $_SESSION['update_success'] = "Profile updated successfully";
        header("Location: profile.php"); // Redirect to profile page after successful update
        exit();
    } else {
        // Update failed
        $_SESSION['update_error'] = "Failed to update profile: " . $stmt->error;
        header("Location: profile.php");
        exit();
    }
    $stmt->close();
    $conn->close();
} else {
    // If the form was not submitted
    header("Location: profile.php");
    exit();
}
?>
