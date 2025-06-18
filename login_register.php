<?php

session_start();
require_once 'config.php';

if (isset($_POST['register'])) {//check if the variable is set
    $user_id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    


$checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'"); //check if the email already exists in the database
if ($checkEmail-> num_rows > 0 ){
    $_SESSION['register_error'] = "Email already exists!";
    $_SESSION['active_form'] = 'register';
} else{
    $conn->query("INSERT INTO users (first_name, last_name, date_of_birth, address, phone_number, email, password) VALUES ('$first_name','$last_name', '$date_of_birth', '$address', '$phone_number', '$email', '$password')");
}

header("Location: login.php");
exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) { // Check if the email exists in the database
        $user = $result->fetch_assoc(); // Fetch the user data
        if (password_verify($password, $user['password'])) {
           $_SESSION['first_name'] = $user['first_name']; //store the name in session
            $_SESSION['last_name'] = $user['last_name']; //store the name in session
            $_SESSION['date_of_birth'] = $user['date_of_birth']; //store the date in session
            $_SESSION['address'] = $user['address']; //store the address in session
            $_SESSION['phone_number'] = $user['phone_number']; //store the phone number in session
            $_SESSION['email'] = $user['email'];
            $_SESSION['id'] = $user['id']; //store the id in session

            header("Location: home.php"); // Redirect to home page after successful login
            exit();
        }
    } 
    $_SESSION['login_error'] = "Invalid email or password!";
    $_SESSION['active_form'] = 'login';
    header("Location: login.php");
    exit();
}


$sql = "UPDATE users SET first_name = ?, last_name = ?, date_of_birth = ?, address = ?, phone_number = ? WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssssss", $first_name, $last_name, $date_of_birth, $address, $phone_number, $email);

// Execute the statement
if ($stmt->execute()) {
    // Update successful
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['date_of_birth'] = $date_of_birth;
    $_SESSION['address'] = $address;
    $_SESSION['phone_number'] = $phone_number;
    $_SESSION['email'] = $email;
    header("Location: profile.php"); // Redirect to profile page after successful update
    exit();
} else {
    // Update failed
    $_SESSION['update_error'] = "Failed to update profile: " . $stmt->error;
}

// Assuming user is verified (e.g., after password_verify)
$_SESSION['user_id'] = $user['user_id']; // Store user ID in session
$session_id = session_id();         // Get the current session ID
$user_id = $user['user_id'];

// Store session ID in the database


$sql = "INSERT INTO user_session (session_id, user_id, session_date) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $session_id, $user_id);
if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->execute();


$stmt->close();
$conn->close();
?>




