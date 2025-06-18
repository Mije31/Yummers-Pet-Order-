<?php 
include ("config.php"); // Include the database configuration file
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset(); // Clear session variables after using them

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-box <?= isActiveForm('login', $activeForm);?>" id="login-form">
            <form method="post" action="login_register.php">
                <h2>Login</h2>
                <?= showError($errors['login']) ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit"name ="login" >Login</button>
                <p>Don't have an account? <a href="#" onclick="showForm('register-form')" >Register</a></p>
                <p>Forgotten Password <a href="forgotten_password.php">Click Here</a></p>
                <p>Back <a href="homes.php">Home</a></p>
            </form>
        </div>

        <div class="form-box <?= isActiveForm('register', $activeForm);?>"  id="register-form">
            <form method="post" action="login_register.php" >
                <h2>Register</h2>
                <?= showError($errors['register']) ?>
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="date" name="date_of_birth" placeholder="Birth Date" required>
                <input type="text" name="address" placeholder="Address" required>
                <input type="number" name="phone_number" placeholder="Phone Number" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <!-- <select name="city"required>
                    <option value="">City</option>
                    <option value="new-york">New York</option>
                    <option value="los-angeles">Los Angeles</option>
                </select> -->
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')" >Login</a></p>
            </form>
        </div>
    </div>
    
    <script src="login.js"></script>
</body>
</html>