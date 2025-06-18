<?php

session_start();
require_once 'config.php';



if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admin_log WHERE email = '$email'");

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

            header("Location: productupdate.php"); // Redirect to home page after successful login
            exit();
        }
    } 
    $_SESSION['login_error'] = "Invalid email or password!";
    $_SESSION['active_form'] = 'login';
    header("Location: admin_log.php");
    exit();
}