
<?php // Database configuration file
$host = "localhost";
$username = "roots";
$password = "12345";
$dbname = "usersdb";

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>


