<?php

session_start(); // Start the session to access session variables
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session
header("Location: admin_log.php"); // Redirect to the home page after logout
exit(); 
?>