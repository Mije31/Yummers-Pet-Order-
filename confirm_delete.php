<?php
include 'config.php';

// Get token from URL
$token = $_GET['delete_token'] ?? '';
// echo "Token received: " . htmlspecialchars($token) . "<br>";


if (empty($token)) {
    die("Invalid or missing token.");
}

// Verify token and check if it's not expired
$sql = "SELECT id FROM users WHERE delete_token = ? AND token_expiry > NOW() LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $user_id = $row['id'];

    // Delete user from the database
    $delete = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete->bind_param("i", $user_id);
    
    if ($delete->execute()) {
        echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Account Permanently Deleted</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f6f8;
                text-align: center;
                padding: 50px;
            }
            .container {
                background-color: #fff;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                max-width: 500px;
                margin: auto;
            }
            h2 {
                color: #2c3e50;
            }
            p {
                color: #555;
                font-size: 16px;
            }
            a {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #3498db;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            a:hover {
                background-color: #2980b9;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Account Permanently Deleted</h2>
            <p>Account succesfully deleted, Sorry to see you go.</p>
            <a href='homes.php'>Back to Home</a>
        </div>
    </body>
    </html>
    ";
        
    } else {
        echo "<h3>Failed to delete account. Please try again.</h3>";
    }

    $delete->close();
} else {
    echo "<h3>Invalid or expired token. Please request a new deletion link.</h3>";
}

$stmt->close();
$conn->close();
?>

  
    
